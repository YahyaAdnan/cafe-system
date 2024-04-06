<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DeliverType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\DeliverType>
 */
final class DeliverTypeFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = DeliverType::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'cash' => fake()->boolean,
        ];
    }
}
