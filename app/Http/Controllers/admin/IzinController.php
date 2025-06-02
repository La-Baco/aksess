<?php

namespace App\Http\Controllers\admin;

use App\Models\Izin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function index()
    {
        $izins = Izin::with(['user', 'disetujuiOleh'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin.izin.index', compact('izins'));
    }

    /**
     * Menyetujui, menolak, atau membatalkan persetujuan sebuah izin.
     */
    public function izinUpdate(Request $request, $id)
    {
        // Validasi input, termasuk status "Menunggu"
        $request->validate([
            'status'         => 'required|in:Menunggu,Disetujui,Ditolak',
            'ditolak_alasan' => 'nullable|string',
        ]);

        $izin = Izin::findOrFail($id);

        // Jika membatalkan persetujuan (status Menunggu),
        // kosongkan kembali kolom penyetuju & alasan penolakan
        if ($request->status === 'Menunggu') {
            $izin->status          = 'Menunggu';
            $izin->disetujui_oleh  = null;
            $izin->ditolak_alasan  = null;
        }
        else {
            // Setujui atau Tolak
            $izin->status         = $request->status;
            $izin->disetujui_oleh = Auth::user()->id;

            if ($request->status === 'Ditolak') {
                $izin->ditolak_alasan = $request->ditolak_alasan;
            }
            else {
                // Jika Disetujui, pastikan alasan penolakan di‐reset
                $izin->ditolak_alasan = null;
            }
        }

        $izin->save();

        return redirect()->back()->with('success', 'Status izin berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Cari izin berdasarkan ID, kemudian hapus
        $izin = Izin::findOrFail($id);
        $izin->delete();

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dihapus.');
    }
}

