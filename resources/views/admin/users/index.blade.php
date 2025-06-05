@extends('layouts.app')
@section('title', 'Manajemen User')
@section('content')

    <section class="section">
        <div class="row" id="table-bordered">
            <!-- Admin Table -->
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
                        <h4 class="card-title">Data Admin</h4>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#tambahAdminModal">Tambah Admin</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Jenis Kelamin</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $admin->name }}</td>
                                            <td class="text-center">{{ $admin->email }}</td>
                                            <td class="text-center">{{ $admin->jenis_kelamin ?? '-' }}</td>
                                            <!-- Jenis Kelamin -->
                                            <td class="text-center">{{ $admin->role }}</td>
                                            <td class="text-center">
                                                <div
                                                    style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                                                        data-bs-toggle="modal" data-bs-target="#editAdminModal"><i
                                                            class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <form action="{{ route('admin.users.destroy', $admin->id) }}"
                                                        method="POST" id="deleteForm{{ $admin->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                                            onclick="confirmDelete({{ $admin->id }})"><i
                                                                class="bi bi-trash"></i></button>
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

    <!-- Modal Tambah Admin -->
    <x-modal :id="'tambahAdminModal'" :title="'Tambah Admin'" :user="'adminModal'">
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="admin">

            <div class="mb-3 form-group has-icon-left">
                <label for="name" class="form-label">Nama</label>
                <div class="position-relative">
                    <input type="text" name="name" id="name" class="form-control" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="email" class="form-label">Email</label>
                <div class="position-relative">
                    <input type="email" name="email" id="email" class="form-control" required placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="password" class="form-label">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div class="form-control-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    <i class="bi bi-eye-slash toggle-password position-absolute top-0 end-0 mt-2 me-3"
                            style="cursor: pointer;"></i>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="position-relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <div class="position-relative">
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <div class="form-control-icon">
                        <i class="bi bi-gender-ambiguous"></i>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Edit Admin -->
    <x-modal :id="'editAdminModal'" :title="'Edit Admin'" :user="'adminModal'">
        <form action="{{ route('admin.update', $admin->id) }}" method="POST" id="editAdminForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="admin">

            <div class="mb-3 form-group has-icon-left">
                <label for="edit_name" class="form-label">Nama</label>
                <div class="position-relative">
                    <input type="text" name="name" id="edit_name" class="form-control" value="{{ $admin->name }}" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="edit_email" class="form-label">Email</label>
                <div class="position-relative">
                    <input type="email" name="email" id="edit_email" class="form-control" value="{{ $admin->email }}" required>
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="edit_password" class="form-label">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" id="edit_password" class="form-control">
                    <div class="form-control-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    <i class="bi bi-eye-slash toggle-password position-absolute top-0 end-0 mt-2 me-3"
                            style="cursor: pointer;"></i>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="edit_password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="position-relative">
                    <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group has-icon-left">
                <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <div class="position-relative">
                    <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select" required>
                        <option value="Laki-laki" {{ $admin->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $admin->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <div class="form-control-icon">
                        <i class="bi bi-gender-ambiguous"></i>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-modal>



    @section('js')
    <script>
        function confirmDelete(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                document.getElementById('deleteForm' + userId).submit();
            }
        }
    </script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const ids = ['password', 'password_confirmation', 'edit_password',
                    'edit_password_confirmation'
                ];

                ids.forEach(function(id) {
                    const input = document.getElementById(id);
                    if (input) {
                        input.type = input.type === 'password' ? 'text' : 'password';
                    }
                });

                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>

@endsection


@endsection
