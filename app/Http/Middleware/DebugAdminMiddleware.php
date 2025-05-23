<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DebugAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debug auth state untuk admin panel
        Log::info('Admin Panel Access Debug', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'admin_guard_check' => Auth::guard('admin')->check(),
            'admin_user' => Auth::guard('admin')->user() ? [
                'id' => Auth::guard('admin')->user()->id,
                'email' => Auth::guard('admin')->user()->email,
                'role' => Auth::guard('admin')->user()->role,
                'created_at' => Auth::guard('admin')->user()->created_at,
            ] : null,
            'web_guard_check' => Auth::guard('web')->check(),
            'web_user' => Auth::guard('web')->user() ? [
                'id' => Auth::guard('web')->user()->id,
                'email' => Auth::guard('web')->user()->email,
                'role' => Auth::guard('web')->user()->role,
            ] : null,
            'all_guards' => array_keys(config('auth.guards')),
            'session_id' => $request->session()->getId(),
            'session_data' => $request->session()->all(),
        ]);
        return $next($request);
    }
}
