<?php

namespace App\Providers;

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
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
        config(['app.timezone' => 'America/Lima']);
        date_default_timezone_set('America/Lima');
    }
}
