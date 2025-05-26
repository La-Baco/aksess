<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\HariLibur;
use App\Models\SettingAbsensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $setting = SettingAbsensi::first();

        $absenHariIni = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        $isMinggu = $today->translatedFormat('l') === 'Minggu';
        $isHariLibur = HariLibur::whereDate('tanggal', $today)->exists();

        return view('siswa.absensi', compact('setting','absenHariIni', 'isMinggu', 'isHariLibur'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        if ($now->isSunday()) {
            return back()->with('error', 'Hari ini adalah hari Minggu. Tidak dapat melakukan absensi.');
        }

        if (HariLibur::whereDate('tanggal', $today)->exists()) {
            return back()->with('error', 'Hari ini adalah hari libur. Tidak dapat melakukan absensi.');
        }

        if (Absensi::where('user_id', $user->id)->whereDate('tanggal', $today)->exists()) {
            return back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        $setting = SettingAbsensi::first();
        if (!$setting) {
            return back()->with('error', 'Pengaturan absensi belum tersedia.');
        }

        $jamAwal = Carbon::parse($setting->batas_awal);
        $jamAkhir = Carbon::parse($setting->batas_akhir);

        if ($now->gt($jamAkhir)) {
            $status = 'Hadir_Telat';
        } elseif ($now->between($jamAwal, $jamAkhir)) {
            $status = 'Hadir';
        } else {
            return back()->with('error', 'Belum bisa absen. Belum masuk jam absensi.');
        }

        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'waktu' => $now->format('H:i:s'),
            'status' => $status,
            'lat' => $request->lat,
            'long' => $request->long,
            'dibuat_oleh' => $user->id,
        ]);

        return back()->with('success', 'Absensi berhasil dengan status: ' . $status);
    }

    public function riwayat()
    {
        $user = Auth::user();
        $absensis = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.absensi-riwayat', compact('absensis'));
    }
    protected function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // jarak dalam meter
    }
}
