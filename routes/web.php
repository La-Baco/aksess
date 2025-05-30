<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\KelasController;
use App\Http\Controllers\admin\MapelController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\admin\JadwalController;
use App\Http\Controllers\admin\HariLiburController;

use App\Http\Controllers\guru\GuruJadwalController;
use App\Http\Controllers\siswa\SiswaJadwalController;
use App\Http\Controllers\admin\AdminAbsensiController;

use App\Http\Controllers\guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\guru\ProfileController as GuruProfileController;
use App\Http\Controllers\guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\siswa\ProfileController as SiswaProfileController;
use App\Http\Controllers\siswa\DashboardController as SiswaDashboardController;

use App\Http\Controllers\kepsek\ProfileController as KepsekProfileController;
use App\Http\Controllers\kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\kepsek\UserController as KepsekUserController;
use App\Http\Controllers\kepsek\JadwalController as KepsekJadwalController;

// Route::get('/', function ()
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->middleware('guest')->name('home.index');

Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
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

    Route::delete('/admin/users/destroy/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

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
});

Route::group(['middleware' => 'auth:guru'], function () {
    Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');

    Route::get('/guru/profil', [GuruProfileController::class, 'show'])->name('guru.profil');
    Route::put('/guru/{id}/profil', [GuruProfileController::class, 'update'])->name('guru.profil.update');

    Route::get('/guru/absensi', [GuruAbsensiController::class, 'index'])->name('guru.absensi');
    Route::post('/guru/absensi', [GuruAbsensiController::class, 'store'])->name('guru.absensi.store');
    Route::post('/guru/absensi/riwayat', [GuruAbsensiController::class, 'riwayat'])->name('guru.absensi.riwayat');

    Route::get('/guru/jadwal', [GuruJadwalController::class, 'jadwalMengajarGuru'])->name('guru.jadwal');
});
Route::group(['middleware' => 'auth:siswa'], function () {
    Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

    Route::get('/siswa/profil', [SiswaProfileController::class, 'show'])->name('siswa.profil');
    Route::put('/siswa/profil', [SiswaProfileController::class, 'update'])->name('siswa.profil.update');

    Route::get('/siswa/absensi', [SiswaAbsensiController::class, 'index'])->name('siswa.absensi');
    Route::post('/siswa/absensi', [SiswaAbsensiController::class, 'store'])->name('siswa.absensi.store');
    Route::get('/siswa/absensi/riwayat', [SiswaAbsensiController::class, 'riwayat'])->name('siswa.absensi.riwayat');

    Route::get('/siswa/jadwal', [SiswaJadwalController::class, 'jadwalSiswa'])->name('siswa.jadwal');

});
Route::group(['middleware' => 'auth:kepsek'], function () {
    Route::get('/kepsek/dashboard', [KepsekDashboardController::class, 'index'])->name('kepsek.dashboard');

    Route::get('/kepsek/profil', [KepsekProfileController::class, 'show'])->name('kepsek.profil');
    Route::put('/kepsek/profil', [KepsekProfileController::class, 'update'])->name('kepsek.profil.update');
    Route::get('/kepsek/data-guru', [KepsekUserController::class, 'indexGuru'])->name('kepsek.show-guru');
    Route::get('/kepsek/data-siswa', [KepsekUserController::class, 'indexSiswa'])->name('kepsek.show-siswa');
    Route::get('/kepsek/Jadwal-Pelajaran', [KepsekJadwalController::class, 'showJadwal'])->name('kepsek.show-jadwal');
    Route::get('/kepsek/Mata-Pelajaran', [KepsekJadwalController::class, 'showMapel'])->name('kepsek.show-mapel');
});
