<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('ITM-####')),
            'name' => fake()->words(3, true),
            'image' => null,
            'price' => fake()->randomFloat(2, 1000, 500000),
        ];
    }
}
