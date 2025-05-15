<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tambahkan kondisi untuk role user
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            
            // Pastikan hanya user yang bisa login melalui form login frontend
            if ($user->role !== 'user') {
                Auth::guard('web')->logout();
                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses sebagai user.',
                ]);
            }
            
            $request->session()->regenerate();
            $token = $user->createToken('auth-token')->plainTextToken;
            
            return redirect()->route('home')->withCookie(cookie('auth_token', $token, 60 * 24)) // expire dalam 1 hari
                            ->withCookie(cookie('user_id', $user->id, 60 * 24));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);

        
    }

    public function logout(Request $request)
    {
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->withoutCookie('auth_token')->withoutCookie('user_id');
    }
}
