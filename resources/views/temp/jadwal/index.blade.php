@extends('layouts.app')
@section('title', 'Manajemen Jadwal')
@section('content')

    <section class="section">
        <div class="row" id="table-bordered">
            <!-- Notifikasi Success/Error -->
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

            @if ($errors->has('jadwal'))
                <div class="alert alert-light-danger color-danger">
                    <i class="bi bi-exclamation-circle"></i> {{ $errors->first('jadwal') }}
                </div>
            @endif

            <!-- Menampilkan Jadwal per Kelas -->
            @foreach ($kelas as $kls)
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Jadwal Kelas {{ $kls->nama_kelas }}</h4>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahJadwalModal{{ $kls->id }}">Tambah Jadwal</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Hari</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Mata Pelajaran</th>
                                            <th class="text-center">Guru</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kls->jadwal as $jadwal)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $jadwal->hari }}</td>
                                                <td class="text-center">{{ $jadwal->waktu_mulai }} -
                                                    {{ $jadwal->waktu_selesai }}</td>
                                                <td class="text-center">{{ $jadwal->mapel->nama_mapel }}</td>
                                                <td class="text-center">{{ $jadwal->mapel->guru->name }}</td>
                                                <td class="text-center">
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editJadwalModal{{ $jadwal->id }}">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}"
                                                            method="POST" id="deleteForm{{ $jadwal->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $jadwal->id }})">
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
            @endforeach
        </div>
    </section>

    @foreach ($kelas as $kls)
    <!-- Modal Tambah Jadwal -->
    <x-modal :id="'tambahJadwalModal' . $kls->id" :title="'Tambah Jadwal Kelas ' . $kls->nama_kelas">
        <form action="{{ route('admin.jadwal.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kls->id }}">

            <div class="mb-3">
                <label for="hari{{ $kls->id }}" class="form-label">Hari</label>
                <select name="hari" id="hari{{ $kls->id }}" class="form-select" required>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option value="{{ $hari }}">{{ $hari }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="waktu_mulai{{ $kls->id }}" class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" id="waktu_mulai{{ $kls->id }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="waktu_selesai{{ $kls->id }}" class="form-label">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" id="waktu_selesai{{ $kls->id }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mapel_id{{ $kls->id }}" class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id{{ $kls->id }}" class="form-select" required onchange="updateGuruId(this)">
                    <option value="" disabled selected>Pilih Mata Pelajaran</option> <!-- Tambahkan baris ini -->
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" data-guru="{{ $mapel->guru_id }}">
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="guru_id" id="guru_id{{ $kls->id }}">
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>

    @foreach ($kls->jadwal as $jadwal)
    <!-- Modal Edit Jadwal -->
    <x-modal :id="'editJadwalModal' . $jadwal->id" :title="'Edit Jadwal ' . $kls->nama_kelas">
        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="kelas_id" value="{{ $kls->id }}">

            <div class="mb-3">
                <label for="edit_hari{{ $jadwal->id }}" class="form-label">Hari</label>
                <select name="hari" id="edit_hari{{ $jadwal->id }}" class="form-select" required>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option value="{{ $hari }}" {{ $jadwal->hari == $hari ? 'selected' : '' }}>
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_waktu_mulai{{ $jadwal->id }}" class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" id="edit_waktu_mulai{{ $jadwal->id }}" class="form-control" value="{{ $jadwal->waktu_mulai }}" required>
            </div>

            <div class="mb-3">
                <label for="edit_waktu_selesai{{ $jadwal->id }}" class="form-label">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" id="edit_waktu_selesai{{ $jadwal->id }}" class="form-control" value="{{ $jadwal->waktu_selesai }}" required>
            </div>

            <div class="mb-3">
                <label for="edit_mapel_id{{ $jadwal->id }}" class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" id="edit_mapel_id{{ $jadwal->id }}" class="form-select" required>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ $mapel->id == $jadwal->mapel_id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>
@endforeach


@endforeach





    <script>
        function confirmDelete(jadwalId) {
            if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
                document.getElementById('deleteForm' + jadwalId).submit();
            }
        }
    </script>

@endsection
