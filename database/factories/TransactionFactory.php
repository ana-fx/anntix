<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'TRX-' . Str::upper(Str::random(10)),
            'event_id' => \App\Models\Event::factory(),
            'ticket_id' => \App\Models\Ticket::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'city' => fake()->city(),
            'nik' => fake()->numerify('################'),
            'gender' => fake()->randomElement(['male', 'female']),
            'quantity' => 1,
            'total_price' => 100000,
            'status' => 'pending',
            'snap_token' => Str::random(32),
            'payment_type' => 'bank_transfer',
        ];
    }
}
