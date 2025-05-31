@extends('layouts.app')
@section('title', 'Rekap Absensi Siswa')

@section('content')
    <section class="section">
        <div class="row" id="table-responsive">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title mb-3">
                            Rekap Absensi Siswa Bulan {{ \Carbon\Carbon::create(null, $bulan)->translatedFormat('F') }}
                            @if ($kelasTerpilih)
                                - Kelas {{ $kelasTerpilih->nama_kelas }}
                            @endif
                        </h4>

                        <form method="GET" action="{{ route('admin.absensi.rekap-siswa') }}"
                            class="d-flex flex-wrap align-items-center gap-2">
                            <label for="kelas_id" class="mb-0">Pilih Kelas:</label>
                            <select name="kelas_id" id="kelas_id" class="form-select form-select-sm"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Kelas --</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ $kelasTerpilih && $kelasTerpilih->id == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="bulan" class="mb-0 ">Pilih Bulan:</label>
                            <select name="bulan" id="bulan" class="form-select form-select-sm"
                                onchange="this.form.submit()">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </form>
                    </div>


                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="bg-white text-center text-dark">
                                    <tr>
                                        <th class="align-middle">Nama</th>
                                        @for ($i = 1; $i <= $jumlahHari; $i++)
                                            <th class="align-middle text-nowrap">{{ $i }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswaList as $siswa)
                                        <tr>
                                            <td class="align-middle">{{ $siswa->name }}</td>
                                            @for ($i = 1; $i <= $jumlahHari; $i++)
                                                @php
                                                    $tanggal = \Carbon\Carbon::create(null, $bulan, $i)->format(
                                                        'Y-m-d',
                                                    );
                                                    $status = $rekap[$siswa->id][$tanggal] ?? '';
                                                    $warna = match ($status) {
                                                        'Hadir' => 'success',
                                                        'Alpha' => 'danger',
                                                        'Izin' => 'warning',
                                                        'Sakit' => 'info',
                                                        default => 'light',
                                                    };
                                                    $textColor = in_array($warna, ['light', 'warning'])
                                                        ? 'text-dark'
                                                        : 'text-white';
                                                @endphp
                                                <td
                                                    class="text-center {{ $textColor }} bg-{{ $warna }} align-middle">
                                                    {{ $status ? strtoupper(substr($status, 0, 1)) : '-' }}
                                                </td>
                                            @endfor

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $jumlahHari + 1 }}" class="text-center text-muted">
                                                Tidak ada data siswa untuk kelas ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <h6>Keterangan Warna:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-success">H = Hadir</span>
                                <span class="badge bg-danger">A = Alpha</span>
                                <span class="badge bg-warning text-dark">I = Izin</span>
                                <span class="badge bg-info text-dark">S = Sakit</span>
                                <span class="badge bg-light text-dark">- = Tidak Ada Data</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
