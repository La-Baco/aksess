<?php

namespace App\Http\Controllers\guru;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $kelasWali = Kelas::whereHas('guruWali', function ($q) use ($user) {
            $q->where('guru_id', $user->id);
        })->first();

        $namaKelas = $kelasWali ? $kelasWali->nama_kelas : '-';

        return view('guru.profil', compact('user', 'kelasWali', 'namaKelas'));
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
    public function changePassword()
    {
        return view('guru.change-password',);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
