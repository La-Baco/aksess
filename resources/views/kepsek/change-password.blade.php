@extends('layouts.app')
@section('title', 'Change-Password')
@section('content')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Change Password</h3>
                    <p class="text-subtitle text-muted">Halaman Ubah Password</p>
                </div>
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
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('kepsek.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">change-password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kepsek.update-password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Password Lama --}}
                                <div class="form-group my-2">
                                    <label for="current_password" class="form-label">Password Lama</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            placeholder="Masukkan password lama">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash toggle-password" data-target="#current_password"
                                                style="cursor: pointer;"></i>
                                        </span>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password Baru --}}
                                <div class="form-group my-2">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password baru">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash toggle-password-group" data-main="#password"
                                                data-confirm="#password_confirmation" style="cursor: pointer;"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Konfirmasi Password Baru --}}
                                <div class="form-group my-2">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Ulangi password baru">
                                </div>

                                <div class="form-group my-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@section('js')

    <script>
        // Toggle untuk password lama (sendiri)
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const input = document.querySelector(this.getAttribute('data-target'));
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });

        // Toggle untuk password baru dan konfirmasi secara bersamaan
        document.querySelectorAll('.toggle-password-group').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const mainInput = document.querySelector(this.getAttribute('data-main'));
                const confirmInput = document.querySelector(this.getAttribute('data-confirm'));

                const isPassword = mainInput.type === 'password';

                mainInput.type = isPassword ? 'text' : 'password';
                confirmInput.type = isPassword ? 'text' : 'password';

                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>
@endsection
@endsection
