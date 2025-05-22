<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'auth.user' => function () {
                return Auth::user() ? [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                ] : null;
            },
        ]);

        if (app()->environment('local')) {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }
    }
}
