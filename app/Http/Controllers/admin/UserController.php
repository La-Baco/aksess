<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        $gurus = User::where('role', 'guru')->get();
        $siswas = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        return view('admin.users.index', compact('admins', 'gurus', 'siswas', 'kelas'));
    }
    public function showguru()
    {
        $admins = User::where('role', 'admin')->get();
        $gurus = User::where('role', 'guru')->get();
        $siswas = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        return view('admin.users.guru', compact('admins', 'gurus', 'siswas', 'kelas'));
    }
    public function showsiswa()
    {
        $admins = User::where('role', 'admin')->get();
        $gurus = User::where('role', 'guru')->get();
        $siswas = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        return view('admin.users.siswa', compact('admins', 'gurus', 'siswas', 'kelas'));
    }

    // app/Http/Controllers/Admin/UserController.php

    public function datauser()
    {
        $admins = User::where('role', 'admin')->get();
        $gurus = User::where('role', 'guru')->get();
        $siswas = User::where('role', 'siswa')->get();

        return view('admin.users.datauser', compact('admins', 'gurus', 'siswas'));
    }


    // Admin store
    public function adminStore(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ];

        $validated = $request->validate($rules);
        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'admin';

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    // Admin update
    public function adminUpdate(Request $request, User $user)
    {
        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ];

        $validated = $request->validate($rules);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil diperbarui.');
    }

    // Guru store
    public function guruStore(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nip' => 'nullable|string|unique:users,nip',
        ];

        $validated = $request->validate($rules);
        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'guru';

        User::create($validated);

        return redirect()->route('admin.users.guru')->with('success', 'Guru berhasil ditambahkan!');
    }

    // Guru update
    public function guruUpdate(Request $request, User $user)
    {
        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nip'           => 'nullable|string|unique:users,nip,' . $user->id,
        ];

        $validated = $request->validate($rules);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('admin.users.guru')->with('success', 'Guru berhasil diperbarui.');
    }

    // Siswa store
    public function siswaStore(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nis' => 'nullable|string|unique:users,nis',
            'kelas_id' => 'required|exists:kelas,id',
        ];

        $validated = $request->validate($rules);
        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'siswa';

        $user = User::create($validated);

        return redirect()->route('admin.users.siswa')->with('success', 'Siswa berhasil ditambahkan!');
    }

    // Siswa update
    public function siswaUpdate(Request $request, User $user)
    {
        $rules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nis'           => 'nullable|string|unique:users,nis,' . $user->id,
            'kelas_id'      => 'required|exists:kelas,id',
        ];

        $validated = $request->validate($rules);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.siswa')->with('success', 'Siswa berhasil diperbarui.');
    }

    // Destroy user
    public function destroy(User $user)
    {
        if ($user->role === 'siswa') {
            $user->kelas()->detach();
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User dihapus.');
    }
}
