<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Daftar kategori kosakata Bahasa Suku Wemale.
     *
     * @var array<int, array{name: string, deskripsi: string}>
     */
    private array $kategoris = [
        ['name' => 'Kekerabatan', 'deskripsi' => 'Istilah kekerabatan, sebutan keluarga, dan hubungan sosial adat.'],
        ['name' => 'Alam & Lingkungan', 'deskripsi' => 'Kata terkait tanah, air, langit, dan alam sekitar.'],
        ['name' => 'Perlengkapan Tradisional', 'deskripsi' => 'Benda, alat, dan perlengkapan budaya suku Wemale.'],
        ['name' => 'Flora & Fauna Seram Barat', 'deskripsi' => 'Nama tumbuhan, hewan, dan hasil alam Pulau Seram.'],
        ['name' => 'Kata Sifat & Kualitas', 'deskripsi' => 'Kata yang menggambarkan sifat, keadaan, atau kualitas.'],
        ['name' => 'Kata Kerja & Partikel', 'deskripsi' => 'Kata kerja, kata bantu, dan partikel tata bahasa.'],
        ['name' => 'Pendidikan & Kebudayaan', 'deskripsi' => 'Istilah terkait pengetahuan, budaya, dan pelestarian.'],
        ['name' => 'Kehidupan Sosial', 'deskripsi' => 'Aktivitas sosial, kegiatan masyarakat, dan pergaulan.'],
    ];

    public function run(): void
    {
        foreach ($this->kategoris as $kategori) {
            Kategori::firstOrCreate(
                ['slug' => Str::slug($kategori['name'])],
                [
                    'nama_kategori' => $kategori['name'],
                    'deskripsi' => $kategori['deskripsi'],
                ],
            );
        }
    }
}
