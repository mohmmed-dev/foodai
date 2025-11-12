<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(6),
            'body' => [
                'blocks' => [
                    ['type' => 'paragraph', 'data' => ['text' => $this->faker->paragraph()]],
                ],
            ],
            'type' => $this->faker->randomElement(['article','note','recipe','idea']),
            'share' => $this->faker->boolean(20),
            'error' => false,
            'self' => $this->faker->boolean(10),
        ];
    }
}
