<?php

namespace App\Http\Controllers\kepsek;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RekapController extends Controller
{
    public function rekapSiswa(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = now()->year;
        $kelasId = $request->get('kelas_id');

        $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $kelasTerpilih = $kelasId ? Kelas::find($kelasId) : null;

        $siswaList = $kelasTerpilih ? $kelasTerpilih->siswa()->orderBy('name')->get() : User::where('role', 'siswa')->orderBy('name')->get();

        // Ambil absensi per user per tanggal
        $absensi = Absensi::whereIn('user_id', $siswaList->pluck('id'))
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->keyBy(fn($item) => $item->tanggal->format('Y-m-d'))->map->status;
            });

        // Ambil izin yang disetujui per user
        $izinList = Izin::whereIn('user_id', $siswaList->pluck('id'))
            ->where('status', 'Disetujui')
            ->where(function ($q) use ($bulan, $tahun) {
                $q->where(function ($q2) use ($bulan, $tahun) {
                    $q2->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun);
                })->orWhere(function ($q2) use ($bulan, $tahun) {
                    $q2->whereMonth('tanggal_selesai', $bulan)->whereYear('tanggal_selesai', $tahun);
                });
            })
            ->get()
            ->groupBy('user_id');

        $rekap = [];
        $hariIni = Carbon::today();

        foreach ($siswaList as $siswa) {
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggalCarbon = Carbon::create($tahun, $bulan, $i);
                $tanggal = $tanggalCarbon->format('Y-m-d');

                // Default status kosong
                $rekap[$siswa->id][$tanggal] = '';

                // Jika tanggal di masa depan, biarkan kosong
                if ($tanggalCarbon->gt($hariIni)) {
                    continue;
                }

                // Jika sudah ada absensi, pakai status absensi
                if (isset($absensi[$siswa->id][$tanggal])) {
                    $rekap[$siswa->id][$tanggal] = $absensi[$siswa->id][$tanggal];
                    continue;
                }

                // Jika user sedang izin pada tanggal ini
                $izin = $izinList->get($siswa->id)?->first(function ($izin) use ($tanggal) {
                    return $tanggal >= $izin->tanggal_mulai && $tanggal <= $izin->tanggal_selesai;
                });

                if ($izin) {
                    $rekap[$siswa->id][$tanggal] = 'Izin';
                    continue;
                }

                // Jika tidak ada absensi dan tidak izin, untuk hari ini dan sebelumnya status Alpha
                $rekap[$siswa->id][$tanggal] = 'Alpha';
            }
        }

        return view('admin.absensi.rekap-siswa', compact('bulan', 'jumlahHari', 'kelasList', 'kelasTerpilih', 'siswaList', 'rekap'));
    }

    public function rekapGuru(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = now()->year;
        $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;

        // Ambil semua siswa (tanpa filter kelas)
        $guruList = User::where('role', 'guru')->orderBy('name')->get();

        // Ambil absensi per user per tanggal
        $absensi = Absensi::whereIn('user_id', $guruList->pluck('id'))
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->keyBy(fn($item) => $item->tanggal->format('Y-m-d'))->map->status;
            });

        // Ambil izin yang disetujui per user
        $izinList = Izin::whereIn('user_id', $guruList->pluck('id'))
            ->where('status', 'Disetujui')
            ->where(function ($q) use ($bulan, $tahun) {
                $q->where(function ($q2) use ($bulan, $tahun) {
                    $q2->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun);
                })->orWhere(function ($q2) use ($bulan, $tahun) {
                    $q2->whereMonth('tanggal_selesai', $bulan)->whereYear('tanggal_selesai', $tahun);
                });
            })
            ->get()
            ->groupBy('user_id');

        $rekap = [];
        $hariIni = Carbon::today();

        foreach ($guruList as $guru) {
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggalCarbon = Carbon::create($tahun, $bulan, $i);
                $tanggal = $tanggalCarbon->format('Y-m-d');

                $rekap[$guru->id][$tanggal] = '';

                if ($tanggalCarbon->gt($hariIni)) {
                    continue;
                }

                if (isset($absensi[$guru->id][$tanggal])) {
                    $rekap[$guru->id][$tanggal] = $absensi[$guru->id][$tanggal];
                    continue;
                }

                $izin = $izinList->get($guru->id)?->first(function ($izin) use ($tanggal) {
                    return $tanggal >= $izin->tanggal_mulai && $tanggal <= $izin->tanggal_selesai;
                });

                if ($izin) {
                    $rekap[$guru->id][$tanggal] = 'Izin';
                    continue;
                }

                $rekap[$guru->id][$tanggal] = 'Alpha';
            }
        }

        return view('admin.absensi.rekap-guru', compact('bulan', 'jumlahHari', 'guruList', 'rekap'));
    }
}
