@extends('layouts.app')
@section('title','Dashboard')
@section('content')

<div class="page-content">
    <section class="row">

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
                                    <h6 class="font-extrabold mb-0">{{ $jumlahSiswa }}</h6>
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
                                    <h6 class="font-extrabold mb-0">{{ $jumlahGuru }}</h6>
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
                                    <h6 class="font-extrabold mb-0">{{ $jumlahKelas }}</h6>
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
                                    <h6 class="font-extrabold mb-0">{{ $jumlahMapel }}</h6>
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
                                    <h6 class="font-extrabold mb-0">{{ $jumlahJadwal }}</h6>
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
        {{-- Grafik Tren Absensi Mingguan --}}
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header">
            <h4>Tren Absensi 7 Hari Terakhir</h4>
        </div>
        <div class="card-body">
            <div id="chart-trend-absensi"></div>
        </div>
    </div>
</div>


        {{-- Jadwal Hari Ini --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Jadwal Hari Ini ({{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }})</h4>
                </div>
                <div class="card-body">
                    @if($jadwalHariIni->isEmpty())
                        <p class="text-center text-muted">Tidak ada jadwal untuk hari ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Jam</th>
                                        <th>Kelas</th>
                                        <th>Mapel</th>
                                        <th>Guru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwalHariIni as $jadwal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}
                                                – {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                            </td>
                                            <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                            <td>{{ $jadwal->mapel->nama_mapel }}</td>
                                            <td>{{ $jadwal->mapel->guru->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </section>
</div>
@section('js')
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: { type: 'line', height: 300 },
            series: @json($series),
            xaxis: { categories: @json($labels) },
            stroke: { curve: 'smooth' },
            markers: { size: 4 },
            legend: { position: 'top' }
        };
        var chart = new ApexCharts(
            document.querySelector("#chart-trend-absensi"),
            options
        );
        chart.render();
    });
</script>
@endsection

@endsection
