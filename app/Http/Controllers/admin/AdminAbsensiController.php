<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use App\Models\SettingAbsensi;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAbsensiController extends Controller
{
    // Tampilkan semua data absensi dengan filter opsional
    public function index(Request $request)
    {
        // Contoh filter: tanggal, kelas, status
        $query = Absensi::query();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Bisa ditambahkan filter kelas dengan relasi user->kelas jika perlu

        $absensis = $query->with('siswa')->paginate(20);

        return view('admin.absensi.index', compact('absensis'));
    }

    // Lihat detail absensi tertentu
    public function show($id)
    {
        $absensi = Absensi::with('siswa', 'pembuat')->findOrFail($id);

        return view('admin.absensi.show', compact('absensi'));
    }

    // Jika admin boleh mengedit status absensi
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->status = $request->status;
        $absensi->save();

        return back()->with('success', 'Status absensi berhasil diperbarui.');
    }

    // Hapus data absensi
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
    }

    public function settingForm()
    {
        $setting = SettingAbsensi::first();
        return view('admin.absensi.setting', compact('setting'));
    }
    public function settingStore(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi_lat' => 'required|numeric',
            'lokasi_long' => 'required|numeric',
            'radius_meter' => 'required|integer|min:10',
        ]);

        // Cek jika sudah ada setting
        if (SettingAbsensi::first()) {
            return redirect()->back()->with('error', 'Pengaturan sudah tersedia. Silakan reset terlebih dahulu.');
        }

        SettingAbsensi::create([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi_lat' => $request->lokasi_lat,
            'lokasi_long' => $request->lokasi_long,
            'radius_meter' => $request->radius_meter,
        ]);

        return redirect()->back()->with('success', 'Pengaturan absensi berhasil disimpan.');
    }

    public function settingReset()
    {
        $setting = SettingAbsensi::first();
        if ($setting) {
            $setting->delete();
            return redirect()->back()->with('success', 'Pengaturan absensi berhasil direset.');
        }
        return redirect()->back()->with('error', 'Pengaturan absensi tidak ditemukan.');
    }

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

        return view('admin.absensi.rekap-siswa', [
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
            return ''; // Hari Minggu, tidak dianggap Alpha
        }

        if (in_array($tglString, $hariLibur)) {
            return ''; // Hari libur, tidak dianggap Alpha
        }

        if ($tanggal->lte($hariIni)) {
            return 'Alpha'; // Hari lalu atau hari ini, tidak hadir
        }

        return ''; // Hari depan, biarkan kosong
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

        return view('admin.absensi.rekap-guru', compact('bulan', 'jumlahHari', 'guruList', 'rekap', 'hariLibur', 'penandaHari'));
    }

    // Untuk guru

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
