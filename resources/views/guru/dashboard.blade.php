@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-3">Selamat datang, {{ $guru->name }}</h2>


        @if ($kelasWali)
            <h5 class="mb-4">Wali Kelas: <span class="badge bg-primary">{{ $kelasWali->nama_kelas }}</span></h5>
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Siswa</h6>
                                        <h6 class="font-extrabold mb-0">{{ $kelasWali->siswa->count() }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Hadir</h6>
                                        <h6 class="font-extrabold mb-0">{{ $rekapAbsensi['hadir'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Izin</h6>
                                        <h6 class="font-extrabold mb-0">{{ $rekapAbsensi['izin'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Alpa</h6>
                                        <h6 class="font-extrabold mb-0">{{ $rekapAbsensi['alpa'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endif
    <div class="col-12 mb-4">
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
                                    <a href="{{ route('guru.izin.approve', $izin->id) }}"
                                        class="btn btn-success">✔</a>
                                    <a href="{{ route('guru.izin.reject', $izin->id) }}"
                                        class="btn btn-danger">✖</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>



    <section class="section">
        <div class="row" id="table-hover-row">
            <!-- Jadwal Hari Ini -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Jadwal Hari Ini
                            ({{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }})</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>Daftar jadwal mengajar hari ini untuk guru.</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Guru Pengajar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jadwalHariIni as $jadwal)
                                        <tr>
                                            <td class="text-bold-500">{{ $jadwal->kelas->nama_kelas ?? '-' }}</td>
                                            <td class="text-bold-500">{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                            <td>{{ $jadwal->mapel->guru->name ?? '-' }}</td>
                                            <td>
                                                <a href="#" title="Detail Jadwal">
                                                    <i class="badge-circle badge-circle-light-secondary font-medium-1"
                                                        data-feather="eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada jadwal hari ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hari Libur Mendatang -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hari Libur Mendatang</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>Daftar hari libur yang akan datang.</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Libur</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($nextHolidays as $libur)
                                        <tr>
                                            <td class="text-bold-500">{{ $libur->nama_libur ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($libur->tanggal)->translatedFormat('l, d M Y') }}
                                            </td>
                                            <td>{{ $libur->keterangan ?? '-' }}</td>
                                            <td>
                                                <a href="#" title="Detail Libur">
                                                    <i class="badge-circle badge-circle-light-secondary font-medium-1"
                                                        data-feather="info"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada hari libur mendatang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jangan lupa include Feather Icons JS agar icon tampil -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>


    </div>
@endsection
