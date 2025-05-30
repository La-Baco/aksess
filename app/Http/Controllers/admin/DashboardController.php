<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru  = User::where('role', 'guru')->count();
        $jumlahKelas = Kelas::count();
        $jumlahMapel = Mapel::count();
        $jumlahJadwal = Jadwal::count();

        $tanggalHariIni = Carbon::today();

        $absensiHariIni = Absensi::select('status', DB::raw('count(*) as total'))
            ->whereDate('tanggal', $tanggalHariIni)
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $jumlahHadir = $absensiHariIni['hadir'] ?? 0;
        $jumlahIzin  = $absensiHariIni['izin'] ?? 0;
        $jumlahSakit = $absensiHariIni['sakit'] ?? 0;
        $jumlahAlpha = $absensiHariIni['alpha'] ?? 0;

        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $jadwalHariIni = Jadwal::with(['kelas', 'mapel.guru'])
            ->where('hari', $hariIni)
            ->orderBy('waktu_mulai')
            ->get();

        $startDate = Carbon::today()->subDays(6);
        $trendRaw = Absensi::select(
                DB::raw("DATE(tanggal) as date"),
                DB::raw("SUM(CASE WHEN status='hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status='izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN status='sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN status='alpha' THEN 1 ELSE 0 END) as alpha")
            )
            ->whereDate('tanggal', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $trendRaw->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->format('d M'))
            ->toArray();

        $series = [
            ['name' => 'Hadir', 'data' => $trendRaw->pluck('hadir')->toArray()],
            ['name' => 'Izin',  'data' => $trendRaw->pluck('izin')->toArray()],
            ['name' => 'Sakit', 'data' => $trendRaw->pluck('sakit')->toArray()],
            ['name' => 'Alpha', 'data' => $trendRaw->pluck('alpha')->toArray()],
        ];

        return view('admin.dashboard', compact(
            'jumlahSiswa','jumlahGuru','jumlahKelas','jumlahMapel','jumlahJadwal',
            'jumlahHadir','jumlahIzin','jumlahSakit','jumlahAlpha','jadwalHariIni',
            'labels','series'
        ));

        
    }
}
