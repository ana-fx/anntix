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
        // 1. Create Reference Event
        $event = Event::create([
            'name' => 'Reference Design Festival',
            'slug' => 'reference-design-festival',
            'description' => '<p>This is a dummy event created to demonstrate the optimal image dimensions for the Anntix platform.</p><ul><li><strong>Thumbnail:</strong> 1080x1080 (Square)</li><li><strong>Card Banner:</strong> 1920x1080 (16:9)</li></ul>',
            'location' => 'Digital Space',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'start_date' => Carbon::now()->addDays(30),
            'end_date' => Carbon::now()->addDays(32),
            'status' => 'active',
            'organizer_name' => 'Anntix Design Team',
            'thumbnail_path' => 'events/dummy-thumb.png', // 1080x1080
            'banner_path' => 'events/dummy-banner.png',   // 1920x1080 (Card)
            'category' => 'Reference',
        ]);

        // 2. Create Ticket
        $event->tickets()->create([
            'name' => 'Standard Access',
            'description' => 'General entry ticket.',
            'price' => 150000,
            'quota' => 100,
            'max_purchase_per_user' => 5,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(30),
        ]);

        // 3. Create Hero Banner
        Banner::create([
            'title' => 'Reference Hero Banner',
            'slug' => 'reference-hero-banner',
            'image_path' => 'banners/dummy-hero.png', // 3240x1080
            'link_url' => route('events.show', $event->slug),
            'is_active' => true,
        ]);
    }
}
