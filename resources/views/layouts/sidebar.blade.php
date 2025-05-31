@php
    $user = Auth::user();
@endphp

{{-- Menu untuk Admin --}}
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo/aksess-logo.png') }}" alt="Logo"
                        style="width: 130px; height: auto;">
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        @if ($user->role === 'admin')
            <div class="sidebar-menu">
                <ul class="menu">

                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ Request::is('admin/dashboard') ? 'active' : '' }} ">
                        <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                            <i class=" bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-title">User</li>
                    <li class="sidebar-item  has-sub {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-person-lines-fill"></i>
                            <span>User Management</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item  ">
                                <a href="{{ route('admin.users.index') }}">Admin</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('admin.users.guru') }}">Guru</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('admin.users.siswa') }}">Siswa</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item {{ Request::is('users/data') ? 'active' : '' }} ">
                        <a href="{{ route('admin.users.datauser') }}" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Data User</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Akademik</li>

                    <li class="sidebar-item  {{ Request::is('admin/kelas') ? 'active' : '' }} ">
                        <a href="{{ route('admin.kelas.index') }}" class='sidebar-link'>
                            <i class="bi bi-bookmarks-fill"></i>
                            <span>Kelas</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('admin/mapel') ? 'active' : '' }} ">
                        <a href="{{ route('admin.mapel.index') }}" class='sidebar-link'>
                            <i class="bi bi-book-half"></i>
                            <span>Mata Pelajaran</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('admin/jadwal') ? 'active' : '' }} ">
                        <a href="{{ route('admin.jadwal.index') }}" class='sidebar-link'>
                            <i class="bi bi-calendar2-week-fill"></i>
                            <span>Jadwal</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('admin/hari-libur') ? 'active' : '' }} ">
                        <a href="{{ route('admin.hari-libur.index') }}" class='sidebar-link'>
                            <i class="bi bi-calendar2-plus-fill"></i>
                            <span>Hari Libur</span>
                        </a>
                    </li>
                    <li class="sidebar-title">Rekap</li>
                    <li class="sidebar-item  {{ Request::is('admin/rekap/guru') ? 'active' : '' }}">
                        <a href="{{ route('admin.absensi.rekap-guru')}}" class='sidebar-link'>
                            <i class="bi bi-table"></i>
                            <span>Rekap Kehadiran Guru</span>
                        </a>
                    </li>

                    <li class="sidebar-item  {{ Request::is('admin/rekap/siswa') ? 'active' : '' }}">
                        <a href="{{ route('admin.absensi.rekap-siswa')}}" class='sidebar-link'>
                            <i class="bi bi-table"></i>
                            <span>Rekap Kehadiran Siswa</span>
                        </a>
                    </li>


                    <li class="sidebar-title">Setting</li>
                    <li class="sidebar-item {{ Request::is('admin/absensi/setting') ? 'active' : '' }} ">
                        <a href="{{ route('admin.absensi.setting') }}" class='sidebar-link'>
                            <i class="bi bi-gear-fill"></i>
                            <span>Set Absensi</span>
                        </a>
                    </li>


                </ul>
            </div>
        @endif
        @if ($user->role === 'guru')
            <div class="sidebar-menu">
                <ul class="menu">

                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ Request::is('guru/dashboard') ? 'active' : '' }} ">
                        <a href="{{ route('guru.dashboard') }}" class='sidebar-link'>
                            <i class=" bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    <li class="sidebar-item {{ Request::is('guru/absensi') ? 'active' : '' }} ">
                        <a href="{{ route('guru.absensi') }}" class='sidebar-link'>
                            <i class="bi bi-geo-fill"></i>
                            <span>Absen</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('guru/izin') ? 'active' : '' }} ">
                        <a href="{{ route('guru.izin') }}" class='sidebar-link'>
                            <i class="bi bi-envelope-fill"></i>
                            <span>Pengajuan Izin</span>
                        </a>
                    </li>

                    <li class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span>Extra Components</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item ">
                                <a href="extra-component-avatar.html">Avatar</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="extra-component-sweetalert.html">Sweet Alert</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="extra-component-toastify.html">Toastify</a>
                            </li>

                    </li>
                </ul>





                <li class="sidebar-title">Kehadiran &amp; Izin</li>

                <li class="sidebar-item {{ Request::is('siswa/rekap-kehadiran') ? 'active' : '' }} ">
                    <a href="{{ route('siswa.absensi') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Rekap Kehadiran</span>
                    </a>
                </li>



                <li class="sidebar-title">Sekolah</li>

                <li class="sidebar-item {{ Request::is('guru/jadwal') ? 'active' : '' }}">
                    <a href="{{ route('guru.jadwal') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Jadwal Mengajar</span>
                    </a>
                </li>

                <li class="sidebar-item  ">
                    <a href="table.html" class='sidebar-link'>
                        <i class="bi bi-megaphone-fill"></i>
                        <span>Pengumuman</span>
                    </a>
                </li>


                <li class="sidebar-title">Pengaturan Akun</li>

                <li class="sidebar-item {{ Request::is('guru/profil') ? 'active' : '' }} ">
                    <a href="{{ route('guru.profil') }}" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

                </ul>
            </div>
        @endif
        @if ($user->role === 'siswa')
            <div class="sidebar-menu">
                <ul class="menu">

                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ Request::is('siswa/dashboard') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.dashboard') }}" class='sidebar-link'>
                            <i class=" bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('siswa/absensi') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.absensi') }}" class='sidebar-link'>
                            <i class="bi bi-geo-fill"></i>
                            <span>Absensi</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('siswa/izin') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.izin') }}" class='sidebar-link'>
                            <i class="bi bi-envelope-fill"></i>
                            <span>Pengajuan Izin</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Kehadiran &amp; Izin</li>

                    <li class="sidebar-item {{ Request::is('siswa/rekap-kehadiran') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.absensi') }}" class='sidebar-link'>
                            <i class="bi bi-calendar-check-fill"></i>
                            <span>Rekap Kehadiran</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('siswa/rekap-izin') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.absensi') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <span>Rekap Izin</span>
                        </a>
                    </li>


                    <li class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-grid-1x2-fill"></i>
                            <span>Layouts</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item ">
                                <a href="layout-default.html">Default Layout</a>
                            </li>
                            <li class="submenu-item ">
                                <a href="layout-vertical-1-column.html">1 Column</a>
                            </li>
                        </ul>
                    </li>



                    <li class="sidebar-title">Sekolah</li>

                    <li class="sidebar-item {{ Request::is('siswa/jadwal') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.jadwal') }}" class='sidebar-link'>
                            <i class="bi bi-calendar-event-fill"></i>
                            <span>Jadwal Pelajaran</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="table.html" class='sidebar-link'>
                            <i class="bi bi-megaphone-fill"></i>
                            <span>Pengumuman</span>
                        </a>
                    </li>


                    <li class="sidebar-title">Pengaturan Akun</li>

                    <li class="sidebar-item {{ Request::is('siswa/profil') ? 'active' : '' }} ">
                        <a href="{{ route('siswa.profil') }}" class='sidebar-link'>
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>




                </ul>
            </div>
        @endif
        @if ($user->role === 'kepsek')
            <div class="sidebar-menu">
                <ul class="menu">

                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ Request::is('kepsek/dashboard') ? 'active' : '' }} ">
                        <a href="{{ route('kepsek.dashboard') }}" class='sidebar-link'>
                            <i class=" bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                <li class="sidebar-title">Data Guru & Siswa</li>

                <li class="sidebar-item  {{ Request::is('kepsek/data-guru') ? 'active' : '' }}">
                    <a href="{{ route('kepsek.show-guru') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Daftar Guru</span>
                    </a>
                </li>

                <li class="sidebar-item  {{ Request::is('kepsek/data-siswa') ? 'active' : '' }}">
                    <a href="{{ route('kepsek.show-siswa') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Daftar Siswa</span>
                    </a>
                </li>
                <li class="sidebar-title">Sekolah</li>

                <li class="sidebar-item  {{ Request::is('kepsek/Jadwal-Pelajaran') ? 'active' : '' }}">
                    <a href="{{ route('kepsek.show-jadwal') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Jadwal Peajaran</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('kepsek/Mata-Pelajaran') ? 'active' : '' }} ">
                    <a href="{{ route('kepsek.show-mapel') }}" class='sidebar-link'>
                        <i class="bi bi-book-half"></i>
                        <span>Mata Pelajaran</span>
                    </a>
                </li>

                <li class="sidebar-title">Rekap</li>
                <li class="sidebar-item  {{ Request::is('kepsek/rekap/guru') ? 'active' : '' }}">
                    <a href="{{ route('kepsek.rekap-guru')}}" class='sidebar-link'>
                        <i class="bi bi-table"></i>
                        <span>Rekap Kehadiran Guru</span>
                    </a>
                </li>

                <li class="sidebar-item  {{ Request::is('kepsek/rekap/siswa') ? 'active' : '' }}">
                    <a href="{{ route('kepsek.rekap-siswa')}}" class='sidebar-link'>
                        <i class="bi bi-table"></i>
                        <span>Rekap Kehadiran Siswa</span>
                    </a>
                </li>



                <li class="sidebar-title">Pengaturan Akun</li>

                <li class="sidebar-item {{ Request::is('kepsek/profil') ? 'active' : '' }} ">
                    <a href="{{ route('kepsek.profil') }}" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

            </div>
        @endif


        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
