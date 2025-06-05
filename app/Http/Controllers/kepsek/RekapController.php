<?php

namespace App\Http\Controllers\kepsek;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $hariLibur = HariLibur::pluck('tanggal')->toArray();
        $siswaList = $kelasTerpilih ? $kelasTerpilih->siswa()->orderBy('name')->get() : User::where('role', 'siswa')->orderBy('name')->get();

        $absensi = Absensi::whereIn('user_id', $siswaList->pluck('id'))
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->keyBy(fn($item) => Carbon::parse($item->tanggal)->format('Y-m-d'))->map->status;
            });

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

        $liburTanggal = HariLibur::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->pluck('tanggal')->map(fn($tgl) => Carbon::parse($tgl)->format('Y-m-d'))->toArray();
        $penandaHari = [];
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create($tahun, $bulan, $i);
            $tglString = $tanggal->format('Y-m-d');

            $tags = [];
            if ($tanggal->isSunday()) {
                $tags[] = 'Minggu';
            }
            if (in_array($tglString, $liburTanggal)) {
                $tags[] = 'Libur';
            }

            if ($tags) {
                $penandaHari[$tglString] = $tags;
            }
        }

        $rekap = [];
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create($tahun, $bulan, $i)->format('Y-m-d');

            foreach ($siswaList as $siswa) {
                $rekap[$siswa->id][$tanggal] = '';

                if (isset($absensi[$siswa->id][$tanggal])) {
                    $rekap[$siswa->id][$tanggal] = $absensi[$siswa->id][$tanggal];
                    continue;
                }

                $izin = $izinList->get($siswa->id)?->first(function ($izin) use ($tanggal) {
                    return $tanggal >= $izin->tanggal_mulai && $tanggal <= $izin->tanggal_selesai;
                });

                if ($izin) {
                    $rekap[$siswa->id][$tanggal] = 'Izin';
                    continue;
                }

                $rekap[$siswa->id][$tanggal] = $this->defaultStatus($tanggal, $liburTanggal);
            }
        }

        return view('kepsek.rekap-siswa', [
            'bulan' => $bulan,
            'jumlahHari' => $jumlahHari,
            'kelasList' => $kelasList,
            'kelasTerpilih' => $kelasTerpilih,
            'siswaList' => $siswaList,
            'rekap' => $rekap,
            'kelas_id' => $kelasId,
            'penandaHari' => $penandaHari,
            'hariLibur' => $hariLibur,
        ]);
    }
    private function defaultStatus($tglString, array $hariLibur = [])
    {
        $tanggal = Carbon::parse($tglString);
        $hariIni = Carbon::today();

        if ($tanggal->isSunday()) {
            return '';
        }

        if (in_array($tglString, $hariLibur)) {
            return '';
        }

        if ($tanggal->lte($hariIni)) {
            return 'Alpha';
        }

        return ''; 
    }

    public function rekapGuru(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = now()->year;
        $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;

        $guruList = User::where('role', 'guru')->orderBy('name')->get();
        $hariLibur = HariLibur::pluck('tanggal')->toArray();
        $absensi = Absensi::whereIn('user_id', $guruList->pluck('id'))
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->keyBy(fn($item) => Carbon::parse($item->tanggal)->format('Y-m-d'))->map->status;
            });

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

        $liburTanggal = HariLibur::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->pluck('tanggal')->map(fn($tgl) => Carbon::parse($tgl)->format('Y-m-d'))->toArray();

        $penandaHari = [];
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create($tahun, $bulan, $i);
            $tglString = $tanggal->format('Y-m-d');

            $tags = [];
            if ($tanggal->isSunday()) {
                $tags[] = 'Minggu';
            }
            if (in_array($tglString, $liburTanggal)) {
                $tags[] = 'Libur';
            }

            if ($tags) {
                $penandaHari[$tglString] = $tags;
            }
        }

        $rekap = [];
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create($tahun, $bulan, $i)->format('Y-m-d');

            foreach ($guruList as $guru) {
                $rekap[$guru->id][$tanggal] = '';

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

                $rekap[$guru->id][$tanggal] = $this->defaultStatus($tanggal, $liburTanggal);
            }
        }

        return view('kepsek.rekap-guru', compact('bulan', 'jumlahHari', 'guruList', 'rekap', 'hariLibur', 'penandaHari'));
    }
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Alpha,Izin,Sakit',
        ]);

        $absen = Absensi::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'tanggal' => $validated['tanggal'],
            ],
            [
                'status' => $validated['status'],
                'dibuat_oleh' => Auth::id(), // <- tambahkan ini
            ],
        );

        return back()->with('success', 'Status kehadiran berhasil diperbarui.');
    }
}
