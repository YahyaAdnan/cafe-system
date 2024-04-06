<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Payment>
 */
final class PaymentFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Payment::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'invoice_id' => \App\Models\Invoice::factory(),
            'amount' => fake()->randomNumber(),
            'payment_method_id' => \App\Models\PaymentMethod::factory(),
            'user_id' => 1,
            'note' => fake()->optional()->sentence,
            'paid' => fake()->randomNumber(),
            'remaining' => fake()->randomNumber(),
        ];
    }
}
