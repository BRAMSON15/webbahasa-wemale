<?php

namespace Database\Factories;

use App\Models\Kata;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kata>
 */
class KataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kata_wemale' => ucfirst($this->faker->unique()->word()),
            'arti_indonesia' => $this->faker->sentence(4),
            'contoh' => $this->faker->sentence(),
            'terjemahan_contoh' => $this->faker->sentence(),
            'kategori_id' => Kategori::factory(),
            'is_populer' => false,
        ];
    }

    /**
     * Tandai kata sebagai kata populer.
     */
    public function populer(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_populer' => true,
        ]);
    }
}
