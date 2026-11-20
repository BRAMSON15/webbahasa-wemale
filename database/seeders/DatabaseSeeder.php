<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin utama untuk login panel
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@wemale.test',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ],
        );

        // Beberapa pengguna terdaftar
        User::firstOrCreate(
            ['username' => 'budiwemale'],
            [
                'name' => 'Budi Wemale',
                'email' => 'budi@wemale.test',
                'password' => Hash::make('password'),
                'role' => UserRole::Pengguna,
                'email_verified_at' => now(),
            ],
        );

        User::factory(5)->create([
            'role' => UserRole::Pengguna,
        ]);

        $this->call([
            KategoriSeeder::class,
            KataSeeder::class,
            SoalKuisSeeder::class,
            AktivitasSeeder::class,
        ]);
    }
}
