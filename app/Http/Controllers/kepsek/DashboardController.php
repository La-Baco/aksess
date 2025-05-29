<?php

namespace App\Http\Controllers\kepsek;

use App\Models\Izin;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\HariLibur;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Umum
        $totalSiswa  = User::where('role', 'siswa')->count();
        $totalGuru   = User::where('role', 'guru')->count();
        $totalKelas  = Kelas::count();
        $totalMapel = Mapel::count();
        $totalJadwal = Jadwal::count();

        // 1. Hari Libur Mendatang
        $today = Carbon::today();
        $absensiHariIni = Absensi::select('status', DB::raw('count(*) as total'))
            ->whereDate('tanggal', $today)
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $jumlahHadir = $absensiHariIni['hadir'] ?? 0;
        $jumlahIzin  = $absensiHariIni['izin'] ?? 0;
        $jumlahSakit = $absensiHariIni['sakit'] ?? 0;
        $jumlahAlpha = $absensiHariIni['alpha'] ?? 0;


        $nextHolidays = HariLibur::whereDate('tanggal', '>=', $today)
            ->orderBy('tanggal')
            ->take(5)
            ->get(['nama', 'tanggal', 'keterangan']);

        // 2. Rekap Kehadiran per Kelas Hari Ini
        $rekapPerKelas = Kelas::withCount([
            'siswa as hadir_count' => function ($q) use ($today) {
                $q->join('absensis', 'users.id', '=', 'absensis.user_id')
                    ->whereDate('absensis.tanggal', $today)
                    ->where('absensis.status', 'hadir');
            },
            'siswa as total_count'
        ])->get()->map(function ($kelas) {
            $kelas->presentase = $kelas->total_count
                ? round($kelas->hadir_count / $kelas->total_count * 100, 1)
                : 0;
            return $kelas;
        });

        // 3. Daftar Izin Pending — dari satu tabel izin
        $pending = Izin::where('status', 'Menunggu') // ganti dari 'pending'
            ->with('user')
            ->orderBy('tanggal_mulai', 'desc') // ganti dari 'tanggal'
            ->get();

        $pendingIzinSiswa = $pending->filter(fn($i) => $i->user->role === 'siswa');
        $pendingIzinGuru  = $pending->filter(fn($i) => $i->user->role === 'guru');
        return view('kepsek.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalJadwal',
            'jumlahHadir',
            'jumlahIzin',
            'jumlahSakit',
            'jumlahAlpha',
            'nextHolidays',
            'rekapPerKelas',
            'pendingIzinSiswa',
            'pendingIzinGuru'
        ));
    }
}
