@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container mt-4">
    <h4>Selamat Datang, {{ $user->name }}</h4>

    {{-- Informasi Kelas dan Wali Kelas --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Kelas</h5>
            <p><strong>Kelas:</strong> {{ $kelas->nama_kelas ?? '-' }}</p>
            <p><strong>Wali Kelas:</strong> {{ $waliKelas->name ?? '-' }}</p>
        </div>
    </div>

    {{-- Ringkasan Kehadiran --}}
    <div class="row mb-4">
        <div class="col-6 col-md-4 mb-3">
            <div class="card bg-light-success">
                <div class="card-body text-center">
                    <h6 class="mb-1 ">Hadir</h6>
                    <h4 class="font-extrabold">{{ $totalHadir }}</h4>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 mb-3">
            <div class="card bg-light-warning">
                <div class="card-body text-center">
                    <h6 class="mb-1">Izin</h6>
                    <h4 class="font-extrabold">{{ $totalIzin }}</h4>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 mb-3">
            <div class="card bg-light-danger">
                <div class="card-body text-center">
                    <h6 class="mb-1 ">Alfa</h6>
                    <h4 class="font-extrabold ">{{ $totalAlfa }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Jadwal Hari Ini --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Jadwal Hari Ini ({{ now()->translatedFormat('l, d F Y') }})</h5>
            @if ($jadwalHariIni->count())
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalHariIni as $jadwal)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $jadwal->mapel->nama }}</td>
                                <td>{{ $jadwal->mapel->guru->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mt-2">Tidak ada jadwal hari ini.</p>
            @endif
        </div>
    </div>

    {{-- Status Absensi Hari Ini --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Status Absensi Hari Ini</h5>
            @if ($absensiHariIni)
                <p>Status: <strong class="text-primary text-uppercase">{{ $absensiHariIni->status }}</strong></p>
                <p>Waktu Absen: {{ \Carbon\Carbon::parse($absensiHariIni->created_at)->format('H:i:s') }}</p>
            @else
                <p class="text-muted">Belum melakukan absensi hari ini.</p>
            @endif
        </div>
    </div>

    {{-- Status Izin Terakhir --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Izin Terakhir</h5>
            @if ($izinTerakhir)
                <p><strong>Status:</strong> {{ $izinTerakhir->status }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($izinTerakhir->tanggal)->translatedFormat('d F Y') }}</p>
                <p><strong>Alasan:</strong> {{ $izinTerakhir->alasan }}</p>
            @else
                <p class="text-muted">Belum ada izin yang diajukan.</p>
            @endif
        </div>
    </div>

    {{-- Hari Libur Terdekat --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Hari Libur Terdekat</h5>
            @if ($hariLiburSelanjutnya)
                <p><strong>{{ \Carbon\Carbon::parse($hariLiburSelanjutnya->tanggal)->translatedFormat('l, d F Y') }}</strong> - {{ $hariLiburSelanjutnya->keterangan }}</p>
            @else
                <p class="text-muted">Tidak ada hari libur dalam waktu dekat.</p>
            @endif
        </div>
    </div>
</div>
@endsection
