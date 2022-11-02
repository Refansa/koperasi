<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'supplier_id'   => Supplier::factory(),
            'name'          => fake()->name(),
            'stock'         => fake()->randomNumber(),
            'price'         => fake()->randomNumber(),
        ];
    }
}
