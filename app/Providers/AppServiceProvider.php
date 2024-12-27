<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

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
        //Carbon macro for the timezone. For example $user->updated_at->appTimezone();
        //and even $user->updated_at->appTimezone()->format('d/m/y H:m');
        Carbon::macro('appTimezone', function () {
            // @phpstan-ignore-next-line
            return $this->tz(config('app.app_timezone'));
        });
    }
}
