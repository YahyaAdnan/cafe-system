<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DailySale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\DailySale>
 */
final class DailySaleFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = DailySale::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'active' => fake()->boolean,
        ];
    }
}
