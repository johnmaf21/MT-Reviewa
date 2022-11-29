<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $username = $this->faker->unique()->userName();
        $color = $this->faker->hexColor();
        return [
            'username' => $username,
            'email' => $this->faker->unique()->safeEmail(),
            'dob' => $this->faker->date($format='d-m-Y', $max='-13 years'),
            'is_private' => false,
            'profile_pic' => "https://eu.ui-avatars.com/api/?name=".$username."&background=".substr($color, 1),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
