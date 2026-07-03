<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function tampilkanLogin()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        // Validasi format input
        $kredensial = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
        ]);

        // Proses verifikasi ke database dengan proteksi Session Fixation
        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate(); // Regenerasi session ID demi keamanan
            return redirect()->intended('/produk')->with('sukses', 'Selamat datang kembali, Anda berhasil login!');
        }

        // Jika verifikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Menghapus session data
        $request->session()->regenerateToken(); // Menyegarkan token CSRF

        return redirect('/login')->with('sukses', 'Anda telah berhasil logout.');
    }
}
