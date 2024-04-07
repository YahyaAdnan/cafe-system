<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Invoice>
 */
final class InvoiceFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Invoice::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'inovice_no' => fake()->word,
            'title' => fake()->title,
            'dinning_in' => fake()->boolean,
            'table_id' => \App\Models\Table::factory(),
            'amount' => fake()->randomNumber(),
            'remaining' => fake()->randomNumber(),
            'discount_rate' => fake()->randomNumber(),
            'discount_fixed' => fake()->randomNumber(),
            'note' => fake()->optional()->sentence,
            'active' => fake()->boolean,
            'deliver_type_id' => \App\Models\DeliverType::factory(),
            'employee_id' => \App\Models\Employee::factory(),
        ];
    }
}
