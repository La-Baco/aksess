<?php

namespace App\Http\Controllers\Siswa;

use Carbon\Carbon;
use App\Models\Izin;
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

        $mulaiAbsensi = $setting ? $setting->jam_mulai : null;
        $selesaiAbsensi = $setting ? $setting->jam_selesai : null;

        return view('guru.absensi', compact(
            'setting',
            'absenHariIni',
            'isMinggu',
            'isHariLibur',
            'mulaiAbsensi',
            'selesaiAbsensi'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $user = Auth::user();
        $tanggalHariIni = Carbon::now()->format('Y-m-d');

        // Cek jika hari ini Minggu
        if (Carbon::now()->isSunday()) {
            return redirect()->back()->with('error', 'Hari ini adalah hari Minggu. Absensi tidak tersedia.');
        }

        // Cek jika hari ini adalah hari libur
        $isLibur = HariLibur::where('tanggal', $tanggalHariIni)->exists();
        if ($isLibur) {
            return redirect()->back()->with('error', 'Hari ini adalah hari libur nasional.');
        }

        // Cek jika sudah absen hari ini
        $sudahAbsen = Absensi::where('user_id', $user->id)->whereDate('waktu', $tanggalHariIni)->first();
        if ($sudahAbsen) {
            return redirect()->back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        // Ambil setting lokasi sekolah
        $setting = SettingAbsensi::first();
        if (!$setting) {
            return redirect()->back()->with('error', 'Pengaturan absensi belum tersedia.');
        }

        // Hitung jarak lokasi user ke sekolah
        $distance = $this->hitungJarak(
            $request->lat,
            $request->long,
            $setting->lokasi_lat,
            $setting->lokasi_long
        );

        if ($distance > $setting->radius_meter) {
            return redirect()->back()->with('error', 'Kamu berada di luar area sekolah.');
        }

        // Simpan absensi
        Absensi::create([
            'user_id' => $user->id,
            'waktu' => Carbon::now(),
            'status' => 'Hadir',
            'latitude' => $request->lat,
            'longitude' => $request->long,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil dilakukan.');
    }

    // Fungsi untuk menghitung jarak Haversine
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000; // Earth radius in meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    public function rekapKehadiran(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $user = Auth::user();
        $jumlahHari = Carbon::create(null, $bulan)->daysInMonth;
        $rekap = [];
        $penandaHari = [];

        // Ambil semua tanggal libur sekali saja
        $hariLibur = HariLibur::pluck('tanggal')->toArray();

        // Ambil izin disetujui user di bulan tersebut
        $izinList = Izin::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->where(function ($query) use ($bulan) {
                $query->whereMonth('tanggal_mulai', $bulan)->orWhereMonth('tanggal_selesai', $bulan);
            })
            ->get();

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create(null, $bulan, $i);
            $tglString = $tanggal->format('Y-m-d');

            // --- Penanda Hari ---
            if ($tanggal->isSunday()) {
                $penandaHari[$tglString][] = 'Minggu';
            }

            if (in_array($tglString, $hariLibur)) {
                $penandaHari[$tglString][] = 'Libur';
            }

            // --- Cek Izin ---
            $izinAda = $izinList->first(function ($izin) use ($tglString) {
                return $tglString >= $izin->tanggal_mulai && $tglString <= $izin->tanggal_selesai;
            });

            if ($izinAda) {
                $rekap[$tglString] = 'Izin';
                continue;
            }

            // --- Cek Absensi ---
            $absen = Absensi::where('user_id', $user->id)->whereDate('tanggal', $tglString)->first();

            if ($absen) {
                $rekap[$tglString] = $absen->status;
            } else {
                $rekap[$tglString] = $this->defaultStatus($tglString, $hariLibur);
            }
        }

        return view('guru.rekap-kehadiran', compact('rekap', 'bulan', 'jumlahHari', 'user', 'penandaHari'));
    }

    private function defaultStatus($tglString, array $hariLibur = [])
    {
        $tanggal = Carbon::parse($tglString);
        $hariIni = Carbon::today();

        // Jangan beri Alpha kalau hari Minggu
        if ($tanggal->isSunday()) {
            return ''; // Kosongkan, tidak dianggap Alpha
        }

        // Jangan beri Alpha kalau tanggal libur
        if (in_array($tglString, $hariLibur)) {
            return ''; // Kosongkan, tidak dianggap Alpha
        }

        // Jika hari lalu atau hari ini, tapi bukan Minggu/libur
        if ($tanggal->lte($hariIni)) {
            return 'Alpha';
        }

        return ''; // Hari depan, kosong
    }
}
