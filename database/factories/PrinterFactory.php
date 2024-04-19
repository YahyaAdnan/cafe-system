<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Printer;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Printer>
 */
final class PrinterFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Printer::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'printer_id' => $this->faker->unique()->uuid, // Unique identifier for printer
            'room_id' => Room::factory(), // Use Room factory to generate a room ID
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
