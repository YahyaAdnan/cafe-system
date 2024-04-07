<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Price>
 */
final class PriceFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Price::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'item_id' => \App\Models\Item::factory(),
            'title' => fake()->title,
            'amount' => fake()->randomNumber(),
            'note' => fake()->optional()->sentence,
        ];
    }
}
