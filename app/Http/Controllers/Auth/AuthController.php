<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|in:admin_sigma,mitra',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ])) {
            return back()->with('error', 'Email atau password salah.');
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== $data['role']) {
            Auth::logout();

            return back()->with('error', 'Role akun tidak sesuai.');
        }

        if ($data['role'] === 'admin_sigma') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('mitra.dashboard');
    }

    public function registerPage()
    {
        $umkms = Umkm::where('status', 'Aktif')
            ->whereDoesntHave('user')
            ->latest()
            ->get();

        return view('auth.register', compact('umkms'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'umkm_id' => 'required|exists:umkms,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $umkm = Umkm::where('id', $data['umkm_id'])
            ->where('status', 'Aktif')
            ->first();

        if (!$umkm) {
            return back()->with('error', 'UMKM belum aktif atau belum di-approve Admin SIGMA.');
        }

        $alreadyLinked = User::where('role', 'mitra')
            ->where('umkm_id', $umkm->id)
            ->exists();

        if ($alreadyLinked) {
            return back()->with('error', 'UMKM ini sudah punya akun mitra.');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'mitra',
            'umkm_id' => $umkm->id,
        ]);

        Auth::login($user);

        return redirect()->route('mitra.dashboard')
            ->with('success', 'Akun mitra berhasil dibuat.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}