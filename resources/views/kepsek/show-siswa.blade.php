@extends('layouts.app')
@section('title', 'Data Siswa')
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
        <h3>Data Siswa</h3>
        <p class="text-subtitle text-muted">Daftar Data Siswa</p>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Siswa
            </div>
            <div class="card-body">
                <table class="table table-striped" id="tableSiswa">
                    <thead>
                        <tr>
                            <th>No</th>
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
                        @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->jenis_kelamin ?? '-' }}</td>
                                <td>{{ $item->nis ?? '-' }}</td>
                                <td>{{ $item->telepon ?? '-' }}</td>
                                <td>{{ $item->alamat ?? '-' }}</td>
                                <td>{{ $item->tanggal_lahir ?? '-' }}</td>
                                <td>
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" width="50">
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
@endsection

@section('js')
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        let tableSiswa = document.querySelector('#tableSiswa');
        let dataTableSiswa = new simpleDatatables.DataTable(tableSiswa);
        document.querySelectorAll('.dataTable-search input').forEach(input => {
    input.placeholder = 'Cari data siswa...';
});
    </script>
@endsection
