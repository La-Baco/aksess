<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>

    <link href="{{ asset('assets/images/logo/ikon.svg') }} " rel="icon">
    <link href="{{ asset('assets2/images/logo/apple-touch-icon.png') }} " rel="apple-touch-icon">


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg" type="image/x-icon') }}">
    @yield('css')
</head>

<body>
    <div id="app">
        <!-- side bar -->
        @include('layouts.sidebar')
        <div id="main" class='layout-navbar'>
            <header class='mb-1 p-1'>
                <nav class="navbar navbar-expand navbar-light">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="customNavbarContent">
                            <ul class="navbar-nav ms-auto d-flex align-items-center gap-3">

                            <!-- User Profile Dropdown -->
                            <div class="dropdown ms-4 me-3" id="dropdownUser">
                                <a href="#" class="d-flex align-items-center text-decoration-none" id="userToggle">
                                    <div class="me-3 text-end user-info">
                                        <div class="fw-semibold text-dark">{{ auth()->user()->name }}</div>
                                        <small class="text-secondary">
                                            {{ auth()->user()->role === 'kepsek' ? 'Kepala Sekolah' : ucfirst(auth()->user()->role) }}
                                        </small>
                                    </div>
                                    <img src="{{ auth()->user()->foto
                                    ? asset(Storage::url(auth()->user()->foto))
                                    : asset('assets/images/faces/default.jpg') }}"
                             alt="User Avatar"
                             class="rounded-circle border border-2 border-primary" width="42" height="42" />

                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow p-2 " style=" right:0rem !important"
                                    aria-labelledby="userToggle" style="display:none;">
                                    <li>
                                        <h6 class="dropdown-header">Welcome back, {{ auth()->user()->name }}</h6>
                                    </li>
                                    <li>
                                        @php
                                            $role = auth()->user()->role;
                                        @endphp

                                        @if ($role === 'guru')
                                            <a class="dropdown-item" href="{{ route('guru.profil') }}">
                                                <i class="bi bi-person-fill me-2"></i>My Profile
                                            </a>
                                        @elseif ($role === 'siswa')
                                            <a class="dropdown-item" href="{{ route('siswa.profil') }}">
                                                <i class="bi bi-person-fill me-2"></i>My Profile
                                            </a>
                                        @elseif ($role === 'kepsek')
                                            <a class="dropdown-item" href="{{ route('kepsek.profil') }}">
                                                <i class="bi bi-person-fill me-2"></i>My Profile
                                            </a>
                                        @endif
                                    </li>

                                    <li><a class="dropdown-item" href="#"><i
                                                class="bi bi-gear-fill me-2"></i>Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <form id="logoutFormCustom" action="{{ route('logout') }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                    </form>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" id="logoutBtn">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </nav>
            </header>
            <div id="main-content" class="mt-0 ">

                <!-- konten -->
                @yield('content')

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2025 &copy; Aksess</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"></span> by <a
                                    href="http://ahmadsaugi.com">LaBaco</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>


    @yield('js')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleDropdown(toggleId, menuSelector) {
                const toggleBtn = document.getElementById(toggleId);
                const dropdownMenu = toggleBtn.nextElementSibling;

                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isShown = dropdownMenu.style.display === 'block';
                    closeAllDropdowns();
                    if (!isShown) {
                        dropdownMenu.style.display = 'block';
                    }
                });
            }

            function closeAllDropdowns() {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }

            document.addEventListener('click', function(event) {
                const isClickInsideDropdown = event.target.closest('.dropdown');
                if (!isClickInsideDropdown) {
                    closeAllDropdowns();
                }
            });


            toggleDropdown('userToggle');

            const logoutBtn = document.getElementById('logoutBtn');
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('logoutFormCustom').submit();
            });
        });
    </script>

</html>
