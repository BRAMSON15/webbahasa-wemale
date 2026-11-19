<?php

namespace Database\Factories;

use App\Models\Aktivitas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Aktivitas>
 */
class AktivitasFactory extends Factory
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
            'tipe' => $this->faker->randomElement(['tambah', 'ubah', 'hapus', 'daftar', 'sistem']),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
