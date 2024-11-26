<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $published_at = $this->faker->randomElement([
            $this->faker->dateTimeThisYear(),
            null
        ]);

        if ($published_at == null) {
            $rejected = $this->faker->boolean(20);
        } else {
            $rejected = false;
        }

        $cantidades = [
            '300ml',
            '10gr',
            '1L',
            '500gr',
            '1 cucharada'
        ];

        $ingredientes = [
            ' de sal',
            ' de carne picada',
            ' de huevo batido',
            ' de plátano',
            ' de caldo de pollo',
            ' de cous-cous',
            ' de azúcar',
            ' de arroz',
            ' de leche',
            ' de zumo de limón'
        ];

        return [
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraphs(2, true),
            'duracion' => round($this->faker->numberBetween(0, 300), -1),
            'ingredientes' => function () use ($cantidades, $ingredientes) {
                $array = [];

                for ($i=0; $i<random_int(3, 8); $i++) {

                    $ingrediente = $cantidades[array_rand($cantidades)];

                    $ingrediente = $ingrediente.$ingredientes[array_rand($ingredientes)];

                    array_push($array, $ingrediente);
                }

                return $array;
            },
            'pasos' => $this->faker->sentences(random_int(3, 8)),
            'published_at' => $published_at,
            'rejected' => $rejected,
            'user_id' => User::whereHas('roles', function ($query) {
                return $query->where('role_id', '=', 2); // Rol redactor
            })->inRandomOrder()->first(),
        ];
    }
}
