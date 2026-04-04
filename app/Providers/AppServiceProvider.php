<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Mail;
use App\Mail\FailedJobAlert;

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

        // Send email alert when a queue job fails (VPS only — skip in local env)
        if (app()->environment('production')) {
            Queue::failing(function (JobFailed $event) {
                try {
                    Mail::to(config('mail.alert_to'))->send(new FailedJobAlert($event));
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send job failure alert: ' . $e->getMessage());
                }
            });
        }
    }
}
