<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Identity
            ['key' => 'site_name', 'value' => 'ANTIX'],
            ['key' => 'site_logo', 'value' => 'logo.png'],
            ['key' => 'site_logo_white', 'value' => 'logo-white.png'],
            ['key' => 'site_icon', 'value' => 'icon.png'],

            // SEO
            ['key' => 'seo_title', 'value' => 'ANTIX'],
            ['key' => 'seo_description', 'value' => 'Secure your spot at the best events with ANTIX. Fast, easy, and reliable ticketing platform.'],

            // Social Media
            ['key' => 'social_facebook', 'value' => '#'],
            ['key' => 'social_twitter', 'value' => '#'],
            ['key' => 'social_instagram', 'value' => '#'],
            ['key' => 'social_tiktok', 'value' => '#'],

            // Contact Info
            ['key' => 'contact_email', 'value' => 'hallo@anntix.com'],
            ['key' => 'contact_whatsapp', 'value' => '087750581589'],
            ['key' => 'contact_location', 'value' => 'Tegal, Jawa Tengah'],

            // Payment Configuration
            ['key' => 'fee_qris_percent', 'value' => '0.7'],
            ['key' => 'fee_bank_fixed', 'value' => '4000'],
            ['key' => 'handling_fee', 'value' => '5000'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
