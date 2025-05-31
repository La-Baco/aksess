<?php

namespace App\Http\Controllers\kepsek;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RekapController extends Controller
{
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

        return view('kepsek.rekap-siswa', compact('bulan', 'jumlahHari', 'kelasList', 'kelasTerpilih', 'siswaList', 'absensi'));
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

        return view('kepsek.rekap-guru', compact('guruList', 'absensi', 'bulan', 'jumlahHari'));
    }
}
