<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\InventoryRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\InventoryRecord>
 */
final class InventoryRecordFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = InventoryRecord::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'inventory_id' => 1,
            'quantity' => fake()->randomNumber(),
            'type' => fake()->randomElement(['Increase', 'Decrease']),
            'user_id' => 1,
            'expense_id' => 1,
            'supplier_id' => \App\Models\Supplier::factory(),
        ];
    }
}
