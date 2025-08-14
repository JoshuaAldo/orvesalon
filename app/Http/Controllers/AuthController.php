<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/admin/image'); // Ganti dengan route tujuan
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function showResetForm($token)
    {
        return view('auth.reset', ['token' => $token]);
    }

    // Memproses reset password
    public function reset(Request $request)
    {
        // Validasi input reset password
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Proses reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // Menangani hasil reset password
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password telah berhasil direset!')
            : back()->withErrors(['email' => 'Terjadi kesalahan. Gagal mereset password.']);
    }

    public function sendResetLink(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Kirim link reset password via email
        $status = Password::sendResetLink(
            $request->only('email')
        );
        Log::info('Status reset: ' . $status); // log status
        // Menampilkan status setelah pengiriman
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Terjadi kesalahan. Gagal mengirim email reset password.']);
    }
}
