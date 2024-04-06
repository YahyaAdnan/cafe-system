<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Order>
 */
final class OrderFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Order::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'invoice_id' => \App\Models\Invoice::factory(),
            'title' => fake()->title,
            'item_id' => \App\Models\Item::factory(),
            'price_id' => \App\Models\Price::factory(),
            'user_id' => 1,
            'amount' => fake()->randomNumber(),
            'discount_fixed' => fake()->randomNumber(),
            'note' => fake()->optional()->sentence,
            'total_amount' => fake()->randomNumber(),
        ];
    }
}
