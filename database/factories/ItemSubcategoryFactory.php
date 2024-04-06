<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ItemSubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ItemSubcategory>
 */
final class ItemSubcategoryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ItemSubcategory::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'item_category_id' => \App\Models\ItemCategory::factory(),
            'title_ar' => fake()->word,
            'title_ku' => fake()->word,
            'image' => fake()->word,
        ];
    }
}
