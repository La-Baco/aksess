@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')

@section('content')

<section class="section">
    <div class="page-title">
        <h3>Jadwal Pelajaran</h3>
    </div>

    <div class="row" id="table-bordered">
        @foreach ($kelas as $kls)
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Jadwal Kelas {{ $kls->nama_kelas }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($kls->jadwal->count())
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Hari</th>
                                        <th class="text-center">Jam</th>
                                        <th class="text-center">Mata Pelajaran</th>
                                        <th class="text-center">Guru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kls->jadwal as $jadwal)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $jadwal->hari }}</td>
                                            <td class="text-center">{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</td>
                                            <td class="text-center">{{ $jadwal->mapel->nama_mapel }}</td>
                                            <td class="text-center">{{ $jadwal->mapel->guru->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-muted">Belum ada jadwal untuk kelas ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
