<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Register hanya untuk Siswa. Admin tidak bisa register.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        $kelas = Kelas::where('is_active', true)->get();
        return view('auth.register', compact('kelas'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,nis',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $siswa = Siswa::where('nis', $request->nis)->where('is_active', true)->firstOrFail();

        if (User::where('siswa_id', $siswa->id)->exists()) {
            return back()->withErrors(['nis' => 'NIS ini sudah terdaftar memiliki akun.'])->withInput();
        }

        $user = User::create([
            'name' => $siswa->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'siswa_id' => $siswa->id,
            'kelas_id' => $siswa->kelas_id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di Absensi Siswa.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
