<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ItemCategory>
 */
final class ItemCategoryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ItemCategory::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'item_type_id' => \App\Models\ItemType::factory(),
            'title_ar' => fake()->word,
            'title_ku' => fake()->word,
            'image' => fake()->word,
        ];
    }
}
