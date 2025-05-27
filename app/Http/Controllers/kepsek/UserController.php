<?php

namespace App\Http\Controllers\kepsek;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    public function indexGuru()
    {
        $guru = User::where('role', 'guru')->get();
        return view('kepsek.show-guru', compact('guru'));
    }

    // Menampilkan data siswa
    public function indexSiswa()
    {
        $siswa = User::where('role', 'siswa')->get();
        return view('kepsek.show-siswa', compact('siswa'));
    }
}
