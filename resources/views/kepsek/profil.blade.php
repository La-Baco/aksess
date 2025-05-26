@extends('layouts.app')
@section('title', 'Profil Kepsek')

@section('content')
<div class="page-heading">
     @if (session('success'))
            <div class="alert alert-light-success color-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif
    <div class="page-title">
        <h3>Profil Kepala Sekolah</h3>
        <p class="text-muted">Informasi profil Anda sebagai kepala sekolah</p>
    </div>

    <section class="section mt-3">
        <div class="row">
            <!-- Kiri: Foto dan Nama -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar avatar-2xl rounded-circle mx-auto overflow-hidden" style="width: 140px; height: 140px;">
                            @if ($user->foto)
                                <img src="{{ Storage::url($user->foto) }}" alt="Foto Profil" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 140px; height: 140px;">
                                    FOTO
                                </div>
                            @endif
                        </div>
                        <h3 class="mt-3">{{ $user->name }}</h3>
                        <p class="text-muted text-capitalize">{{ $user->role === 'kepsek' ? 'Kepala Sekolah' : ucfirst($user->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Kanan: Biodata -->
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @php
                            $biodata = [
                                ['icon' => 'bi bi-credit-card', 'label' => 'NIP', 'value' => $user->nip],
                                ['icon' => 'bi bi-envelope', 'label' => 'Email', 'value' => $user->email],
                                ['icon' => 'bi bi-gender-ambiguous', 'label' => 'Jenis Kelamin', 'value' => $user->jenis_kelamin],
                                ['icon' => 'bi bi-telephone', 'label' => 'Telepon', 'value' => $user->telepon ?? '-'],
                                ['icon' => 'bi bi-geo-alt', 'label' => 'Alamat', 'value' => $user->alamat ?? '-'],
                                ['icon' => 'bi bi-calendar-date', 'label' => 'Tanggal Lahir', 'value' => $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '-'],
                            ];
                        @endphp

                        @foreach ($biodata as $item)
                            <div class="d-flex align-items-center border rounded p-2 mb-2 bg-light">
                                <i class="{{ $item['icon'] }} fs-5 text-primary me-3" style="width: 30px;"></i>
                                <div>
                                    <label class="form-label fw-bold mb-0">{{ $item['label'] }}</label>
                                    <p class="form-control-plaintext mb-0">{{ $item['value'] }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-square me-2"></i> Edit Profil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal Edit Profil -->
<x-modal id="editProfileModal" title="Edit Profil Kepala Sekolah">
    <form action="{{ route('kepsek.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</x-modal>


@endsection
