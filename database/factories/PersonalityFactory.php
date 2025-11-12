<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personality>
 */
class PersonalityFactory extends Factory
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
            'gender' => $this->faker->randomElement(['male','female']),
            'age' => $this->faker->numberBetween(18, 75),
            'weight' => $this->faker->randomFloat(1, 50, 110),
            'height' => $this->faker->randomFloat(1, 150, 200),
            'activity_level' => $this->faker->randomElement(['sedentary','light','moderate','active','very_active']),
            'bmr' => null,
            'tdee' => null,
            'goal' => $this->faker->randomElement(['maintain','lose_weight','gain_weight']),
            'diet_type' => $this->faker->randomElement(['omnivore','vegetarian','vegan','pescatarian','keto','paleo', null]),
            'allergies' => $this->faker->randomElements(['gluten','peanut','dairy','soy','none'], $this->faker->numberBetween(0,2)),
            'health_goals' => $this->faker->randomElements(['build_muscle','lose_fat','improve_endurance','improve_sleep'], $this->faker->numberBetween(0,2)),
            'religion' => $this->faker->randomElement(['none','muslim','christian','jewish','hindu', null]),
            'custom_preferences' => [
                'likes_spicy' => $this->faker->boolean(30),
                'dislikes' => $this->faker->randomElements(['onion','garlic','mushroom','pepper'], $this->faker->numberBetween(0,2)),
            ],
        ];
    }
}
