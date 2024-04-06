<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Inventory>
 */
final class InventoryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Inventory::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'quantity' => fake()->randomNumber(),
            'inventory_unit_id' => \App\Models\InventoryUnit::factory(),
            'user_id' => 1,
            'note' => fake()->optional()->sentence,
        ];
    }
}
