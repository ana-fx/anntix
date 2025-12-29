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
            ['email' => 'admin@admin.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin@admin.com'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin2@admin.com'],
            [
                'name' => 'Second Admin',
                'password' => Hash::make('admin2@admin.com'),
                'role' => 'admin',
            ]
        );

        // Scanners
        User::updateOrCreate(
            ['email' => 'officer1@anntix.com'],
            [
                'name' => 'Scanner Officer 1',
                'password' => Hash::make('officer1@anntix.com'),
                'role' => 'scanner',
            ]
        );

        User::updateOrCreate(
            ['email' => 'officer2@anntix.com'],
            [
                'name' => 'Scanner Officer 2',
                'password' => Hash::make('officer2@anntix.com'),
                'role' => 'scanner',
            ]
        );
    }
}
