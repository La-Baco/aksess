@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@section('content')
    <h3>Jadwal Mengajar</h3>

    @if ($jadwals->isEmpty())
        <div class="alert alert-info">
            <h4 class="alert-heading">Info</h4>
            <p>Belum ada jadwal mengajar.</p>
        </div>
    @else
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Jadwal Mengajar</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Hari</th>
                                            <th class="text-center">Waktu Mulai</th>
                                            <th class="text-center">Waktu Selesai</th>
                                            <th class="text-center">Mapel</th>
                                            <th class="text-center">Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwals as $jadwal)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $jadwal->hari }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</td>
                                                <td class="text-center">{{ $jadwal->mapel->nama_mapel }}</td>
                                                <td class="text-center">{{ $jadwal->kelas->nama_kelas ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
