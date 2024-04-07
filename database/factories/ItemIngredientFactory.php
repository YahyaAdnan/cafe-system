<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ItemIngredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ItemIngredient>
 */
final class ItemIngredientFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ItemIngredient::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'item_id' => fake()->randomNumber(),
            'ingredient_id' => 1,
            'main' => fake()->boolean,
            'note' => fake()->optional()->sentence,
        ];
    }
}
