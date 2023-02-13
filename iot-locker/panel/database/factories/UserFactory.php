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
        return [
            'user_id' => 'ek_12',
            'user_name' => 'admin',
            'user_mobile_no' => '01812325447',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2a$12$9v6J.7m4x9h9KSfD5z9eq.MvuzG03KLM8wpEnOxjncNmUq16S9meC', // admin
            'role_id' => 1,
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
