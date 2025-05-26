@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
    <div class="page-heading">
        @if (session('success'))
            <div class="alert alert-light-success color-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        <div class="page-title mt-0 pt-0">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profile</h3>
                    <p class="text-subtitle text-muted">Halaman menampilkan informasi profil guru</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <!-- Kiri: Foto dan Nama -->
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar avatar-2xl rounded-circle mx-auto overflow-hidden"
                                style="width: 140px; height: 140px;">
                                @if ($user->foto)
                                    <img src="{{ Storage::url($user->foto) }}" alt="Foto Profil"
                                        class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center text-white"
                                        style="width: 140px; height: 140px;">
                                        FOTO
                                    </div>
                                @endif
                            </div>
                            <h3 class="mt-3">{{ $user->name }}</h3>
                            <p class="text-muted text-capitalize">{{ $user->role }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Detail Profil (Tampilan Bukan Input) -->
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $biodata = [
                                    ['icon' => 'bi bi-credit-card', 'label' => 'NIP', 'value' => $user->nip ?? '-'],
                                    ['icon' => 'bi bi-envelope', 'label' => 'Email', 'value' => $user->email],
                                    [
                                        'icon' => 'bi bi-gender-ambiguous',
                                        'label' => 'Jenis Kelamin',
                                        'value' => $user->jenis_kelamin,
                                    ],
                                    [
                                        'icon' => 'bi bi-telephone',
                                        'label' => 'Telepon',
                                        'value' => $user->telepon ?? '-',
                                    ],
                                    ['icon' => 'bi bi-geo-alt', 'label' => 'Alamat', 'value' => $user->alamat ?? '-'],
                                    [
                                        'icon' => 'bi bi-calendar-date',
                                        'label' => 'Tanggal Lahir',
                                        'value' => $user->tanggal_lahir
                                            ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y')
                                            : '-',
                                    ],
                                    [
                                        'icon' => 'bi bi-person-badge',
                                        'label' => 'Wali Kelas',
                                        'value' => $kelasDiampu !== '-' ? $kelasDiampu : '-',
                                    ],
                                ];
                            @endphp

                            @foreach ($biodata as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <i class="{{ $item['icon'] }} fs-5 text-primary me-3" style="width: 28px;"></i>
                                    <div>
                                        <div class="form-label fw-semibold mb-1">{{ $item['label'] }}</div>
                                        <p class="mb-0">{{ $item['value'] }}</p>
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





    <x-modal id="editProfileModal" title="Edit Profil Guru">
        <form action="{{ route('guru.profil.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" name="telepon" value="{{ $user->telepon }}">
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" value="{{ $user->alamat }}">
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="foto" accept="image/*">
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </x-modal>

@endsection
