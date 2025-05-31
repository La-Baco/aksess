<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    // Tampilkan daftar izin yang diajukan oleh guru yang sedang login
    public function index()
    {
        $user = Auth::user();
        $izinList = Izin::where('user_id', $user->id)->latest()->get();

        return view('guru.izin', compact('izinList'));
    }


    // Simpan pengajuan izin
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
            'status' => 'Menunggu',
        ]);

        return redirect()->route('guru.izin')->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    // Opsional: Detail izin
    public function show($id)
    {
        $izin = Izin::where('user_id', Auth::id())->findOrFail($id);
        return view('guru.izin.show', compact('izin'));
    }

    // Opsional: Batalkan izin jika masih menunggu
    public function destroy($id)
    {
        $izin = Izin::where('user_id', Auth::id())
                    ->where('status', 'Menunggu')
                    ->findOrFail($id);

        $izin->delete();

        return redirect()->route('guru.izin')->with('success', 'Pengajuan izin dibatalkan.');
    }
}
