<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resellers = [
            [
                'name' => 'Alex Reseller',
                'email' => 'reseller@anntix.com',
                'password' => Hash::make('reseller@anntix.com'),
                'role' => 'reseller',
                'phone' => '+628111111111',
                'address' => 'Jakarta, Indonesia',
                'bio' => 'Professional event promoter and affiliate partner since 2024.',
            ],
            [
                'name' => 'Budi Affiliate',
                'email' => 'budi@reseller.com',
                'password' => Hash::make('budi@reseller.com'),
                'role' => 'reseller',
                'phone' => '+628222222222',
                'address' => 'Bandung, Indonesia',
                'bio' => 'Passionate about music and arts. Helping creators reach more audience.',
            ],
            [
                'name' => 'Santi Tickets',
                'email' => 'santi@reseller.com',
                'password' => Hash::make('santi@reseller.com'),
                'role' => 'reseller',
                'phone' => '+628333333333',
                'address' => 'Surabaya, Indonesia',
                'bio' => 'Expert in digital marketing and social media promotion for large scale events.',
            ],
        ];

        foreach ($resellers as $reseller) {
            User::updateOrCreate(
                ['email' => $reseller['email']],
                $reseller
            );
        }
    }
}
