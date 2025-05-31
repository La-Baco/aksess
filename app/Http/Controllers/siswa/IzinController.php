<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    // Menampilkan daftar izin siswa
    public function index()
    {
        $izinList = Izin::where('user_id', Auth::id())->latest()->get();
        return view('siswa.izin', compact('izinList'));
    }

    // Menyimpan pengajuan izin dari modal
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);

        Izin::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'Menunggu', // default status
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    // Menghapus izin jika masih dalam status menunggu
    public function destroy($id)
    {
        $izin = Izin::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($izin->status === 'Menunggu') {
            $izin->delete();
            return redirect()->back()->with('success', 'Pengajuan izin dibatalkan.');
        }

        return redirect()->back()->with('error', 'Izin tidak bisa dibatalkan karena sudah diproses.');
    }
}
