@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endsection

@section('content')
    @if (!$setting)
        <div class="card shadow border-danger mx-auto" style="max-width: 400px; margin-top: 30px; border-width: 2px;">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-circle text-danger" style="font-size: 5rem;"></i>
                <h5 class="card-title mt-3 text-danger fw-bold">Pengaturan Absensi Belum Tersedia</h5>
                <p class="card-text text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Absensi Hari Ini</h4>
                        <small class="text-muted" id="current-time">--:--:--</small>
                    </div>
                    <div class="card-body">

                        {{-- Info Guru --}}
                        <div class="mb-3">
                            <h5>Nama: <strong>{{ auth()->user()->name }}</strong></h5>
                            <p class="mb-0">Tanggal: <strong>{{ \Carbon\Carbon::now()->format('d M Y') }}</strong></p>
                        </div>

                        {{-- Peta Lokasi --}}
                        <div id="map" style="height: 300px;" class="mb-3 rounded shadow-sm"></div>
                        <p>Status Lokasi:
                            <span id="location-status" class="fw-bold text-primary">Mendeteksi lokasi...</span>
                        </p>

                        {{-- Notifikasi --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- Logika Absensi --}}
                        @if ($isMinggu)
                            <div class="alert alert-warning">Hari ini adalah Minggu, absensi tidak tersedia.</div>
                        @elseif($isHariLibur)
                            <div class="alert alert-warning">Hari ini adalah hari libur, absensi tidak tersedia.</div>
                        @else
                            @if ($absenHariIni)
                                <div class="alert alert-info">
                                    Kamu sudah melakukan absensi hari ini.<br>
                                    <strong>Status:</strong> {{ $absenHariIni->status }} <br>
                                    <strong>Waktu:</strong> {{ \Carbon\Carbon::parse($absenHariIni->waktu)->format('H:i') }}
                                </div>
                            @else
                                <form action="{{ route('siswa.absensi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="long" id="long">

                                    <button type="submit" class="btn btn-success w-100 mt-2">
                                        <i class="bi bi-check-circle"></i> Absen Hadir Sekarang
                                    </button>
                                </form>
                            @endif
                        @endif

                        {{-- Riwayat --}}
                        <div class="mt-4 text-center">
                            <a href="{{ route('siswa.absensi.riwayat') }}" class="btn btn-outline-primary">
                                <i class="bi bi-clock-history"></i> Lihat Riwayat Absensi
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
    @if ($setting)
        <script>
            // Jam real-time
            function updateTime() {
                const now = new Date();
                document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID');
            }
            setInterval(updateTime, 1000);
            updateTime();
        </script>

        <script>
            const sekolahLat = {{ $setting->lokasi_lat }};
            const sekolahLong = {{ $setting->lokasi_long }};
            const batasRadius = {{ $setting->radius_meter }};

            let map, markerUser, markerSekolah, circle;

            function showMap(userLat, userLong) {
                map = L.map('map').setView([userLat, userLong], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                markerUser = L.marker([userLat, userLong]).addTo(map)
                    .bindPopup('Lokasi Kamu').openPopup();

                markerSekolah = L.marker([sekolahLat, sekolahLong], {
                    icon: L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/1048/1048927.png',
                        iconSize: [30, 30]
                    })
                }).addTo(map).bindPopup('Lokasi Sekolah');

                circle = L.circle([sekolahLat, sekolahLong], {
                    radius: batasRadius,
                    color: 'blue',
                    fillColor: '#cce5ff',
                    fillOpacity: 0.3
                }).addTo(map);
            }

            function getDistance(lat1, lon1, lat2, lon2) {
                const R = 6371000;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLong = position.coords.longitude;

                    document.getElementById('lat').value = userLat;
                    document.getElementById('long').value = userLong;

                    showMap(userLat, userLong);

                    const distance = getDistance(userLat, userLong, sekolahLat, sekolahLong);
                    const statusEl = document.getElementById('location-status');
                    if (distance <= batasRadius) {
                        statusEl.textContent = "Di area sekolah";
                        statusEl.classList.remove('text-danger');
                        statusEl.classList.add('text-success');
                    } else {
                        statusEl.textContent = "Di luar area sekolah";
                        statusEl.classList.remove('text-success');
                        statusEl.classList.add('text-danger');
                    }
                }, function(error) {
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.');
                });
            } else {
                alert('Browser tidak mendukung geolokasi.');
            }
        </script>
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    @endif
@endsection
