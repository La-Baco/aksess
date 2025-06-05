@extends('layouts.app')
@section('title', 'Manajemen Kelas')
@section('content')

    <section class="section">
        <div class="row">
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
            <!-- Card Daftar Kelas -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Kelas</h4>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#tambahKelasModal">Tambah Kelas</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Kelas</th>
                                        <th class="text-center">Wali Kelas</th>
                                        <th class="text-center">Kapasitas</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $kelasItem)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center"> {{ $kelasItem->nama_kelas }}</td>
                                            <td class="text-center">{{ $kelasItem->guruWali->first()->name ?? '-' }}</td>
                                            <td class="text-center">
                                                {{ $kelasItem->siswa->count() }}/{{ $kelasItem->kapasitas }}
                                            </td>
                                            <td class="text-center">
                                                <div
                                                    style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                                    <!-- Link untuk detail kelas -->
                                                    <a href="{{ route('admin.kelas.detail', $kelasItem->id) }}"
                                                        class="btn btn-info btn-sm d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    <!-- Tombol Edit -->
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editKelasModal{{ $kelasItem->id }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <!-- Tombol Delete -->
                                                    <form action="{{ route('admin.kelas.destroy', $kelasItem->id) }}"
                                                        method="POST" id="deleteForm{{ $kelasItem->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                            onclick="confirmDelete({{ $kelasItem->id }})">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
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

    <x-modal :id="'tambahKelasModal'" :title="'Tambah Kelas'" :user="'kelasModal'">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kapasitas" class="form-label">Kapasitas</label>
                <input type="number" name="kapasitas" id="kapasitas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="guru_id" class="form-label">Wali Kelas</label>
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
    @foreach ($kelas as $kelasItem)
        <x-modal :id="'editKelasModal' . $kelasItem->id" :title="'Edit Kelas'" :user="'kelasModal'">
            <form action="{{ route('admin.kelas.update', $kelasItem->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="edit_nama_kelas_{{ $kelasItem->id }}" class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="edit_nama_kelas_{{ $kelasItem->id }}" class="form-control"
                        value="{{ $kelasItem->nama_kelas }}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_kapasitas_{{ $kelasItem->id }}" class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" id="edit_kapasitas_{{ $kelasItem->id }}" class="form-control"
                        value="{{ $kelasItem->kapasitas }}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_guru_id_{{ $kelasItem->id }}" class="form-label">Wali Kelas</label>
                    <select name="guru_id" id="edit_guru_id_{{ $kelasItem->id }}" class="form-select" required>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}"
                                {{ optional($kelasItem->guruWali->first())->id == $guru->id ? 'selected' : '' }}>
                                {{ $guru->name }}
                            </option>
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

@endsection
