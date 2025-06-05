@extends('layouts.app')
@section('title', 'Rekap Kehadiran')

@section('content')
<section class="section">
    <div class="row" id="table-responsive">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-2 mb-md-0">
                        Rekap Absensi Bulan {{ \Carbon\Carbon::create(null, $bulan)->translatedFormat('F') }}
                    </h4>

                    <form method="GET" action="{{ route('guru.rekap-kehadiran') }}" class="d-flex align-items-center gap-2">
                        <label for="bulan" class="mb-0 text-nowrap">Pilih Bulan:</label>
                        <select name="bulan" id="bulan" class="form-select form-select-sm" onchange="this.form.submit()">
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
                        <table class="table table-bordered mb-0 text-center">
                            <thead class="bg-white text-dark">
                                <tr>
                                    <th class="align-middle">Nama</th>
                                    @for ($i = 1; $i <= $jumlahHari; $i++)
                                        @php
                                            $tanggal = \Carbon\Carbon::create(null, $bulan, $i)->format('Y-m-d');
                                            $penanda = $penandaHari[$tanggal] ?? [];
                                        @endphp
                                        <th class="align-middle">
                                            {{ $i }}

                                            {{-- LETAKKAN DI SINI --}}
                                            @foreach ($penanda as $tag)
                                                <div>
                                                    <span class="badge
                                                        {{ $tag === 'Minggu' ? 'bg-danger' : 'bg-warning text-dark' }} small">
                                                        {{ $tag }}
                                                    </span>
                                                </div>
                                            @endforeach

                                        </th>
                                    @endfor
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="align-middle">{{ $user->name }}</td>
                                    @for ($i = 1; $i <= $jumlahHari; $i++)
                                        @php
                                            $tanggal = \Carbon\Carbon::create(null, $bulan, $i)->format('Y-m-d');
                                            $status = $rekap[$tanggal] ?? '';
                                            $penanda = $penandaHari[$tanggal] ?? [];

                                            // Tentukan warna default dari status
                                            $warna = match($status) {
                                                'Hadir' => 'success',
                                                'Alpha' => 'danger',
                                                'Izin'  => 'warning',
                                                'Sakit' => 'info',
                                                default => 'light',
                                            };

                                            // Override kalau hari Minggu atau Libur
                                            foreach ($penanda as $tag) {
                                                if ($tag === 'Minggu') {
                                                    $warna = 'secondary'; // Merah untuk Minggu
                                                    break;
                                                } elseif ($tag === 'Libur') {
                                                    $warna = 'secondary';
                                                    break;
                                                }
                                            }

                                            $textColor = in_array($warna, ['light', 'warning']) ? 'text-dark' : 'text-white';
                                        @endphp

                                        <td class="bg-{{ $warna }} {{ $textColor }} align-middle">
                                            {{ $status ? strtoupper(substr($status, 0, 1)) : '-' }}
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>

                        </table>
                    </div>

                    <div class="mt-4">
                        <h6>Keterangan Warna:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-success">H = Hadir</span>
                            <span class="badge bg-danger">A = Alpha</span>
                            <span class="badge bg-warning text-dark">I = Izin</span>
                            <span class="badge bg-info text-white">S = Sakit</span>
                            <span class="badge bg-light text-dark">- = Tidak Ada Data</span>
                            <span class="badge bg-danger">Minggu</span>
                            <span class="badge bg-warning text-dark">Libur</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
