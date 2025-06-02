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

        $absenHariIni = Absensi::where('user_id', $user->id)->whereDate('tanggal', $today)->first();

        $isMinggu = $today->translatedFormat('l') === 'Minggu';
        $isHariLibur = HariLibur::whereDate('tanggal', $today)->exists();

        return view('siswa.absensi', compact('setting', 'absenHariIni', 'isMinggu', 'isHariLibur'));
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
        $absensis = Absensi::where('user_id', $user->id)->orderBy('tanggal', 'desc')->get();

        return view('siswa.absensi-riwayat', compact('absensis'));
    }
    protected function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // jarak dalam meter
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
