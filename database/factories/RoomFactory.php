<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Room>
 */
final class RoomFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Room::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word,
            'cashier' => $this->faker->boolean,
            'monitor' => $this->faker->boolean,
            'printing' => $this->faker->boolean,
        ];
    }
}
