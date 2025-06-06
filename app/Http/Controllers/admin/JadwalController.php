<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;use Illuminate\Support\Facades\Validator;


class JadwalController extends Controller
{
    // Menampilkan semua jadwal per kelas
    public function index()
    {
        $kelas = Kelas::with('jadwal.mapel')->get();
        $mapels = Mapel::all();

        return view('admin.jadwal.index', compact('kelas', 'mapels'));
    }

    public function store(Request $request)
    {
        $guruId = Mapel::findOrFail($request->mapel_id)->guru_id;

        $checkJadwal = Jadwal::join('mapels', 'jadwals.mapel_id', '=', 'mapels.id')
            ->where('jadwals.hari', $request->hari)
            ->where(function ($query) use ($request, $guruId) {
                $query
                    ->where('jadwals.kelas_id', $request->kelas_id)
                    ->orWhere('mapels.guru_id', $guruId); 
            })
            ->where(function ($query) use ($request) {
                $query->where('jadwals.waktu_mulai', '<', $request->waktu_selesai)->where('jadwals.waktu_selesai', '>', $request->waktu_mulai); // Cek waktu bentrok
            })
            ->exists();

        if ($checkJadwal) {
            return redirect()
                ->back()
                ->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal lain!']);
        }

        $request->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);



        Jadwal::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $guruId = Mapel::findOrFail($request->mapel_id)->guru_id;

        $jadwalBentrok = Jadwal::join('mapels', 'jadwals.mapel_id', '=', 'mapels.id')
            ->where('jadwals.hari', $request->hari)
            ->where('jadwals.id', '!=', $id)
            ->where(function ($query) use ($request, $guruId) {
                $query
                    ->where(function ($q) use ($request) {
                        $q->where('jadwals.kelas_id', $request->kelas_id);
                    })
                    ->orWhere(function ($q) use ($guruId) {
                        $q->where('mapels.guru_id', $guruId);
                    });
            })
            ->where(function ($query) use ($request) {
                $query->where('jadwals.waktu_mulai', '<', $request->waktu_selesai)->where('jadwals.waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();


        if ($jadwalBentrok) {
            return redirect()
                ->back()
                ->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal lain (guru atau kelas).']);
        }
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'waktu_mulai' => 'required|date_format:H:i:s',
            'waktu_selesai' => 'required|date_format:H:i:s|after:waktu_mulai',
        ]);

        $updated = $jadwal->update([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        if (!$updated) {
            return redirect()
                ->back()
                ->withErrors(['update' => 'Gagal memperbarui jadwal']);
        }

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    // Menghapus jadwal (untuk modal)
    public function destroy($id)
    {
        Jadwal::destroy($id);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
