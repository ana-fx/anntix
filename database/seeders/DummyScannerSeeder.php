<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Event;

class DummyScannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active events, up to 10
        $events = Event::where('end_date', '>=', now())->take(10)->get();

        for ($i = 1; $i <= 3; $i++) {
            $scanner = User::updateOrCreate(
                ['email' => "scanner{$i}@anntix.com"],
                [
                    'name' => "Dummy Scanner {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'scanner',
                    'is_active' => true,
                    'phone' => "0812345678{$i}",
                    'address' => 'Jakarta',
                ]
            );

            // Assign scanner to events
            if ($events->count() > 0) {
                $scanner->scannedEvents()->syncWithoutDetaching($events->pluck('id'));
            }
        }
    }
}
