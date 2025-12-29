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
            ['key' => 'site_name', 'value' => 'Anntix'],
            ['key' => 'site_logo', 'value' => null],
            ['key' => 'site_icon', 'value' => null],

            // SEO
            ['key' => 'seo_title', 'value' => 'Anntix - Premium Event Ticketing'],
            ['key' => 'seo_description', 'value' => 'Secure your spot at the best events with Anntix. Fast, easy, and reliable ticketing platform.'],

            // Contact Info
            ['key' => 'contact_email', 'value' => 'support@anntix.com'],
            ['key' => 'contact_whatsapp', 'value' => '+6281234567890'],
            ['key' => 'contact_location', 'value' => 'Jakarta, Indonesia'],

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
