<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Transaction>
 */
final class TransactionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Transaction::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomNumber(),
            'user_id' => 1,
            'payment_method_id' => \App\Models\PaymentMethod::factory(),
            'transactionable_id' => fake()->randomNumber(),
            'transactionable_type' => fake()->word,
        ];
    }
}
