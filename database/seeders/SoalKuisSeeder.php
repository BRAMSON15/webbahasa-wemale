<?php

namespace Database\Seeders;

use App\Models\SoalKuis;
use Illuminate\Database\Seeder;

class SoalKuisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $soals = [
            [
                'pertanyaan' => 'Apa arti dari kata "Mama" dalam Bahasa Suku Wemale?',
                'pilihan_a' => 'Anak perempuan',
                'pilihan_b' => 'Ibu atau orang tua perempuan',
                'pilihan_c' => 'Nenek buyut',
                'pilihan_d' => 'Saudara perempuan',
                'kunci_jawaban' => 'B',
                'pembahasan' => 'Kata "Mama" merujuk pada ibu atau orang tua perempuan, dan juga dipakai sebagai sebutan penghormatan kepada wanita dewasa dalam budaya Wemale.',
                'tingkat_kesulitan' => 'mudah',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Kata "Wai" dalam Bahasa Wemale memiliki arti...',
                'pilihan_a' => 'Air atau sungai',
                'pilihan_b' => 'Api unggun',
                'pilihan_c' => 'Tanah adat',
                'pilihan_d' => 'Batu karang',
                'kunci_jawaban' => 'A',
                'pembahasan' => '"Wai" berarti air, sumber mata air, atau sungai yang mengalir di pegunungan Seram Barat.',
                'tingkat_kesulitan' => 'mudah',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Istilah "Tana" dalam ungkapan "Wemale tana ami pele" mengacu pada...',
                'pilihan_a' => 'Laut dalam',
                'pilihan_b' => 'Langit biru',
                'pilihan_c' => 'Tanah, bumi, atau negeri leluhur',
                'pilihan_d' => 'Hutan belantara',
                'kunci_jawaban' => 'C',
                'pembahasan' => '"Tana" berarti tanah, bumi, atau negeri ulayat tempat tinggal dan tanah kelahiran Suku Wemale.',
                'tingkat_kesulitan' => 'mudah',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Apa arti kata "Leko" dalam kalimat "Hane ini leko manise"?',
                'pilihan_a' => 'Gelap gulita',
                'pilihan_b' => 'Panas terik',
                'pilihan_c' => 'Baik, bagus, atau elok',
                'pilihan_d' => 'Hujan lebat',
                'kunci_jawaban' => 'C',
                'pembahasan' => '"Leko" merupakan kata sifat dalam bahasa Wemale yang memiliki arti baik, bagus, elok, atau berkualitas.',
                'tingkat_kesulitan' => 'sedang',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Kata "Kari" dalam kehidupan sehari-hari masyarakat Wemale berarti...',
                'pilihan_a' => 'Burung cendrawasih',
                'pilihan_b' => 'Ikan atau hewan air',
                'pilihan_c' => 'Pohon sagu',
                'pilihan_d' => 'Rusa hutan',
                'kunci_jawaban' => 'B',
                'pembahasan' => '"Kari" mengacu pada ikan atau hasil tangkapan dari sungai maupun perairan pesisir.',
                'tingkat_kesulitan' => 'sedang',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Tradisi "Sasi" dalam kearifan lokal Suku Wemale dan Maluku bermakna...',
                'pilihan_a' => 'Pesta panen raya tahunan',
                'pilihan_b' => 'Larangan adat sementara terhadap pemanfaatan alam untuk konservasi',
                'pilihan_c' => 'Upacara perkawinan adat',
                'pilihan_d' => 'Tarian perang menyambut tamu',
                'kunci_jawaban' => 'B',
                'pembahasan' => '"Sasi" adalah pranata hukum adat yang melarang pengambilan komoditas alam tertentu dalam kurun waktu tertentu demi menjaga kelestarian ekosistem.',
                'tingkat_kesulitan' => 'sedang',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Kata negasi santun "Tidak" dalam Bahasa Wemale diungkapkan dengan kata...',
                'pilihan_a' => 'Nda',
                'pilihan_b' => 'Pise',
                'pilihan_c' => 'Ami',
                'pilihan_d' => 'Maso',
                'kunci_jawaban' => 'A',
                'pembahasan' => '"Nda" adalah partikel penolakan atau negasi yang berarti tidak dalam tata bahasa Wemale.',
                'tingkat_kesulitan' => 'mudah',
                'is_aktif' => true,
            ],
            [
                'pertanyaan' => 'Kata "Hane" berkaitan dengan konsep waktu yang berarti...',
                'pilihan_a' => 'Malam hari',
                'pilihan_b' => 'Musim kemarau',
                'pilihan_c' => 'Hari, waktu siang, atau siklus hari',
                'pilihan_d' => 'Tahun baru adat',
                'kunci_jawaban' => 'C',
                'pembahasan' => '"Hane" berarti hari atau waktu siang, seperti dalam frasa "Mata hane" (Matahari).',
                'tingkat_kesulitan' => 'sulit',
                'is_aktif' => true,
            ],
        ];

        foreach ($soals as $item) {
            SoalKuis::updateOrCreate(
                ['pertanyaan' => $item['pertanyaan']],
                $item
            );
        }
    }
}
