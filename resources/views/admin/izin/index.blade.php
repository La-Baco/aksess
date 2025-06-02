@extends('layouts.app')
@section('title', 'Daftar Pengajuan Izin')

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
                    <h4 class="card-title">Daftar Pengajuan Izin</h4>
                    {{-- Jika dibutuhkan tombol tambah pengajuan (opsional), aktifkan baris di bawah --}}
                    {{--
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahIzinModal">
                        Tambah Pengajuan Izin
                    </button>
                    --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tanggal Mulai</th>
                                    <th class="text-center">Tanggal Selesai</th>
                                    <th class="text-center">Alasan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Disetujui/Ditolak Oleh</th>
                                    <th class="text-center" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($izins as $izin)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $izin->user->name }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}
                                        </td>
                                        <td class="text-center">{{ $izin->alasan }}</td>
                                        <td class="text-center">
                                            @if ($izin->status === 'Menunggu')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif ($izin->status === 'Disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $izin->disetujuiOleh?->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                {{-- Jika status Menunggu, tampilkan tombol Setujui dan Tolak --}}
                                                @if ($izin->status === 'Menunggu')
                                                    <form action="{{ route('admin.izin.update', $izin->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Disetujui">
                                                        <button
                                                            type="button"
                                                            class="btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            title="Setujui"
                                                        >
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.izin.update', $izin->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <input type="hidden" name="ditolak_alasan" value="—">
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            title="Tolak"
                                                        >
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </form>

                                                {{-- Jika status Disetujui, tampilkan tombol Batalkan Persetujuan --}}
                                                @elseif ($izin->status === 'Disetujui')
                                                    <form action="{{ route('admin.izin.update', $izin->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Menunggu">
                                                        <button
                                                            type="button"
                                                            class="btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            title="Batalkan Persetujuan"
                                                        >
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </form>

                                                {{-- Jika status Ditolak, tampilkan tombol Batalkan Penolakan --}}
                                                @elseif ($izin->status === 'Ditolak')
                                                    <form action="{{ route('admin.izin.update', $izin->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Menunggu">
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary btn-sm d-flex align-items-center justify-content-center"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            title="Batalkan Penolakan"
                                                        >
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('admin.izin.destroy', $izin->id) }}" method="POST" id="deleteFormIzin{{ $izin->id }}" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                        onclick="confirmIzinDelete({{ $izin->id }})"
                                                        title="Hapus"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada pengajuan izin.</td>
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

<script>
    function confirmIzinDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus pengajuan izin ini?')) {
            document.getElementById('deleteFormIzin' + id).submit();
        }
    }
</script>
@endsection
