<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Ambil user berdasarkan username
        $user = Teacher::where('username', $credentials['username'])->first();

        // Cek apakah user ada dan password sesuai
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['loginError' => 'Username atau password salah!']);
        }

        // Login user menggunakan Auth
        Auth::login($user);

        return redirect()->route('absensi.index');
    }

    public function logout()
    {
        Auth::logout(); // Gunakan Auth::logout() untuk keluar

        return redirect()->route('login');
    }
}
