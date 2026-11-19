<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->unique()->words(2, true);

        return [
            'nama_kategori' => ucfirst($nama),
            'slug' => Str::slug($nama),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
