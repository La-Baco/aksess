@extends('layouts.app')
@section('title', 'Data User')
@section('css')
    <style>
        .dataTable-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .dataTable-search input {
            padding: 6px 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            max-width: 250px;
        }

        .dataTable-dropdown label {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data User</h3>
                <p class="text-subtitle text-muted">Daftar User Aksess</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data User</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <!-- Tabel Admin -->
        <div class="card">
            <div class="card-header">
                Data Admin
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->jenis_kelamin ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Guru
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table2">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>NIP</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gurus as $guru)
                            <tr>
                                <td>{{ $guru->name }}</td>
                                <td>{{ $guru->email }}</td>
                                <td>{{ $guru->jenis_kelamin ?? '-' }}</td>
                                <td>{{ $guru->nip ?? '-' }}</td>
                                <td>{{ $guru->telepon ?? '-' }}</td>
                                <td>{{ $guru->alamat ?? '-' }}</td>
                                <td>{{ $guru->tanggal_lahir ?? '-' }}</td>
                                <td>
                                    @if ($guru->foto)
                                        <img src="{{ Storage::url($guru->foto) }}" alt="Foto" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Siswa
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table3">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>NIS</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td>{{ $siswa->name }}</td>
                                <td>{{ $siswa->email }}</td>
                                <td>{{ $siswa->jenis_kelamin ?? '-' }}</td>
                                <td>{{ $siswa->nis ?? '-' }}</td>
                                <td>{{ $siswa->telepon ?? '-' }}</td>
                                <td>{{ $siswa->alamat ?? '-' }}</td>
                                <td>{{ $siswa->tanggal_lahir ?? '-' }}</td>
                                <td>
                                    @if ($siswa->foto)
                                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>


@section('js')
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable1 = new simpleDatatables.DataTable(table1);

        let table2 = document.querySelector('#table2');
        let dataTable2 = new simpleDatatables.DataTable(table2);

        let table3 = document.querySelector('#table3');
        let dataTable3 = new simpleDatatables.DataTable(table3);
    </script>
    <script>
        document.querySelectorAll('.dataTable-search input').forEach(input => {
            input.placeholder = 'Cari data user...';
        });
    </script>

@endsection



@endsection
