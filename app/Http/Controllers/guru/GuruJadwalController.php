<?php

namespace App\Http\Controllers\guru;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GuruJadwalController extends Controller
{
    public function jadwalMengajarGuru()
    {
        $guruId = Auth::user()->id;

        $jadwals = Jadwal::with(['mapel', 'kelas'])
            ->whereHas('mapel', function($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->orderBy('hari')
            ->orderBy('waktu_mulai')
            ->get();

        return view('guru.jadwal', compact('jadwals'));
    }

}
