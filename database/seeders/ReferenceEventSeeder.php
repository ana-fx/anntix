<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReferenceEventSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure sample directory exists in storage
        if (!file_exists(storage_path('app/public/sample'))) {
            mkdir(storage_path('app/public/sample'), 0775, true);
        }

        // Copy files from public/sample to storage/app/public/sample if they exist
        $files = [
            '1080 x 1080.png',
            '1920 x  1080.png',
            '3240 x 1080.png'
        ];

        foreach ($files as $file) {
            $source = public_path('sample/' . $file);
            $destination = storage_path('app/public/sample/' . $file);
            if (file_exists($source) && !file_exists($destination)) {
                copy($source, $destination);
            }
        }

        // 1. Create Reference Event
        $event = Event::updateOrCreate(
            ['slug' => 'reference-design-festival'],
            [
                'name' => 'Reference Design Festival',
                'description' => '<p>This is a dummy event created to demonstrate the optimal image dimensions for the Anntix platform.</p><ul><li><strong>Thumbnail:</strong> 1080x1080 (Square)</li><li><strong>Card Banner:</strong> 1920x1080 (16:9)</li></ul>',
                'location' => 'Digital Space',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(32),
                'status' => 'active',
                'organizer_name' => 'Anntix Design Team',
                'thumbnail_path' => 'sample/1080 x 1080.png',
                'banner_path' => 'sample/1920 x  1080.png',
                'category' => 'Reference',
                'reseller_fee_type' => 'fixed',
                'reseller_fee_value' => 5000,
                'organizer_fee' => 2000,
            ]
        );

        // 2. Create Ticket
        $event->tickets()->updateOrCreate(
            ['name' => 'Standard Access'],
            [
                'description' => 'General entry ticket.',
                'price' => 150000,
                'quota' => 100,
                'max_purchase_per_user' => 5,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
            ]
        );

        // 3. Create Hero Banner
        Banner::updateOrCreate(
            ['slug' => 'reference-hero-banner'],
            [
                'title' => 'Reference Hero Banner',
                'image_path' => 'sample/3240 x 1080.png',
                'link_url' => route('events.show', $event->slug),
                'is_active' => true,
            ]
        );

        // 4. Attach Reseller
        $reseller = \App\Models\User::where('email', 'reseller@anntix.com')->first();
        if ($reseller) {
            $event->resellers()->syncWithoutDetaching([$reseller->id]);
        }
    }
}
