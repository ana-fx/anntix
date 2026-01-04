<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'halllo@anntix.id'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('Anntix.2026'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'andreananntixx@gmail.com'],
            [
                'name' => 'Andrea',
                'password' => Hash::make('Anntix.2026'),
                'role' => 'admin',
            ]
        );


    }
}
