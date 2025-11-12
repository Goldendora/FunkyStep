<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 50000, 500000),
            'discount' => fake()->randomFloat(2, 0, 20),
            'stock' => fake()->numberBetween(5, 100),
            'brand' => fake()->randomElement(['Nike', 'Adidas', 'Puma', 'Converse']),
            'category' => fake()->randomElement(['Running', 'Casual', 'Sport']),
            'sku' => fake()->unique()->bothify('SKU-#####'),
            'image' => 'product_images/example.jpg',
            'is_active' => true,
        ];
    }
}
