<?php

namespace App\Http\Controllers\kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;

class KepsekAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::query();

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan status absen jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Load relasi user (siswa/guru) pembuat absensi
        $absensis = $query->with('siswa', 'pembuat')->paginate(20);

        return view('kepsek.absensi.index', compact('absensis'));
    }

    public function show($id)
    {
        $absensi = Absensi::with('siswa', 'pembuat')->findOrFail($id);

        return view('kepsek.absensi.show', compact('absensi'));
    }
}
