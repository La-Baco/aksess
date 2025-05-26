@extends('layouts.app')
@section('title', 'Kelas')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">KELAS: {{ $selectedKelas->nama_kelas }}</h2>
            </div>
            <div class="card-body">
                <h5><strong>Wali Kelas:</strong> {{ $selectedKelas->guruWali->first()->name ?? '-' }}</h5>
                <h5><strong>Kapasitas:</strong> {{ $selectedKelas->siswa->count() }}/{{ $selectedKelas->kapasitas }}</h5>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Tanggal Lahir</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedKelas->siswa as $index => $siswa)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $siswa->name }}</td>
                                    <td class="text-center">{{ $siswa->nis }}</td>
                                    <td class="text-center">{{ $siswa->jenis_kelamin }}</td>
                                    <td class="text-center">{{ $siswa->tanggal_lahir ?? '-'}}</td>
                                    <td class="text-center">{{ $siswa->alamat ?? '-'}}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/foto_siswa/' . $siswa->foto ) }}" alt="Foto"
                                            width="50" height="50">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary mt-3">Close</a>
            </div>
        </div>
    </div>
</div>
@endsection
