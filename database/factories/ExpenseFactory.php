<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Expense>
 */
final class ExpenseFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Expense::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'date' => fake()->date(),
            'amount' => fake()->randomNumber(),
            'user_id' => 1,
            'expense_category_id' => \App\Models\ExpenseCategory::factory(),
            'note' => fake()->optional()->sentence,
            'payment_method_id' => \App\Models\PaymentMethod::factory(),
        ];
    }
}
