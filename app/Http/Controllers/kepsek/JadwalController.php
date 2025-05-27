<?php

namespace App\Http\Controllers\kepsek;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    public function showJadwal()
    {
        $kelas = Kelas::with(['jadwal.mapel.guru'])->get();
        return view('kepsek.show-jadwal', compact('kelas'));
    }
    public function showMapel()
    {
        $mapels = Mapel::with('guru')->get();

        return view('kepsek.show-mapel', compact('mapels'));
    }
}
