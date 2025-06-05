@extends('layouts.app')
@section('title', 'Manajemen Mapel')
@section('content')

<section class="section">
    <div class="row" id="table-bordered">
        <!-- Mapel Table -->
        @if (session('success'))
            <div class="alert alert-light-success color-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-light-danger color-danger">
                <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Mapel</h4>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#tambahMapelModal">Tambah Mapel</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Mata Pelajaran</th>
                                    <th class="text-center">Guru Pengajar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mapels as $mapel)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $mapel->nama_mapel }}</td>
                                        <td class="text-center">{{ $mapel->guru->name }}</td>
                                        <td class="text-center">
                                            <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                                <button type="button"
                                                    class="btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target="#editMapelModal{{ $mapel->id }}"><i
                                                        class="bi bi-pencil-square"></i>
                                                </button>
                                                <form action="{{ route('admin.mapel.destroy', $mapel->id) }}"
                                                    method="POST" id="deleteForm{{ $mapel->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                        onclick="confirmDelete({{ $mapel->id }})"><i
                                                            class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
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

<!-- Modal Tambah Mapel -->
<x-modal :id="'tambahMapelModal'" :title="'Tambah Mapel'">
    <form action="{{ route('admin.mapel.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mapel</label>
            <input type="text" name="nama_mapel" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="guru_id" class="form-label">Guru Pengajar</label>
            <select name="guru_id" id="guru_id" class="form-select" required>
                <option value="" disabled selected>Pilih Guru</option> <!-- Tambahkan baris ini -->
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
    </form>
</x-modal>

<!-- Modal Edit Mapel -->
@foreach ($mapels as $mapel)
    <x-modal :id="'editMapelModal' . $mapel->id" :title="'Edit Mapel'">
        <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_nama" class="form-label">Nama Mapel</label>
                <input type="text" name="nama_mapel" id="edit_nama" class="form-control" value="{{ $mapel->nama_mapel }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="edit_guru_id" class="form-label">Guru Pengajar</label>
                <select name="guru_id" id="edit_guru_id" class="form-select" required>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}"
                            {{ $guru->id == $mapel->guru_id ? 'selected' : '' }}>{{ $guru->name }}</option>
                    @endforeach
                </select>
            </div>
           <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-modal>
@endforeach

<script>
    function confirmDelete(mapelId) {
        if (confirm('Apakah Anda yakin ingin menghapus mapel ini?')) {
            document.getElementById('deleteForm' + mapelId).submit();
        }
    }
</script>

@endsection
