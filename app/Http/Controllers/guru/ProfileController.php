<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        $kelasDiampu = $user->kelas_id ? $user->kelas->nama_kelas : '-';

        return view('guru.profil', compact('user', 'kelasDiampu'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('public/foto');
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
