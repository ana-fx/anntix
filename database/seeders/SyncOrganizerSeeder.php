<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SyncOrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder will find all unique organizer names in the events table,
     * create a user for each one with the 'organizer' role,
     * and link the event to that user.
     */
    public function run(): void
    {
        // 1. Get all unique organizer names from events (only active ones, and exclude obvious dummy data)
        $dummyNames = ['asdasd', 'test', 'tester', 'dummy', 'admin', 'sinorganizer'];

        $organizerNames = Event::whereNotNull('organizer_name')
            ->where('organizer_name', '!=', '')
            ->whereNotIn('organizer_name', $dummyNames)
            ->distinct()
            ->pluck('organizer_name');

        foreach ($organizerNames as $name) {
            // 2. Create or find the organizer user
            // Clean up name for email
            $cleanName = Str::slug($name);
            $email = $cleanName . '@anntix.id';

            // Check if user already exists (by email or name)
            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'organizer',
                    'email_verified_at' => now(),
                ]);
                $this->command->info("Created organizer user: {$name} ({$email})");
            } else {
                // Ensure role is organizer
                $user->update(['role' => 'organizer']);
                $this->command->info("Found existing user for organizer: {$name}, ensured role is 'organizer'");
            }

            // 3. Link all events with this organizer_name to this user
            $count = Event::where('organizer_name', $name)->update([
                'organizer_id' => $user->id
            ]);

            $this->command->info("Linked {$count} events to organizer: {$name}");
        }

        // Special case: handle events without an organizer name if needed
        $noNameCount = Event::where(function($query) {
                $query->whereNull('organizer_name')->orWhere('organizer_name', '');
            })
            ->whereNull('organizer_id')
            ->count();

        if ($noNameCount > 0) {
            $this->command->warn("Found {$noNameCount} events without an organizer name or ID. These remain unassigned.");
        }
    }
}
