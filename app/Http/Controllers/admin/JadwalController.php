<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;

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
        $request->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        $guruId = Mapel::findOrFail($request->mapel_id)->guru_id;

        $checkJadwal = Jadwal::join('mapels', 'jadwals.mapel_id', '=', 'mapels.id')
            ->where('jadwals.hari', $request->hari)
            ->where(function ($query) use ($request, $guruId) {
                $query->where('jadwals.kelas_id', $request->kelas_id)       // Cek bentrok di kelas yang sama
                    ->orWhere('mapels.guru_id', $guruId);                 // Cek bentrok karena guru yang sama
            })
            ->where(function ($query) use ($request) {
                $query->where('jadwals.waktu_mulai', '<', $request->waktu_selesai)
                    ->where('jadwals.waktu_selesai', '>', $request->waktu_mulai); // Cek waktu bentrok
            })
            ->exists();


        if ($checkJadwal) {
            return redirect()->back()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal lain!']);
        }

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
    // Validasi input
    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'mapel_id' => 'required|exists:mapels,id',
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'waktu_mulai' => 'required|date_format:H:i',
        'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
    ]);

    $jadwal = Jadwal::findOrFail($id);

    $guruId = Mapel::findOrFail($request->mapel_id)->guru_id;

    // $checkJadwal = Jadwal::join('mapels', 'jadwals.mapel_id', '=', 'mapels.id')
    //     ->where('jadwals.hari', $request->hari)
    //     ->where('jadwals.id', '!=', $id)
    //     ->where(function ($query) use ($request, $guruId) {
    //         $query->where('jadwals.kelas_id', $request->kelas_id)
    //             ->orWhere('mapels.guru_id', $guruId);
    //     })
    //     ->where(function ($query) use ($request) {
    //         $query->where('jadwals.waktu_mulai', '<', $request->waktu_selesai)
    //             ->where('jadwals.waktu_selesai', '>', $request->waktu_mulai);
    //     })
    //     ->exists();

    // if ($checkJadwal) {
    //     return redirect()->back()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal lain (guru atau kelas).']);
    // }

    // Update jadwal
    $jadwal->update([
        'kelas_id' => $request->kelas_id,
        'mapel_id' => $request->mapel_id,
        'hari' => $request->hari,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
    ]);

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
}





    // Menghapus jadwal (untuk modal)
    public function destroy($id)
    {
        Jadwal::destroy($id);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
