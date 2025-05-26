<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['guruWali', 'siswa'])->get();
        $gurus = User::where('role', 'guru')->get();

        return view('admin.kelas.index', compact('kelas', 'gurus'));
    }

    public function detailKelas($id)
    {
        $selectedKelas = Kelas::with(['guruWali', 'siswa'])->findOrFail($id);
        return view('admin.kelas.detail', compact('selectedKelas'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'guru_id' => 'required|exists:users,id'
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kapasitas' => $request->kapasitas,
        ]);

        // Menambahkan wali kelas ke pivot guru_kelas
        $kelas->guruWali()->attach($request->guru_id, ['tahun_ajaran' => now()->year]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'string|max:255',
            'kapasitas' => 'integer|min:1',
            'guru_id' => 'exists:users,id'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->only(['nama_kelas', 'kapasitas']));

        if ($request->guru_id) {
            $kelas->guruWali()->sync([$request->guru_id => ['tahun_ajaran' => now()->year]]);
        }

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->guruWali()->detach();
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
