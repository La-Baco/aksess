<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserAuthVerifyRequest;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function verify(UserAuthVerifyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = \App\Models\User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            switch ($user->role) {
                case 'admin':
                    Auth::guard('admin')->login($user);
                    return redirect()->intended('/admin/dashboard');
                case 'guru':
                    Auth::guard('guru')->login($user);
                    return redirect()->intended('/guru/dashboard');
                case 'siswa':
                    Auth::guard('siswa')->login($user);
                    return redirect()->intended('/siswa/dashboard');
                case 'kepsek':
                    Auth::guard('kepsek')->login($user);
                    return redirect()->intended('/kepsek/dashboard');
            }
        }

        return redirect(route('login'))->with('msg', 'Email atau password salah');
    }


    public function logout(): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
        } else if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        } else if (Auth::guard('kepsek')->check()) {
            Auth::guard('kepsek')->logout();
        } 
        return redirect(route('login'));
    }
}
