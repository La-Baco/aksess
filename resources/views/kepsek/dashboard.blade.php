@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                {{-- Stat Cards --}}
                <div class="col-12">
                    <div class="row">
                        <!-- Jumlah Siswa -->
                        <div class="col-6 col-lg-2 col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldUser"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 text-center text-md-start">
                                            <h6 class="text-muted font-semibold">Siswa</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalSiswa }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Jumlah Guru -->
                        <div class="col-6 col-lg-2 col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldUser"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 text-center text-md-start">
                                            <h6 class="text-muted font-semibold">Guru</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalGuru }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Jumlah Kelas -->
                        <div class="col-6 col-lg-2 col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldHome"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 text-center text-md-start">
                                            <h6 class="text-muted font-semibold">Kelas</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalKelas }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Jumlah Mapel -->
                        <div class="col-6 col-lg-2 col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldDocument"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 text-center text-md-start">
                                            <h6 class="text-muted font-semibold">Mapel</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalMapel }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Jumlah Jadwal -->
                        <div class="col-6 col-lg-2 col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon teal">
                                                <i class="iconly-boldCalendar"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 text-center text-md-start">
                                            <h6 class="text-muted font-semibold">Jadwal</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalJadwal }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Ringkasan Absensi Hari Ini --}}
                <div class="col-12 mb-4">
                    <h5 class="mb-3">Absensi Hari Ini ({{ \Carbon\Carbon::today()->toFormattedDateString() }})</h5>
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-light-success">
                                <div class="card-body text-center">
                                    <h6 class="mb-1">Hadir</h6>
                                    <h4 class="font-extrabold">{{ $jumlahHadir }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-light-warning">
                                <div class="card-body text-center">
                                    <h6 class="mb-1">Izin</h6>
                                    <h4 class="font-extrabold">{{ $jumlahIzin }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-light-info">
                                <div class="card-body text-center">
                                    <h6 class="mb-1">Sakit</h6>
                                    <h4 class="font-extrabold">{{ $jumlahSakit }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-light-danger">
                                <div class="card-body text-center">
                                    <h6 class="mb-1">Alpha</h6>
                                    <h4 class="font-extrabold">{{ $jumlahAlpha }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Hari Libur Mendatang --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Hari Libur Mendatang</h4>
                    </div>
                    <div class="card-body">
                        @if ($nextHolidays->isEmpty())
                            <p class="text-muted">Tidak ada hari libur mendatang.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($nextHolidays as $hl)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $hl->nama }}</strong><br>
                                            <small
                                                class="text-muted">{{ \Carbon\Carbon::parse($hl->tanggal)->isoFormat('D MMMM Y') }}</small>
                                        </div>
                                        <span class="badge bg-info">{{ $hl->keterangan }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- Rekap Kehadiran per Kelas Hari Ini --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Rekap Kehadiran Kelas ({{ \Carbon\Carbon::today()->toFormattedDateString() }})</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Hadir</th>
                                    <th>Total Siswa</th>
                                    <th>% Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapPerKelas as $kelas)
                                    <tr>
                                        <td>{{ $kelas->nama_kelas }}</td>
                                        <td>{{ $kelas->hadir_count }}</td>
                                        <td>{{ $kelas->total_count }}</td>
                                        <td>{{ $kelas->presentase }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Persetujuan Izin --}}
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Izin Siswa Pending</h4>
                            </div>
                            <div class="card-body">
                                @if ($pendingIzinSiswa->isEmpty())
                                    <p class="text-muted">Tidak ada permohonan izin siswa.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($pendingIzinSiswa as $izin)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $izin->user->name }}
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($izin->tanggal)->toFormattedDateString() }}</small>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('kepsek.izin.approve', $izin->id) }}"
                                                        class="btn btn-success">✔</a>
                                                    <a href="{{ route('kepsek.izin.reject', $izin->id) }}"
                                                        class="btn btn-danger">✖</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Izin Guru Pending</h4>
                            </div>
                            <div class="card-body">
                                @if ($pendingIzinGuru->isEmpty())
                                    <p class="text-muted">Tidak ada permohonan izin guru.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($pendingIzinGuru as $izin)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $izin->user->name }}
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($izin->tanggal)->toFormattedDateString() }}</small>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('kepsek.izin.approve', $izin->id) }}"
                                                        class="btn btn-success">✔</a>
                                                    <a href="{{ route('kepsek.izin.reject', $izin->id) }}"
                                                        class="btn btn-danger">✖</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

@endsection
