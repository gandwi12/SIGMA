<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleLoginController extends Controller
{
    public function adminLoginPage()
    {
        return view('auth.admin-login');
    }

    public function mitraLoginPage()
    {
        return view('auth.mitra-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.');
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== 'admin_sigma') {
            Auth::logout();
            return back()->with('error', 'Akun ini bukan Admin SIGMA.');
        }

        return redirect()->route('admin.dashboard');
    }

    public function mitraLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.');
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== 'mitra') {
            Auth::logout();
            return back()->with('error', 'Akun ini bukan Admin UMKM.');
        }

        return redirect()->route('mitra.dashboard');
    }

    public function logout(Request $request)
    {
        $role = Auth::user()?->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'admin_sigma') {
            return redirect()->route('admin.login');
        }

        return redirect()->route('mitra.login');
    }
}