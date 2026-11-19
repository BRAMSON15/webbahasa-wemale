<?php

namespace Database\Seeders;

use App\Models\Aktivitas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AktivitasSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin?->id;

        // 4 aktivitas terbaru sesuai mockup dashboard (hari ini)
        $terbaru = [
            ['user_id' => $adminId, 'tipe' => 'tambah', 'deskripsi' => 'Admin menambahkan kata baru: "Sasi"', 'jam' => 2],
            ['user_id' => $adminId, 'tipe' => 'ubah', 'deskripsi' => 'Admin memperbarui informasi website', 'jam' => 3],
            ['user_id' => null, 'tipe' => 'daftar', 'deskripsi' => 'Pengguna baru terdaftar: "Budi Wemale"', 'jam' => 5],
            ['user_id' => $adminId, 'tipe' => 'hapus', 'deskripsi' => 'Admin menghapus kata: "Tamo"', 'jam' => 6],
        ];

        // Aktivitas tersebar sepanjang 7 hari terakhir untuk mengisi grafik penggunaan
        $tersebar = [
            ['user_id' => $adminId, 'tipe' => 'tambah', 'deskripsi' => 'Admin menambahkan kata baru: "Maise"', 'hari' => 6],
            ['user_id' => $adminId, 'tipe' => 'tambah', 'deskripsi' => 'Admin menambahkan kata baru: "Kinu"', 'hari' => 5],
            ['user_id' => $adminId, 'tipe' => 'ubah', 'deskripsi' => 'Admin memperbarui kategori: "Alam & Lingkungan"', 'hari' => 5],
            ['user_id' => null, 'tipe' => 'daftar', 'deskripsi' => 'Pengguna baru terdaftar: "Siti Manusela"', 'hari' => 4],
            ['user_id' => $adminId, 'tipe' => 'tambah', 'deskripsi' => 'Admin menambahkan kata baru: "Ala"', 'hari' => 4],
            ['user_id' => $adminId, 'tipe' => 'tambah', 'deskripsi' => 'Admin menambahkan kategori baru: "Kehidupan Sosial"', 'hari' => 3],
            ['user_id' => $adminId, 'tipe' => 'ubah', 'deskripsi' => 'Admin memperbarui kata: "Wai"', 'hari' => 2],
            ['user_id' => $adminId, 'tipe' => 'tambah', 'deskripsi' => 'Admin menambahkan kata baru: "Pise"', 'hari' => 1],
            ['user_id' => null, 'tipe' => 'daftar', 'deskripsi' => 'Pengguna baru terdaftar: "Andi Seram"', 'hari' => 1],
            ['user_id' => $adminId, 'tipe' => 'hapus', 'deskripsi' => 'Admin menghapus kata duplikat: "Rumah"', 'hari' => 1],
        ];

        foreach ($terbaru as $item) {
            $waktu = Carbon::now()->subHours($item['jam']);
            Aktivitas::firstOrCreate(
                ['deskripsi' => $item['deskripsi']],
                ['user_id' => $item['user_id'], 'tipe' => $item['tipe'], 'created_at' => $waktu, 'updated_at' => $waktu],
            );
        }

        foreach ($tersebar as $item) {
            $waktu = Carbon::now()->subDays($item['hari'])->setHour(10)->setMinute(30);
            Aktivitas::firstOrCreate(
                ['deskripsi' => $item['deskripsi']],
                ['user_id' => $item['user_id'], 'tipe' => $item['tipe'], 'created_at' => $waktu, 'updated_at' => $waktu],
            );
        }
    }
}
