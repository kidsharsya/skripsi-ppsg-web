<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Debug informasi setelah login
        Log::info('Admin Login Success Debug', [
            'user_id' => Auth::guard('admin')->id(),
            'user_email' => Auth::guard('admin')->user()->email ?? 'No email',
            'user_role' => Auth::guard('admin')->user()->role ?? 'No role',
            'guard_name' => 'admin',
            'is_authenticated' => Auth::guard('admin')->check(),
            'session_id' => $request->session()->getId(),
            'intended_url' => session('url.intended'),
        ]);

        // Check if user has admin role
        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'admin') {
            Log::warning('Non-admin user tried to access admin panel', [
                'user_id' => $user->id ?? 'No user',
                'user_role' => $user->role ?? 'No role',
                'user_email' => $user->email ?? 'No email',
            ]);

            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Access denied. Admin role required.']);
        }

        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }
}