<?php

namespace App\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        FilamentAsset::register([
            Css::make('theme', __DIR__ . '/../../resources/css/theme.css'),
            Css::make('scrollbar', __DIR__ . '/../../resources/css/scrollbar.css'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('APP_HTTPS')) {
            URL::forceScheme('https');
        }
    }
}
