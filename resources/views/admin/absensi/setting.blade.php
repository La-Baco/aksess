@extends('layouts.app')
@section('title', 'Pengaturan Absensi')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

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

                {{-- Jika belum ada setting --}}
                @if (!$setting)
                    <div class="card border-0 shadow text-center p-4">
                        <h4 class="mb-3 text-primary mt-3"><i class="bi bi-gear-wide-connected position-relative"
                                style="top: 3px;"></i>
                            </i> &nbsp;Belum Ada Pengaturan</h4>
                        <p class="text-muted">Silakan tambahkan pengaturan awal absensi untuk menentukan waktu dan lokasi
                            yang valid.</p>
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Pengaturan
                        </button>
                    </div>

                    {{-- Jika sudah ada setting --}}
                @else
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary bg-gradient text-white py-3 rounded-top">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-geo-alt-fill fs-4 text-white mb-2"></i>
                                <h5 class="mb-0 fw-semibold text-white">&nbsp; Pengaturan Absensi Aktif</h5>
                            </div>
                        </div>


                        <div class="card-body bg-light mb-4">


                            <ul class="list-group list-group-flush mt-4">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><strong>Jam Mulai</strong></span>
                                    <span class="text-primary fw-semibold">{{ $setting->jam_mulai }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><strong>Jam Selesai</strong></span>
                                    <span class="text-primary fw-semibold">{{ $setting->jam_selesai }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><strong>Latitude</strong></span>
                                    <span class="text-success fw-semibold">{{ $setting->lokasi_lat }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><strong>Longitude</strong></span>
                                    <span class="text-success fw-semibold">{{ $setting->lokasi_long }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><strong>Radius Lokasi</strong></span>
                                    <span class="badge bg-info ">{{ $setting->radius_meter }} meter</span>
                                </li>
                            </ul>
                        </div>

                        <div class="card-footer text-center bg-white border-top-0">
                            <button class="btn btn-outline-danger px-4 py-2" data-bs-toggle="modal"
                                data-bs-target="#modalReset">
                                <i class="bi bi-trash3 me-1"></i> Reset Pengaturan
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <x-modal id="modalCreate" title="Tambah Pengaturan Absensi">
        <form action="{{ route('admin.absensi.setting.store') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai Hadir</label>
                <input type="time" id="jam_mulai" name="jam_mulai"
                    class="form-control @error('jam_mulai') is-invalid @enderror" required value="{{ old('jam_mulai') }}">
                @error('jam_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai Hadir</label>
                <input type="time" id="jam_selesai" name="jam_selesai"
                    class="form-control @error('jam_selesai') is-invalid @enderror" required
                    value="{{ old('jam_selesai') }}">
                @error('jam_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi_lat" class="form-label">Latitude Lokasi</label>
                <input type="text" id="lokasi_lat" name="lokasi_lat"
                    class="form-control @error('lokasi_lat') is-invalid @enderror" required
                    value="{{ old('lokasi_lat') }}">
                @error('lokasi_lat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi_long" class="form-label">Longitude Lokasi</label>
                <input type="text" id="lokasi_long" name="lokasi_long"
                    class="form-control @error('lokasi_long') is-invalid @enderror" required
                    value="{{ old('lokasi_long') }}">
                @error('lokasi_long')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="radius_meter" class="form-label">Radius Lokasi (meter)</label>
                <input type="number" id="radius_meter" name="radius_meter"
                    class="form-control @error('radius_meter') is-invalid @enderror" min="10" required
                    value="{{ old('radius_meter') }}">
                @error('radius_meter')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="reset" class="btn btn-secondary">Reset Form</button>
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Konfirmasi Reset --}}
    @if ($setting)
        <div class="modal fade" id="modalReset" tabindex="-1" aria-labelledby="modalResetLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalResetLabel">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Reset
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="mb-3">Apakah Anda yakin ingin <strong>menghapus pengaturan absensi ini</strong>?</p>
                        <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form action="{{ route('admin.absensi.setting.reset') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4">Ya, Reset</button>
                        </form>

                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

