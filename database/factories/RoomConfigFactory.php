<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\RoomConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RoomConfig>
 */
final class RoomConfigFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = RoomConfig::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'room_id' => \App\Models\Room::factory(),
            'roomable_type' => fake()->word,
            'roomable_id' => fake()->randomNumber(),
        ];
    }
}
