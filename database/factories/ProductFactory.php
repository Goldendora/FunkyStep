<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100000, 300000),
            'discount' => 0,
            'stock' => 10,
            'brand' => 'Funkystep',
            'category' => 'Zapatillas',
            'sku' => $this->faker->unique()->ean8(),
            'image' => 'default.png',
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
