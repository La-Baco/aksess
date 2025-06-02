@extends('layouts.app')
@section('title', 'Profil Siswa')

@section('content')
    <div class="page-heading ">
        @if (session('success'))
            <div class="alert alert-light-success color-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        <div class="page-title mt-0 pt-0">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="mb-1">Profil Siswa</h3>
                    <p class="text-subtitle text-muted">Halaman menampilkan informasi profil siswa</p>
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
                                    ['icon' => 'bi bi-credit-card', 'label' => 'NIS', 'value' => $user->nis],
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
                                    ['icon' => 'bi bi-building', 'label' => 'Kelas', 'value' => $kelas ?? '-'],
                                ];
                            @endphp

                            @foreach ($biodata as $item)
                                <div class="d-flex align-items-center mb-3 border rounded p-2">
                                    <i class="{{ $item['icon'] }} fs-4 text-primary me-3" style="width: 30px;"></i>
                                    <div>
                                        <label class="form-label fw-bold mb-0">{{ $item['label'] }}</label>
                                        <p class="form-control-plaintext mb-0">{{ $item['value'] }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4 ">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Profile
                                </button>
                                <a href="{{ route('siswa.change-password') }}" class="btn btn-warning">
                                    <i class="bi bi-lock-fill me-2"></i> Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modal Edit Profil --}}
        <x-modal id="editProfileModal" title="Edit Profil Siswa">
            <form id="form-profil">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="form-control"
                        value="{{ old('telepon', $user->telepon) }}">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Profil (opsional)</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="simpan">

                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" id="spinner-simpan" aria-hidden="true"></span> Simpan</button>
                </div>
            </form>
        </x-modal>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/extensions/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
  document.getElementById('simpan').addEventListener('click', function (e) {
        e.preventDefault();
        const btn = document.getElementById('simpan');
        const spinner = document.getElementById('spinner-simpan');
   spinner.classList.remove('d-none');
   btn.setAttribute('disabled', true);

        let form = document.getElementById('form-profil');
        let formData = new FormData(form);
        formData.append('_method', 'PUT');


        axios.post("{{ route('siswa.profil.update') }}", formData)
            .then(function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Profil berhasil diperbarui!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    const modalEl = document.getElementById('editProfileModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    modalInstance.hide();

                    location.reload();
                });
            })
            .catch(function (error) {
                let message = 'Terjadi kesalahan saat memperbarui profil.';
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    message = Object.values(errors).map(errArr => errArr.join(', ')).join('\n');
                } else if (error.response && error.response.data && error.response.data.message) {
                    message = error.response.data.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: message,
                });
            })
        .finally(() => {
            spinner.classList.add('d-none');
            btn.removeAttribute('disabled');
        });
    });
    </script>
@endsection
