<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\admin\IzinController as AdminIzinController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\KelasController;
use App\Http\Controllers\admin\MapelController;
use App\Http\Controllers\admin\JadwalController;
use App\Http\Controllers\kepsek\RekapController;
use App\Http\Controllers\admin\HariLiburController;

use App\Http\Controllers\guru\GuruJadwalController;
use App\Http\Controllers\siswa\SiswaJadwalController;
use App\Http\Controllers\admin\AdminAbsensiController;
use App\Http\Controllers\guru\IzinController as GuruIzinController;
use App\Http\Controllers\siswa\IzinController as SiswaIzinController;
use App\Http\Controllers\kepsek\IzinController as KepsekIzinController;

use App\Http\Controllers\kepsek\UserController as KepsekUserController;
use App\Http\Controllers\guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\guru\ProfileController as GuruProfileController;
use App\Http\Controllers\kepsek\JadwalController as KepsekJadwalController;
use App\Http\Controllers\siswa\AbsensiController as SiswaAbsensiController;

use App\Http\Controllers\siswa\ProfileController as SiswaProfileController;
use App\Http\Controllers\guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\kepsek\ProfileController as KepsekProfileController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\kepsek\DashboardController as KepsekDashboardController;



// Route::get('/', function ()
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])
    ->middleware('guest')
    ->name('home.index');

Route::get('/login', [AuthController::class, 'index'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:admin'], function () {
    // Dashboard route
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Users management
    Route::get('/admin/users/admin', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/guru', [UserController::class, 'showguru'])->name('admin.users.guru');
    Route::get('/admin/users/siswa', [UserController::class, 'showsiswa'])->name('admin.users.siswa');
    Route::get('/users/data', [UserController::class, 'datauser'])->name('admin.users.datauser');
    // Admin CRUD
    Route::post('/admin/users/store', [UserController::class, 'adminStore'])->name('admin.store');
    Route::put('/admin/users/update/{user}', [UserController::class, 'adminUpdate'])->name('admin.update');
    // Guru CRUD
    Route::post('/admin/users/store-guru', [UserController::class, 'guruStore'])->name('admin.store-guru');
    Route::put('/admin/users/update-guru/{user}', [UserController::class, 'guruUpdate'])->name('admin.update-guru');
    // Siswa CRUD
    Route::post('/admin/users/store-siswa', [UserController::class, 'siswaStore'])->name('admin.store-siswa');
    Route::put('/admin/users/update-siswa/{user}', [UserController::class, 'siswaUpdate'])->name('admin.update-siswa');

    Route::delete('/admin/users/destroy/{user}', [UserController::class, 'destroyAdmin'])->name('admin.users.destroy');
    Route::delete('/admin/guru/destroy/{user}', [UserController::class, 'destroyGuru'])->name('admin.guru.destroy');
    Route::delete('/admin/siswa/destroy/{user}', [UserController::class, 'destroySiswa'])->name('admin.siswa.destroy');

    Route::get('/admin/kelas', [KelasController::class, 'index'])->name('admin.kelas.index');
    Route::post('/admin/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
    Route::get('/admin/kelas/detail/{id}', [KelasController::class, 'detailKelas'])->name('admin.kelas.detail');

    Route::get('/admin/mapel', [MapelController::class, 'index'])->name('admin.mapel.index');
    Route::post('/admin/mapel', [MapelController::class, 'store'])->name('admin.mapel.store');
    Route::put('/admin/mapel/{mapel}', [MapelController::class, 'update'])->name('admin.mapel.update');
    Route::delete('/admin/mapel/{mapel}', [MapelController::class, 'destroy'])->name('admin.mapel.destroy');

    Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal.index');
    Route::post('/admin/jadwal', [JadwalController::class, 'store'])->name('admin.jadwal.store');
    Route::put('/admin/jadwal/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/admin/jadwal/{id}', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy');
    Route::get('/admin/jadwal/{kelas_id}', [JadwalController::class, 'show'])->name('admin.jadwal.show');

    Route::get('/admin/hari-libur', [HariLiburController::class, 'index'])->name('admin.hari-libur.index');
    Route::post('/admin/hari-libur', [HariLiburController::class, 'store'])->name('admin.hari-libur.store');
    Route::put('/admin/hari-libur/{id}', [HariLiburController::class, 'update'])->name('admin.hari-libur.update');
    Route::delete('/admin/hari-libur/{id}', [HariLiburController::class, 'destroy'])->name('admin.hari-libur.destroy');

    Route::get('/admin/absensi/setting', [AdminAbsensiController::class, 'settingForm'])->name('admin.absensi.setting');
    Route::post('/admin/absensi/setting/store', [AdminAbsensiController::class, 'settingStore'])->name('admin.absensi.setting.store');
    Route::delete('admin/absensi/setting/reset', [AdminAbsensiController::class, 'settingReset'])->name('admin.absensi.setting.reset');

    Route::get('/admin/rekap/siswa', [AdminAbsensiController::class, 'rekapSiswa'])->name('admin.absensi.rekap-siswa');
    Route::get('/admin/rekap/guru', [AdminAbsensiController::class, 'rekapGuru'])->name('admin.absensi.rekap-guru');
    Route::post('/admin/absensi/update-status', [AdminAbsensiController::class, 'updateStatus'])->name('absensi.update-status');

    Route::get('/admin/izin', [AdminIzinController::class, 'index'])->name('admin.izin.index');
    Route::post('/admin/izin/update/{id}', [AdminIzinController::class, 'izinUpdate'])->name('admin.izin.update');
    Route::delete('/admin/izin/delete/{id}', [AdminIzinController::class, 'destroy'])->name('admin.izin.destroy');

});

Route::group(['middleware' => 'auth:guru'], function () {
    Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');

    Route::get('/guru/profil', [GuruProfileController::class, 'show'])->name('guru.profil');
    Route::put('/guru/{id}/profil', [GuruProfileController::class, 'update'])->name('guru.profil.update');

    Route::get('/guru/absensi', [GuruAbsensiController::class, 'index'])->name('guru.absensi');
    Route::post('/guru/absensi', [GuruAbsensiController::class, 'store'])->name('guru.absensi.store');
    Route::get('/guru/rekap-kehadiran', [GuruAbsensiController::class, 'rekapKehadiran'])->name('guru.rekap-kehadiran');

    Route::get('/guru/jadwal', [GuruJadwalController::class, 'jadwalMengajarGuru'])->name('guru.jadwal');

    Route::get('/guru/izin', [GuruIzinController::class, 'index'])->name('guru.izin');
    Route::post('/guru/izin', [GuruIzinController::class, 'store'])->name('guru.izin.store');
    Route::delete('/guru/izin/{id}', [GuruIzinController::class, 'destroy'])->name('guru.izin.destroy');

    Route::get('/guru/izin/approve/{id}', [GuruDashboardController::class, 'approve'])->name('guru.izin.approve');
    Route::get('/guru/izin/reject/{id}', [GuruDashboardController::class, 'reject'])->name('guru.izin.reject');
    Route::get('/guru/change-password', [GuruProfileController::class, 'changePassword'])->name('guru.change-password');
    Route::put('/guru/update-password', [GuruProfileController::class, 'updatePassword'])->name('guru.update-password');
});
Route::group(['middleware' => 'auth:siswa'], function () {
    Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

    Route::get('/siswa/profil', [SiswaProfileController::class, 'show'])->name('siswa.profil');
    Route::put('/siswa/profil', [SiswaProfileController::class, 'update'])->name('siswa.profil.update');

    Route::get('/siswa/absensi', [SiswaAbsensiController::class, 'index'])->name('siswa.absensi');
    Route::post('/siswa/absensi', [SiswaAbsensiController::class, 'store'])->name('siswa.absensi.store');
    Route::get('/siswa/rekap-kehadiran', [SiswaAbsensiController::class, 'rekapKehadiran'])->name('siswa.rekap-kehadiran');

    Route::get('/siswa/jadwal', [SiswaJadwalController::class, 'jadwalSiswa'])->name('siswa.jadwal');

    Route::get('/siswa/izin', [SiswaIzinController::class, 'index'])->name('siswa.izin');
    Route::post('/siswa/izin', [SiswaIzinController::class, 'store'])->name('siswa.izin.store');
    Route::delete('/siswa/izin/{id}', [SiswaIzinController::class, 'destroy'])->name('siswa.izin.destroy');
    Route::get('/siswa/change-password', [SiswaProfileController::class, 'changePassword'])->name('siswa.change-password');
    Route::put('/siswa/update-password', [SiswaProfileController::class, 'updatePassword'])->name('siswa.update-password');
});
Route::group(['middleware' => 'auth:kepsek'], function () {
    Route::get('/kepsek/dashboard', [KepsekDashboardController::class, 'index'])->name('kepsek.dashboard');

    Route::get('/kepsek/profil', [KepsekProfileController::class, 'show'])->name('kepsek.profil');
    Route::put('/kepsek/profil', [KepsekProfileController::class, 'update'])->name('kepsek.profil.update');
    Route::get('/kepsek/data-guru', [KepsekUserController::class, 'indexGuru'])->name('kepsek.show-guru');
    Route::get('/kepsek/data-siswa', [KepsekUserController::class, 'indexSiswa'])->name('kepsek.show-siswa');
    Route::get('/kepsek/Jadwal-Pelajaran', [KepsekJadwalController::class, 'showJadwal'])->name('kepsek.show-jadwal');
    Route::get('/kepsek/Mata-Pelajaran', [KepsekJadwalController::class, 'showMapel'])->name('kepsek.show-mapel');

    Route::get('/kepsek/izin/approve/{id}', [KepsekIzinController::class, 'approve'])->name('kepsek.izin.approve');
    Route::get('/kepsek/izin/reject/{id}', [KepsekIzinController::class, 'reject'])->name('kepsek.izin.reject');

    Route::get('/kepsek/rekap/siswa', [RekapController::class, 'rekapSiswa'])->name('kepsek.rekap-siswa');
    Route::get('/kepsek/rekap/guru', [RekapController::class, 'rekapGuru'])->name('kepsek.rekap-guru');
    Route::post('/kepsek/update-status', [RekapController::class, 'updateStatus'])->name('kepsek.update-status');

    Route::get('/kepsek/change-password', [KepsekProfileController::class, 'changePassword'])->name('kepsek.change-password');
    Route::put('/kepsek/update-password', [KepsekProfileController::class, 'updatePassword'])->name('kepsek.update-password');
});
