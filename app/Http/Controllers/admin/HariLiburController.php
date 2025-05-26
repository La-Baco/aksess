<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HariLibur;

class HariLiburController extends Controller
{
    // Tampilkan semua hari libur
    public function index()
    {
        $hariLiburs = HariLibur::orderBy('tanggal', 'asc')->get();
        return view('admin.hari_libur.index', compact('hariLiburs'));
    }

    // Simpan hari libur baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'keterangan' => 'nullable|string|max:255',
        ]);

        HariLibur::create([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.hari-libur.index')
                         ->with('success', 'Hari libur berhasil ditambahkan.');
    }

    // Update hari libur
    public function update(Request $request, $id)
    {
        $hariLibur = HariLibur::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date|unique:hari_liburs,tanggal,' . $hariLibur->id,
            'keterangan' => 'nullable|string|max:255',
        ]);

        $hariLibur->update([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.hari-libur.index')
                         ->with('success', 'Hari libur berhasil diperbarui.');
    }

    // Hapus hari libur
    public function destroy($id)
    {
        $hariLibur = HariLibur::findOrFail($id);
        $hariLibur->delete();

        return redirect()->route('admin.hari-libur.index')
                         ->with('success', 'Hari libur berhasil dihapus.');
    }
}
