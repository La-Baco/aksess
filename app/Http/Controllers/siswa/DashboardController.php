<?php

namespace App\Http\Controllers\siswa;

use App\Models\HariLibur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelas = $user->kelas; // relasi belongsTo atau belongsToMany (cek di model)

        // Ambil wali kelas pertama, karena guruWali adalah belongsToMany
        $waliKelas = $kelas ? $kelas->guruWali()->first() : null;

        // Mapping hari Inggris ke Bahasa Indonesia
        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariIni = now()->format('l');
        $namaHari = $hariMap[$hariIni] ?? $hariIni;

        // Jadwal hari ini (relasi jadwal sudah ada di model kelas)
        $jadwalHariIni = $kelas
            ? $kelas->jadwal()
                ->with(['mapel', 'mapel.guru'])
                ->where('hari', $namaHari)
                ->orderBy('waktu_mulai')
                ->get()
            : collect();

        // Jumlah mata pelajaran di kelas (relasi mapel via jadwal)
        $jumlahMapel = $kelas ? $kelas->mapel()->count() : 0;

        // Total absensi dengan status tertentu (pastikan relasi di User model bernama absensi())
        $totalHadir = $user->absensi()->where('status', 'hadir')->count();
        $totalIzin = $user->absensi()->where('status', 'izin')->count();
        $totalAlfa = $user->absensi()->where('status', 'alfa')->count();

        // Ambil absensi hari ini
        $absensiHariIni = $user->absensi()
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        // Ambil izin terakhir
        $izinTerakhir = $user->izin()
            ->latest()
            ->first();

        // Hari libur selanjutnya
        $hariLiburSelanjutnya = HariLibur::whereDate('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->first();

        return view('siswa.dashboard', compact(
            'user',
            'kelas',
            'waliKelas',
            'jadwalHariIni',
            'jumlahMapel',
            'totalHadir',
            'totalIzin',
            'totalAlfa',
            'absensiHariIni',
            'izinTerakhir',
            'hariLiburSelanjutnya'
        ));
    }
}
