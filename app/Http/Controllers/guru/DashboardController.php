<?php

namespace App\Http\Controllers\guru;

use App\Models\Izin;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\HariLibur;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user();

        // 1. Cek apakah guru adalah wali kelas
        $kelasWali = Kelas::with('siswa')
            ->whereHas('guruWali', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })->first();

        // 2. Ambil jadwal mengajar hari ini
        $todayName = Carbon::now()->translatedFormat('l'); // Senin, Selasa, dst

        $jadwalHariIni = Jadwal::with(['mapel', 'kelas'])
            ->whereHas('mapel', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->where('hari', $todayName)
            ->orderBy('waktu_mulai')
            ->get();

        // 3. Rekap absensi siswa jika guru adalah wali kelas
        $rekapAbsensi = null;
        if ($kelasWali) {
            $siswaIds = $kelasWali->siswa->pluck('id');
            $todayDate = Carbon::today()->toDateString();

            $rekapAbsensi = [
                'hadir' => Absensi::whereDate('tanggal', $todayDate)
                    ->where('status', 'hadir')
                    ->whereIn('user_id', $siswaIds)
                    ->count(),
                'izin' => Absensi::whereDate('tanggal', $todayDate)
                    ->where('status', 'izin')
                    ->whereIn('user_id', $siswaIds)
                    ->count(),
                'alpa' => Absensi::whereDate('tanggal', $todayDate)
                    ->where('status', 'alpa')
                    ->whereIn('user_id', $siswaIds)
                    ->count(),
            ];
        }

        // 4. Hari libur terdekat (max 5)
        $nextHolidays = HariLibur::whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->limit(5)
            ->get();

        $izinTerbaru = Izin::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'kelasWali',
            'jadwalHariIni',
            'rekapAbsensi',
            'izinTerbaru',
            'nextHolidays'
        ));
    }
}
