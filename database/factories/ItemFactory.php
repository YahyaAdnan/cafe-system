<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Item>
 */
final class ItemFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Item::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'image' => fake()->word,
            'is_available' => fake()->boolean,
            'show' => fake()->boolean,
            'show_ingredients' => fake()->boolean,
            'item_type_id' => \App\Models\ItemType::factory(),
            'item_category_id' => \App\Models\ItemCategory::factory(),
            'item_subcategory_id' => \App\Models\ItemSubcategory::factory(),
            'note' => fake()->optional()->sentence,
            'title_ar' => fake()->word,
            'title_ku' => fake()->word,

        ];
    }
}
