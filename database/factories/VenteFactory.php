<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vente>
 */
class VenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produit_id' => \App\Models\Produit::factory(),
            'quantite' => $this->faker->numberBetween(1, 100),
            'prix_unitaire' => $this->faker->randomFloat(2, 1, 1000),
            'total' => function (array $attributes) {
                return $attributes['quantite'] * $attributes['prix_unitaire'];
            },
        ];
    }
}
