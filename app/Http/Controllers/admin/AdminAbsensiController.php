<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\SettingAbsensi;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;

class AdminAbsensiController extends Controller
{
    // Tampilkan semua data absensi dengan filter opsional
    public function index(Request $request)
    {
        // Contoh filter: tanggal, kelas, status
        $query = Absensi::query();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Bisa ditambahkan filter kelas dengan relasi user->kelas jika perlu

        $absensis = $query->with('siswa')->paginate(20);

        return view('admin.absensi.index', compact('absensis'));
    }

    // Lihat detail absensi tertentu
    public function show($id)
    {
        $absensi = Absensi::with('siswa', 'pembuat')->findOrFail($id);

        return view('admin.absensi.show', compact('absensi'));
    }

    // Jika admin boleh mengedit status absensi
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->status = $request->status;
        $absensi->save();

        return back()->with('success', 'Status absensi berhasil diperbarui.');
    }

    // Hapus data absensi
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
    }

    public function settingForm()
    {
        $setting = SettingAbsensi::first();
        return view('admin.absensi.setting', compact('setting'));
    }
    public function settingStore(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi_lat' => 'required|numeric',
            'lokasi_long' => 'required|numeric',
            'radius_meter' => 'required|integer|min:10',
        ]);

        // Cek jika sudah ada setting
        if (SettingAbsensi::first()) {
            return redirect()->back()->with('error', 'Pengaturan sudah tersedia. Silakan reset terlebih dahulu.');
        }

        SettingAbsensi::create([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi_lat' => $request->lokasi_lat,
            'lokasi_long' => $request->lokasi_long,
            'radius_meter' => $request->radius_meter,
        ]);

        return redirect()->back()->with('success', 'Pengaturan absensi berhasil disimpan.');
    }

    public function rekapSiswa(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $kelasId = $request->get('kelas_id');

        $jumlahHari = \Carbon\Carbon::create(null, $bulan)->daysInMonth;

        // Ambil list kelas untuk dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // Ambil kelas terpilih jika ada
        $kelasTerpilih = $kelasId ? Kelas::find($kelasId) : null;

        // Ambil siswa sesuai filter kelas (atau semua jika kelas kosong)
        $siswaList = $kelasTerpilih ? $kelasTerpilih->siswa()->orderBy('name')->get() : User::where('role', 'siswa')->orderBy('name')->get();

        // Ambil data absensi siswa per tanggal (bisa query absensi sesuai kebutuhan)
        // Contoh format array: [user_id][tanggal] => status
        $absensi = Absensi::whereIn('user_id', $siswaList->pluck('id'))
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->keyBy(fn($item) => $item->tanggal)->map(fn($item) => $item->status);
            })
            ->toArray();

        return view('admin.absensi.rekap-siswa', compact('bulan', 'jumlahHari', 'kelasList', 'kelasTerpilih', 'siswaList', 'absensi'));
    }

    public function rekapGuru(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));
        $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;
        $guruList = User::where('role', 'guru')->get();

        $absensi = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->keyBy(fn($item) => $item->tanggal->format('Y-m-d'))->map->status;
            });

        return view('admin.absensi.rekap-guru', compact('guruList', 'absensi', 'bulan', 'jumlahHari'));
    }

    public function settingReset()
    {
        $setting = SettingAbsensi::first();
        if ($setting) {
            $setting->delete();
            return redirect()->back()->with('success', 'Pengaturan absensi berhasil direset.');
        }
        return redirect()->back()->with('error', 'Pengaturan absensi tidak ditemukan.');
    }
}
