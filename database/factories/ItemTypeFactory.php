<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ItemType>
 */
final class ItemTypeFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ItemType::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'title_ar' => fake()->word,
            'title_ku' => fake()->word,
            'image' => fake()->word,
        ];
    }
}
