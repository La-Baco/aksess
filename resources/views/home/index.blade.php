<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Aksess</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/images/logo/ikon.svg') }} " rel="icon">
    <link href="{{ asset('assets2/images/logo/apple-touch-icon.png') }} " rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets2/vendor/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }} " rel="stylesheet">
    <link href="{{ asset('assets2/vendor/aos/aos.css" rel="stylesheet') }} ">
    <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }} " rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets2/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: FlexStart
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Updated: Nov 01 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img class="mb-2" src="{{ asset('assets/images/logo/aksess-logo.png') }} " alt="">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home<br></a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}"><i
                    class="bi bi-person-fill"></i>&nbsp;Login</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1 data-aos="fade-up">Absensi Kehadiran Siswa Elektronik Smart System</h1>
                        <p data-aos="fade-up" data-aos-delay="100">Kelola Absensi dengan mudah cepat dan akurat sekarang
                            !!</p>
                        <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                            <a href="{{ route('login') }}" class="btn-get-started">Get Started <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                        <img src="{{ asset('assets2/img/hero-img.png') }} " class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container" data-aos="fade-up">
                <div class="row gx-0">

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="content">
                            <h3>Who We Are</h3>
                            <h2>AKSESS - Absensi Kehadiran Siswa Elektronik Smart System</h2>
                            <p>
                                AKSESS adalah sistem absensi digital yang dirancang khusus untuk sekolah guna memantau
                                kehadiran siswa secara efektif dan efisien. Dengan teknologi berbasis lokasi dan kontrol
                                admin, guru, serta siswa, AKSESS memberikan transparansi dan kemudahan dalam manajemen
                                kehadiran harian.
                            </p>
                            <p>
                                Melalui sistem ini, absensi dapat dilakukan secara otomatis berdasarkan lokasi,
                                dilengkapi dengan fitur pengajuan izin, validasi oleh kepala sekolah, serta pelaporan
                                yang akurat. AKSESS hadir sebagai solusi modern dalam meningkatkan disiplin dan
                                efisiensi administrasi sekolah.
                            </p>
                            <div class="text-center text-lg-start">
                                <a href="#"
                                    class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Read More</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                        <img src="{{ asset('assets2/img/about.jpg') }} " class="img-fluid" alt="">
                    </div>

                </div>
            </div>

        </section><!-- /About Section -->

        <!-- Values Section -->
        <section id="values" class="values section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Our Values</h2>
                <p>Core principles that drive AKSESS<br></p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card">
                            <img src="{{ asset('assets2/img/values-1.png') }}" class="img-fluid"
                                alt="Reliability Icon">
                            <h3>Reliability</h3>
                            <p>AKSESS memastikan data absensi siswa tercatat dengan akurat dan dapat dipercaya setiap
                                waktu.</p>
                        </div>
                    </div><!-- End Card Item -->

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card">
                            <img src="{{ asset('assets2/img/values-2.png') }}" class="img-fluid"
                                alt="Security Icon">
                            <h3>Security</h3>
                            <p>Privasi dan keamanan data siswa dan guru dijaga dengan sistem autentikasi dan validasi
                                yang ketat.</p>
                        </div>
                    </div><!-- End Card Item -->

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card">
                            <img src="{{ asset('assets2/img/values-3.png') }}" class="img-fluid"
                                alt="Innovation Icon">
                            <h3>Innovation</h3>
                            <p>Kami terus mengembangkan teknologi smart system untuk mempermudah proses absensi dan
                                manajemen sekolah.</p>
                        </div>
                    </div><!-- End Card Item -->

                </div>

            </div>

        </section><!-- /Values Section -->


        <!-- Stats Section -->
        <section id="stats" class="stats section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-people-fill color-blue flex-shrink-0" style="color: #007bff;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="500"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Pengguna Terdaftar</p>
                            </div>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-cloud-upload-fill color-orange flex-shrink-0" style="color: #ff7f00;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="1200"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Dokumen Tersimpan</p>
                            </div>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-gear-fill color-green flex-shrink-0" style="color: #28a745;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="850"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Permintaan Diproses</p>
                            </div>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-award-fill color-pink flex-shrink-0" style="color: #d6336c;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="25"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Penghargaan</p>
                            </div>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section -->

        <!-- Features Section -->
        <section id="features" class="features section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Features</h2>
                <p>Advanced Features of AKSESS</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-5">

                    <div class="col-xl-6" data-aos="zoom-out" data-aos-delay="100">
                        <img src="{{ asset('assets2/img/features.png') }}" class="img-fluid"
                            alt="AKSESS Features Image">
                    </div>

                    <div class="col-xl-6 d-flex">
                        <div class="row align-self-center gy-4">

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Absensi Otomatis Berbasis Lokasi</h3>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Manajemen Data Siswa dan Guru</h3>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Jadwal Pelajaran Terintegrasi</h3>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Pengajuan Izin Siswa dan Guru</h3>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Laporan Absensi Lengkap dan Real-time</h3>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>Notifikasi dan Pengingat Otomatis</h3>
                                </div>
                            </div><!-- End Feature Item -->

                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Features Section -->

        <!-- Alt Features Section -->
        <section id="alt-features" class="alt-features section">

            <div class="container">

                <div class="row gy-5">

                    <div class="col-xl-7 d-flex order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">

                        <div class="row align-self-center gy-5">

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-shield-lock"></i>
                                <div>
                                    <h4>Keamanan Data Terjamin</h4>
                                    <p>Data pribadi siswa dan guru dilindungi dengan sistem keamanan berlapis dan
                                        enkripsi.</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-phone"></i>
                                <div>
                                    <h4>Mobile Friendly</h4>
                                    <p>AKSESS dapat diakses dengan mudah melalui perangkat mobile kapan saja dan di mana
                                        saja.</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-graph-up"></i>
                                <div>
                                    <h4>Dashboard Laporan Interaktif</h4>
                                    <p>Memudahkan guru dan admin dalam memantau absensi dan izin dengan grafik yang
                                        informatif.</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-clock-history"></i>
                                <div>
                                    <h4>Histori Absensi Lengkap</h4>
                                    <p>Riwayat kehadiran siswa tercatat rapi dan mudah diakses untuk analisa dan
                                        evaluasi.</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <div>
                                    <h4>Backup dan Restore Data</h4>
                                    <p>Mendukung sistem backup otomatis agar data absensi aman dan tidak hilang.</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-gear"></i>
                                <div>
                                    <h4>Pengaturan Fleksibel</h4>
                                    <p>Admin dapat mengatur jadwal, hari libur, dan parameter absensi sesuai kebutuhan
                                        sekolah.</p>
                                </div>
                            </div><!-- End Feature Item -->

                        </div>

                    </div>

                    <div class="col-xl-5 d-flex align-items-center order-1 order-xl-2" data-aos="fade-up"
                        data-aos-delay="100">
                        <img src="{{ asset('assets2/img/alt-features.png') }}" class="img-fluid"
                            alt="Alternative Features Image">
                    </div>

                </div>

            </div>

        </section><!-- /Alt Features Section -->


        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
                <p>Explore Our Core Services<br></p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item item-cyan position-relative">
                            <i class="bi bi-people icon"></i>
                            <h3>Manajemen Pengguna</h3>
                            <p>Memudahkan pengelolaan akun siswa, guru, dan admin dengan fitur akses yang aman dan mudah
                                diatur.</p>
                            <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item item-orange position-relative">
                            <i class="bi bi-calendar-check icon"></i>
                            <h3>Jadwal Pelajaran</h3>
                            <p>Mengelola jadwal kelas dan mapel secara terstruktur dengan notifikasi otomatis untuk guru
                                dan siswa.</p>
                            <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item item-teal position-relative">
                            <i class="bi bi-file-earmark-text icon"></i>
                            <h3>Absensi Online</h3>
                            <p>Absensi mudah dengan sistem berbasis lokasi untuk memastikan kehadiran siswa dan guru
                                secara akurat.</p>
                            <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item item-red position-relative">
                            <i class="bi bi-chat-dots icon"></i>
                            <h3>Pengajuan Izin</h3>
                            <p>Fitur pengajuan izin praktis bagi guru dan siswa dengan proses persetujuan terintegrasi.
                            </p>
                            <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item item-indigo position-relative">
                            <i class="bi bi-bar-chart-line icon"></i>
                            <h3>Laporan dan Statistik</h3>
                            <p>Menyediakan laporan lengkap tentang absensi, aktivitas pembelajaran, dan kinerja siswa.
                            </p>
                            <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item item-pink position-relative">
                            <i class="bi bi-shield-lock icon"></i>
                            <h3>Keamanan Data</h3>
                            <p>Menjamin keamanan data pengguna dengan proteksi berlapis dan pengelolaan hak akses yang
                                ketat.</p>
                            <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->


        <!-- Faq Section -->
        <section id="faq" class="faq section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>F.A.Q</h2>
                <p>Frequently Asked Questions</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                        <div class="faq-container">

                            <div class="faq-item faq-active">
                                <h3>Bagaimana cara mendaftar sebagai pengguna baru?</h3>
                                <div class="faq-content">
                                    <p>Anda dapat menghubungi admin sekolah untuk mendapatkan akun, atau menggunakan
                                        fitur registrasi yang disediakan (jika aktif).</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Apakah data absensi bisa dilihat oleh orang tua?</h3>
                                <div class="faq-content">
                                    <p>Ya, dengan akses khusus, orang tua dapat melihat data absensi anaknya melalui
                                        akun yang terhubung.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Bagaimana sistem absensi menggunakan lokasi bekerja?</h3>
                                <div class="faq-content">
                                    <p>Sistem kami menggunakan teknologi geolokasi untuk memastikan bahwa absensi hanya
                                        bisa dilakukan saat berada di area sekolah.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div><!-- End Faq Column-->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                        <div class="faq-container">

                            <div class="faq-item">
                                <h3>Bagaimana cara mengajukan izin ketidakhadiran?</h3>
                                <div class="faq-content">
                                    <p>Pengguna dapat mengajukan izin melalui menu izin yang tersedia, kemudian akan
                                        diproses oleh kepala sekolah atau guru yang berwenang.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Bisakah jadwal pelajaran diubah secara mandiri oleh guru?</h3>
                                <div class="faq-content">
                                    <p>Perubahan jadwal harus melalui admin sekolah untuk menjaga konsistensi dan
                                        keteraturan sistem.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Apakah data pengguna dan absensi aman?</h3>
                                <div class="faq-content">
                                    <p>Keamanan data adalah prioritas kami, dengan enkripsi dan proteksi akses untuk
                                        menjaga kerahasiaan dan integritas data.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div><!-- End Faq Column-->

                </div>

            </div>

        </section><!-- /Faq Section -->


        <!-- Team Section -->
        <section id="team" class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Team</h2>
                <p>Our hard working team</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="100">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('assets2/img/team/team-1.jpg') }} " class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Walter White</h4>
                                <span>Chief Executive Officer</span>
                                <p>Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur ipsa quae aut.
                                    Ipsum exercitationem iure minima enim corporis et voluptate.</p>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('assets2/img/team/team-2.jpg') }} " class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Sarah Jhonson</h4>
                                <span>Product Manager</span>
                                <p>Quo esse repellendus quia id. Est eum et accusantium pariatur fugit nihil minima
                                    suscipit corporis. Voluptate sed quas reiciendis animi neque sapiente.</p>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="300">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('assets2/img/team/team-3.jpg') }} " class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>William Anderson</h4>
                                <span>CTO</span>
                                <p>Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae deserunt.
                                    Voluptates enim aut architecto porro aspernatur molestiae modi.</p>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('assets2/img/team/team-4.jpg') }} " class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                                <p>Rerum voluptate non adipisci animi distinctio et deserunt amet voluptas. Quia aut
                                    aliquid doloremque ut possimus ipsum officia.</p>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                </div>

            </div>

        </section><!-- /Team Section -->

        <!-- Clients Section -->
        <section id="clients" class="clients section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Clients</h2>
                <p>We work with best clients<br></p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-1.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-2.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-3.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-4.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-5.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-6.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-7.png') }} "
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets2/img/clients/client-8.png') }} "
                                class="img-fluid" alt=""></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section><!-- /Clients Section -->


        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-6">

                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="200">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Address</h3>
                                    <p>A108 Adam Street</p>
                                    <p>New York, NY 535022</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="300">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Call Us</h3>
                                    <p>+1 5589 55488 55</p>
                                    <p>+1 6678 254445 41</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="400">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p>info@example.com</p>
                                    <p>contact@example.com</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item" data-aos="fade" data-aos-delay="500">
                                    <i class="bi bi-clock"></i>
                                    <h3>Open Hours</h3>
                                    <p>Monday - Friday</p>
                                    <p>9:00AM - 05:00PM</p>
                                </div>
                            </div><!-- End Info Item -->

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Your Name" required="">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Your Email" required="">
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required="">
                                </div>

                                <div class="col-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">
                        <h4>Gabung Newsletter Aksess</h4>
                        <p>Dapatkan update terbaru tentang produk dan layanan kami langsung ke email Anda!</p>
                        <form action="forms/newsletter.php" method="post" class="php-email-form" novalidate>
                            <div class="newsletter-form d-flex">
                                <input type="email" name="email" placeholder="Masukkan email Anda" required
                                    aria-label="Alamat email">
                                <input type="submit" value="Berlangganan">
                            </div>
                            <div class="loading" style="display:none;">Loading...</div>
                            <div class="error-message" role="alert" style="display:none;"></div>
                            <div class="sent-message" style="display:none;">Permintaan berlangganan Anda telah
                                terkirim. Terima kasih!</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="d-flex align-items-center">
                        <span class="sitename">Aksess</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Pendidikan No. 10</p>
                        <p>Kabupaten Sumenep, 12345</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62 21 1234 5678</span></p>
                        <p><strong>Email:</strong> <span>info@aksess.com</span></p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">About Us</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Features</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Student Management</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Attendance System</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Scheduling</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Reporting</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Follow Us</h4>
                    <p>Stay connected with us on social media for the latest updates and news.</p>
                    <div class="social-links d-flex">
                        <a href="https://twitter.com/aksess" target="_blank" rel="noopener"><i
                                class="bi bi-twitter"></i></a>
                        <a href="https://facebook.com/aksess" target="_blank" rel="noopener"><i
                                class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/aksess" target="_blank" rel="noopener"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://linkedin.com/company/aksess" target="_blank" rel="noopener"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>


        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Aksess</strong> <span>All Rights Reserved</span>
            </p>
            <div class="credits">

                Designed by <a href="#">LaBaco</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset(' assets2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets2/vendor/php-email-form/validate.js') }} "></script>
    <script src="{{ asset('assets2/vendor/aos/aos.js') }} "></script>
    <script src="{{ asset('assets2/vendor/glightbox/js/glightbox.min.js') }} "></script>
    <script src="{{ asset('assets2/vendor/purecounter/purecounter_vanilla.js') }} "></script>
    <script src="{{ asset('assets2/vendor/imagesloaded/imagesloaded.pkgd.min.js') }} "></script>
    <script src="{{ asset('assets2/vendor/isotope-layout/isotope.pkgd.min.js') }} "></script>
    <script src="{{ asset('assets2/vendor/swiper/swiper-bundle.min.js') }} "></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets2/js/main.js') }} "></script>

</body>

</html>
