<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'avatar' => Arr::random(config("profiles.avatars")),
            'dob' => $this->faker->dateTimeBetween('-20 years', '-3 years'),
            'sex' => Arr::random(["Male", "Female", "Other"]),
            'gender' => Arr::random(["Male", "Female", "Nonbinary"]),
            'symptoms' => [],
        ];
    }
}
