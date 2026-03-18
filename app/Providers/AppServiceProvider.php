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

    public function boot(): void
    {
        // HTTPS handled at proxy level or not needed for offline local IP dev
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
                \Illuminate\Support\Facades\View::share('global_settings', $settings);
            }
        } catch (\Exception $e) {
            // Table might not exist during migration
        }
    }
}
