<?php

namespace App\Http\Controllers\siswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaJadwalController extends Controller
{
    public function jadwalSiswa()
    {
        $user = Auth::user();

        if (!$user->kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan untuk siswa ini.');
        }

        $jadwals = $user->kelas->jadwal()
            ->with(['mapel.guru'])
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('waktu_mulai')    
            ->get();

        return view('siswa.jadwal', compact('jadwals'));
    }
}
