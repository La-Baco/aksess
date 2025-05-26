@extends('layouts.app')
@section('title', 'Manajemen Hari Libur')
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

        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Hari Libur</h4>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#tambahHariLiburModal">Tambah Hari Libur</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hariLiburs as $libur)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $libur->nama }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($libur->tanggal)->format('d M Y') }}</td>
                                        <td class="text-center">{{ $libur->keterangan ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#editHariLiburModal{{ $libur->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Tombol Delete -->
                                                <form action="{{ route('admin.hari-libur.destroy', $libur->id) }}" method="POST" id="deleteForm{{ $libur->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" onclick="confirmDelete({{ $libur->id }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data hari libur.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Hari Libur -->
<x-modal :id="'tambahHariLiburModal'" :title="'Tambah Hari Libur'" :user="'hariLiburModal'">
    <form action="{{ route('admin.hari-libur.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Hari Libur</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
    </form>
</x-modal>

<!-- Modal Edit Hari Libur -->
@foreach ($hariLiburs as $libur)
    <x-modal :id="'editHariLiburModal' . $libur->id" :title="'Edit Hari Libur'" :user="'hariLiburModal'">
        <form action="{{ route('admin.hari-libur.update', $libur->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_nama_{{ $libur->id }}" class="form-label">Nama Hari Libur</label>
                <input type="text" name="nama" id="edit_nama_{{ $libur->id }}" class="form-control" value="{{ $libur->nama }}" required>
            </div>
            <div class="mb-3">
                <label for="edit_tanggal_{{ $libur->id }}" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="edit_tanggal_{{ $libur->id }}" class="form-control" value="{{ $libur->tanggal }}" required>
            </div>
            <div class="mb-3">
                <label for="edit_keterangan_{{ $libur->id }}" class="form-label">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="edit_keterangan_{{ $libur->id }}" rows="3" class="form-control">{{ $libur->keterangan }}</textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>
@endforeach

<script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus hari libur ini?')) {
            document.getElementById('deleteForm' + id).submit();
        }
    }
</script>

@endsection
