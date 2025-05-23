<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Http\Responses\CustomLoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginResponseContract::class, CustomLoginResponse::class);
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

    //     if (app()->environment('local')) {
    //     \Illuminate\Support\Facades\URL::forceScheme('https');
    // }
    }
}
