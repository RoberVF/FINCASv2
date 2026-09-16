<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

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
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn(): string => Blade::render('
            <link rel="manifest" href="/manifest.json">
            <script>
                if ("serviceWorker" in navigator) {
                    navigator.serviceWorker.register("/sw.js");
                }
            </script>
        ')
        );
    }
}
