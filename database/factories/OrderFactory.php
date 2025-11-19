<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => $this->faker->numberBetween(100000, 500000),
            'status' => 'pendiente',
            'payment_method' => 'stripe',
            'payment_provider' => 'stripe',
            'payment_reference' => 'sess_' . $this->faker->unique()->numberBetween(1000, 9999),
            'raw_payload' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
