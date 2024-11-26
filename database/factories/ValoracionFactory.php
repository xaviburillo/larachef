<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'texto' => $this->faker->sentence(),
            'rating' => $this->faker->numberBetween(1, 5),
            'user_id' => User::whereHas('roles', function ($query) {
                return $query->whereIn('role_id', [1, 2, 3]); // Rol lector, redactor, editor
            })->inRandomOrder()->first(),
        ];
    }

    public function average() {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(2, 5)
            ];
        });
    }
    
    public function good() {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(4, 5)
            ];
        });
    }

    public function bad() {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(1, 2)
            ];
        });
    }
}
