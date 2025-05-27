@extends('layouts.app')
@section('title', 'Manajemen Mata Pelajaran')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Daftar Mata Pelajaran</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mapel</th>
                        <th>Guru Pengampu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapels as $mapel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mapel->nama_mapel }}</td>
                            <td>{{ $mapel->guru->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
