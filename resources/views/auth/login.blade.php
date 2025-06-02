<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="{{ asset('assets/images/logo/ikon.svg') }} " rel="icon">
    <link href="{{ asset('assets2/images/logo/apple-touch-icon.png') }} " rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
</head>
<style>
    .toggle-password {
        cursor: pointer;
        font-size: 1.4rem;
        color: #6c757d;
        transition: color 0.3s ease;
        user-select: none;
    }

    .toggle-password:hover {
        color: #0d6efd;
    }
</style>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left" class="p-5">
                    <div class="auth-logo">
                        <a href="{{ route('home.index') }}">
                            <img src="{{ asset('assets/images/logo/aksess-logo.png') }} "style="width: 200px; height: auto; display: block; margin: 0 auto;"
                                alt="Logo" class="pt-2 ">
                        </a>
                    </div>
                    <h1 class="auth-title ">Log in.</h1>
                    <p class="auth-subtitle mb-5">Please log in using your registered email and password.</p>
                    <div class="card border shadow-lg p-4">
                        @if (session('msg'))
                            <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
                                {{ session('msg') }}
                            </div>
                        @endif


                        <form action="{{ route('auth.verify') }}" method="POST">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="email" name="email" class="form-control form-control-xl"
                                    placeholder="Username" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-xl" placeholder="Password" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <span class="position-absolute end-0 top-50 translate-middle-y me-3 toggle-password"
                                    onclick="togglePassword()">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            <div class="form-check form-check-lg d-flex align-items-end mb-4">
                                <input class="form-check-input me-2" type="checkbox" value=""
                                    id="flexCheckDefault">
                                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                    Keep me logged in
                                </label>
                            </div>
                            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3" type="submit">Log
                                in</button>
                        </form>
                    </div>


                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account?
                            <a href="auth-register.html" class="font-bold">Sign up</a>.
                        </p>
                        <p>
                            <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right" class="d-flex justify-content-center align-items-center text-white text-center p-5" ">
                    <div>
                        <h1 class="display-5 fw-bold text-white">Selamat Datang di <br>AKSESS</h1>
                        <p class="mt-4">Meningkatkan efisiensi dan akurasi absensi siswa secara digital.<br>Login untuk memulai!</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>

</html>
