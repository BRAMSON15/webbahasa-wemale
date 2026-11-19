<?php

namespace Database\Seeders;

use App\Models\Kata;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kekerabatan = Kategori::where('slug', 'kekerabatan')->first();
        $alam = Kategori::where('slug', 'alam-lingkungan')->first();
        $perlengkapan = Kategori::where('slug', 'perlengkapan-tradisional')->first();
        $floraFauna = Kategori::where('slug', 'flora-fauna-seram-barat')->first();
        $sifat = Kategori::where('slug', 'kata-sifat-kualitas')->first();
        $partikel = Kategori::where('slug', 'kata-kerja-partikel')->first();
        $pendidikan = Kategori::where('slug', 'pendidikan-kebudayaan')->first();
        $sosial = Kategori::where('slug', 'kehidupan-sosial')->first();

        /**
         * Daftar kata kamus.
         * Setiap entri: kata_wemale, arti_indonesia, contoh, terjemahan_contoh, kategori, is_populer.
         *
         * @var array<int, array{kata: string, arti: string, contoh: string, terjemahan: string, kategori: string, populer: bool}>
         */
        $katas = [
            // 10 kata populer sesuai mockup beranda
            ['kata' => 'Mama', 'arti' => 'Ibu, orang tua perempuan, sebutan penghormatan kepada wanita dewasa.', 'contoh' => 'Mama e, au wai leko.', 'terjemahan' => 'Ibu, air ini sangat bagus dan segar.', 'kategori' => $kekerabatan?->id, 'populer' => true],
            ['kata' => 'Tana', 'arti' => 'Tanah, bumi, negeri, tanah kelahiran atau wilayah adat ulayat suku.', 'contoh' => 'Wemale tana ami pele.', 'terjemahan' => 'Tanah adat Wemale adalah warisan leluhur kami.', 'kategori' => $alam?->id, 'populer' => true],
            ['kata' => 'Wai', 'arti' => 'Air, mata air, atau sungai yang mengalir untuk kehidupan.', 'contoh' => 'Mai ita kinu wai talae.', 'terjemahan' => 'Mari kita minum air dari pancuran jernih.', 'kategori' => $alam?->id, 'populer' => true],
            ['kata' => 'Suku', 'arti' => 'Suku atau kelompok kekerabatan masyarakat adat Wemale di Pulau Seram.', 'contoh' => 'Suku Wemale manise manawa.', 'terjemahan' => 'Masyarakat Suku Wemale hidup rukun dan bersahabat.', 'kategori' => $kekerabatan?->id, 'populer' => true],
            ['kata' => 'Mata', 'arti' => 'Mata (indera penglihatan), atau titik pusat sumber (seperti mata air / mata hane).', 'contoh' => 'Mata hane mehe soso.', 'terjemahan' => 'Matahari pagi mulai menyinari perbukitan.', 'kategori' => $alam?->id, 'populer' => true],
            ['kata' => 'Hane', 'arti' => 'Hari, waktu siang, atau siklus pergantian hari.', 'contoh' => 'Hane ini hane leko manise.', 'terjemahan' => 'Hari ini adalah hari yang baik dan cerah.', 'kategori' => $alam?->id, 'populer' => true],
            ['kata' => 'Kari', 'arti' => 'Ikan atau hewan air hasil tangkapan dari laut atau sungai.', 'contoh' => 'Ita ala kari mehe tahi.', 'terjemahan' => 'Kita menangkap ikan segar dari teluk.', 'kategori' => $floraFauna?->id, 'populer' => true],
            ['kata' => 'Nda', 'arti' => 'Tidak, ungkapan negasi atau penolakan santun.', 'contoh' => 'Au nda lau talae.', 'terjemahan' => 'Saya tidak pergi ke hutan hari ini.', 'kategori' => $partikel?->id, 'populer' => true],
            ['kata' => 'Leko', 'arti' => 'Baik, bagus, elok, indah, atau berkualitas.', 'contoh' => 'Kamus ini leko pise ami malane.', 'terjemahan' => 'Kamus ini sangat bagus bagi anak cucu kita.', 'kategori' => $sifat?->id, 'populer' => true],
            ['kata' => 'Buku', 'arti' => 'Buku, kitab, atau catatan tulisan pembelajaran kata.', 'contoh' => 'Basa buku kamus Wemale.', 'terjemahan' => 'Membaca buku kamus Bahasa Suku Wemale.', 'kategori' => $pendidikan?->id, 'populer' => true],

            // Kata tambahan untuk memperkaya kamus
            ['kata' => 'Sasi', 'arti' => 'Larangan adat sementara terhadap pengambilan sumber daya alam untuk pelestarian.', 'contoh' => 'Sasi wai ena kari.', 'terjemahan' => 'Sasi melarangi mengambil ikan di sungai ini.', 'kategori' => $sosial?->id, 'populer' => false],
            ['kata' => 'Tamo', 'arti' => 'Bambu, jenis tanaman untuk bangunan dan perlengkapan rumah.', 'contoh' => 'Rumah tamo esa.', 'terjemahan' => 'Rumah dibuat dari bambu.', 'kategori' => $perlengkapan?->id, 'populer' => false],
            ['kata' => 'Pela', 'arti' => 'Warisan, pusaka, atau harta peninggalan leluhur.', 'contoh' => 'Tana pela manise.', 'terjemahan' => 'Tanah warisan itu diberkahi.', 'kategori' => $kekerabatan?->id, 'populer' => false],
            ['kata' => 'Maise', 'arti' => 'Mari, ajakan atau panggilan bersama untuk berbuat sesuatu.', 'contoh' => 'Maise ita wai.', 'terjemahan' => 'Mari kita ambil air.', 'kategori' => $partikel?->id, 'populer' => false],
            ['kata' => 'Tahi', 'arti' => 'Laut, perairan, atau air laut.', 'contoh' => 'Kari tahi leko.', 'terjemahan' => 'Ikan laut itu segar.', 'kategori' => $alam?->id, 'populer' => false],
            ['kata' => 'Soso', 'arti' => 'Bukit, perbukitan, atau tanah yang meninggi.', 'contoh' => 'Soso hane mehe.', 'terjemahan' => 'Bukit disinari matahari.', 'kategori' => $alam?->id, 'populer' => false],
            ['kata' => 'Manise', 'arti' => 'Manis, baik hati, atau ramah dalam pergaulan.', 'contoh' => 'Suku manise manawa.', 'terjemahan' => 'Suku yang manis dan rukun.', 'kategori' => $sifat?->id, 'populer' => false],
            ['kata' => 'Kinu', 'arti' => 'Minum, menyerap atau menikmati cairan.', 'contoh' => 'Mai kinu wai.', 'terjemahan' => 'Mari minum air.', 'kategori' => $partikel?->id, 'populer' => false],
            ['kata' => 'Ala', 'arti' => 'Mengambil, menangkap, atau memperoleh hasil.', 'contoh' => 'Ala kari mehe.', 'terjemahan' => 'Menangkap ikan segar.', 'kategori' => $partikel?->id, 'populer' => false],
            ['kata' => 'Rumah', 'arti' => 'Rumah, tempat tinggal keluarga adat.', 'contoh' => 'Rumah adat Wemale leko.', 'terjemahan' => 'Rumah adat Wemale itu indah.', 'kategori' => $perlengkapan?->id, 'populer' => false],
            ['kata' => 'Au', 'arti' => 'Saya, kata ganti orang pertama tunggal.', 'contoh' => 'Au nda lau.', 'terjemahan' => 'Saya tidak pergi.', 'kategori' => $partikel?->id, 'populer' => false],
            ['kata' => 'Ita', 'arti' => 'Kita, kata ganti orang pertama jamak inklusif.', 'contoh' => 'Ita ala kari.', 'terjemahan' => 'Kita menangkap ikan.', 'kategori' => $partikel?->id, 'populer' => false],
            ['kata' => 'Basa', 'arti' => 'Membaca atau mempelajari tulisan.', 'contoh' => 'Basa buku Wemale.', 'terjemahan' => 'Membaca buku Wemale.', 'kategori' => $pendidikan?->id, 'populer' => false],
            ['kata' => 'Pise', 'arti' => 'Sangat, kata penguat untuk menyatakan tingkat tinggi.', 'contoh' => 'Leko pise.', 'terjemahan' => 'Sangat baik.', 'kategori' => $partikel?->id, 'populer' => false],
            ['kata' => 'Manawa', 'arti' => 'Hidup, kehidupan, atau berkembang biak.', 'contoh' => 'Manawa manise.', 'terjemahan' => 'Hidup dengan baik.', 'kategori' => $sosial?->id, 'populer' => false],
        ];

        foreach ($katas as $item) {
            Kata::firstOrCreate(
                ['kata_wemale' => $item['kata']],
                [
                    'arti_indonesia' => $item['arti'],
                    'contoh' => $item['contoh'],
                    'terjemahan_contoh' => $item['terjemahan'],
                    'kategori_id' => $item['kategori'],
                    'is_populer' => $item['populer'],
                ],
            );
        }
    }
}
