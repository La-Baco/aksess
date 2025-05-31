@extends('layouts.app')
@section('title', 'Pengajuan Izin')

@section('content')
<div class="container">
    <h4>Daftar Izin Saya</h4>
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
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Izin Saya</h4>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalIzinBaru">
                            + Ajukan Izin
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Alasan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($izinList as $izin)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $izin->tanggal_mulai }} s/d {{ $izin->tanggal_selesai }}</td>
                                            <td class="text-center">{{ $izin->alasan }}</td>
                                            <td class="text-center">
                                                @if ($izin->status === 'Disetujui')
                                                    <span class="badge bg-success">{{ $izin->status }}</span>
                                                @elseif ($izin->status === 'Menunggu')
                                                    <span class="badge bg-warning text-dark">{{ $izin->status }}</span>
                                                @elseif ($izin->status === 'Ditolak')
                                                    <span class="badge bg-danger">{{ $izin->status }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $izin->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($izin->isMenunggu())
                                                    <form action="{{ route('siswa.izin.destroy', $izin->id) }}" method="POST" onsubmit="return confirm('Batalkan izin ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">Batalkan</button>
                                                    </form>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data izin.</td>
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

    <!-- Modal untuk form pengajuan izin -->
    <x-modal id="modalIzinBaru" title="Form Pengajuan Izin">
        <form action="{{ route('siswa.izin.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggal_mulai" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" name="tanggal_selesai" required>
            </div>
            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan Izin</label>
                <textarea class="form-control" name="alasan" rows="3" required></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Ajukan</button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
