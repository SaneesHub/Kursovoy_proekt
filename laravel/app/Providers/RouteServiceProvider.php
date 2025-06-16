<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard'; // или '/' если пока нет личного кабинета

    public static function redirectToByRole($user)
    {
        return match($user->role) {
            3 => '/admin/dashboard',
            2 => '/operator/dashboard',
            1 => '/client/dashboard',
            default => '/',
        };
    }


    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
