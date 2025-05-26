<?php

namespace App\Http\Controllers\Guru;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use App\Models\SettingAbsensi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        return view('guru.absensi', compact('setting', 'absenHariIni', 'isMinggu', 'isHariLibur'));
    }



    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Cek hari minggu
        if ($now->isSunday()) {
            return redirect()->back()->with('error', 'Hari ini adalah hari Minggu. Tidak dapat melakukan absensi.');
        }

        // Cek hari libur dari DB
        $isLibur = HariLibur::whereDate('tanggal', $today)->exists();
        if ($isLibur) {
            return redirect()->back()->with('error', 'Hari ini adalah hari libur. Tidak dapat melakukan absensi.');
        }

        // Cek absensi ganda
        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->exists();
        if ($sudahAbsen) {
            return redirect()->back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        // Ambil setting absensi
        $setting = SettingAbsensi::first();
        if (!$setting) {
            return redirect()->back()->with('error', 'Pengaturan absensi belum tersedia.');
        }

        $jamAwal = Carbon::parse($setting->batas_awal);
        $jamAkhir = Carbon::parse($setting->batas_akhir);

        if ($now->lt($jamAwal) || $now->gte($jamAkhir)) {
            return redirect()->back()->with('error', 'Belum bisa absen. Absen hanya diperbolehkan saat jam absensi berlangsung.');
        } else {
            $status = 'hadir';
        }

        // Simpan absensi
        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'waktu' => $now,
            'status' => $status,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil disimpan dengan status: ' . $status);
    }

    protected function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // jarak dalam meter
    }
    public function riwayat()
    {
        $user = Auth::user();
        $absensis = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.absensi-riwayat', compact('absensis'));
    }
}
