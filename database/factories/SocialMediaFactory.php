<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\SocialMedia>
 */
final class SocialMediaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = SocialMedia::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'image' => fake()->word,
            'title' => fake()->title,
            'url' => fake()->url,
            'show' => fake()->boolean,
            'order' => fake()->randomNumber(),
        ];
    }
}
