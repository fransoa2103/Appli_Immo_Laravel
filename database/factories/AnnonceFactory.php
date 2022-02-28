<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'               => User::factory(),
            'reference_annonce'     => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'description_annonce'   => $this->faker->text(100),
            'prix_annonce'          => $this->faker->randomFloat(2, 10000, 10000000),
            'surface_habitable'     => $this->faker->randomFloat(2, 20, 100),
            'nombre_de_piece'       => $this->faker->numberBetween(1, 15),
        ];
    }
}
