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
        $legacyQuestions = [
            'Apa arti dari kata "Mama" dalam Bahasa Suku Wemale?',
            'Kata "Wai" dalam Bahasa Wemale memiliki arti...',
            'Istilah "Tana" dalam ungkapan "Wemale tana ami pele" mengacu pada...',
            'Apa arti kata "Leko" dalam kalimat "Hane ini leko manise"?',
            'Kata "Kari" dalam kehidupan sehari-hari masyarakat Wemale berarti...',
            'Tradisi "Sasi" dalam kearifan lokal Suku Wemale dan Maluku bermakna...',
            'Kata negasi santun "Tidak" dalam Bahasa Wemale diungkapkan dengan kata...',
            'Kata "Hane" berkaitan dengan konsep waktu yang berarti...',
        ];

        SoalKuis::query()
            ->whereIn('pertanyaan', $legacyQuestions)
            ->delete();

        $soals = [
            ['SAI artinya...', '2', '1', '3', '5', 'B', 'mudah'],
            ['LUA artinya...', '1', '3', '2', '5', 'C', 'mudah'],
            ['TELU artinya...', '1', '2', '3', '5', 'C', 'mudah'],
            ['HALE artinya...', '6', '7', '4', '5', 'C', 'mudah'],
            ['LIMA artinya...', '1', '3', '4', '5', 'D', 'mudah'],
            ['TINANE artinya...', '4', '6', '7', '8', 'B', 'mudah'],
            ['HITU artinya...', '6', '8', '7', '9', 'C', 'mudah'],
            ['WAU artinya...', '7', '8', '9', '10', 'B', 'mudah'],
            ['SIWA artinya...', '8', '10', '9', '7', 'C', 'mudah'],
            ['PUTUSA artinya...', '9', '8', '10', '7', 'C', 'mudah'],
            ['YASU artinya...', 'Ikan', 'Babi', 'Anjing', 'Ayam', 'C', 'mudah'],
            ['YANE artinya...', 'Anjing', 'Tikus', 'Ikan', 'Babi', 'C', 'mudah'],
            ['YAKALE artinya...', 'Ayam', 'Rusa', 'Ular', 'Babi', 'D', 'mudah'],
            ['MANUWE artinya...', 'Ikan', 'Ayam', 'Katak', 'Tikus', 'B', 'mudah'],
            ['MANUWE TELULI artinya...', 'Ayam goreng', 'Anak ayam', 'Telur Ayam', 'Daging ayam', 'C', 'mudah'],
            ['MAIRANE artinya...', 'Kusu', 'Katak', 'Rusa', 'Tikus', 'C', 'mudah'],
            ['MARELE artinya...', 'Rusa', 'Ular', 'Kusu / Kus-kus', 'Anjing', 'C', 'mudah'],
            ['KAKA artinya...', 'Kaka', 'Katak', 'Tikus', 'Ular', 'B', 'mudah'],
            ['MAUPA artinya...', 'Katak', 'Ular', 'Tikus', 'Babi', 'C', 'mudah'],
            ['KETUWALI artinya...', 'Tikus', 'Katak', 'Rusa', 'Ular', 'D', 'mudah'],
            ['MAU artinya...', 'Anjing', 'Kucing', 'Tikus', 'Ayam', 'B', 'mudah'],
            ['HURI artinya...', 'Kelapa', 'Kaladi', 'Pisang', 'Nasi', 'C', 'mudah'],
            ['NUWELE artinya...', 'Pisang', 'Ubi', 'Gula', 'Kelapa', 'D', 'mudah'],
            ['UKU artinya...', 'Pisang', 'Singkong', 'Papeda', 'Kaladi', 'D', 'mudah'],
            ['KAITELA artinya...', 'Singkong', 'Kelapa', 'Pisang', 'Petatas / Ubi Jalar', 'D', 'mudah'],
            ['KAPISI I artinya...', 'Papeda', 'Nasi', 'Kasbi / Singkong', 'Gula', 'C', 'mudah'],
            ['LIKI artinya...', 'Nasi', 'Pisang', 'Papeda', 'Sageru', 'C', 'mudah'],
            ['HA artinya...', 'Air', 'Gula', 'Nasi', 'Sopi', 'C', 'mudah'],
            ['NASU artinya...', 'Air', 'Sopi', 'Gula', 'Sageru', 'C', 'mudah'],
            ['ARAKE artinya...', 'Sageru', 'Air', 'Gula', 'Sopi', 'D', 'mudah'],
            ['TUWAE artinya...', 'Sopi', 'Air', 'Gula', 'Sageru', 'D', 'mudah'],
            ['MANAWA artinya...', 'Perempuan', 'Mama', 'Laki-laki', 'Bapak', 'C', 'mudah'],
            ['MAPINA artinya...', 'Laki-laki', 'Kaka laki-laki', 'Adik perempuan', 'Perempuan', 'D', 'mudah'],
            ['MAUWA artinya...', 'Mama', 'Cucu', 'Bapak', 'Adik', 'C', 'mudah'],
            ['MEMEU artinya...', 'Bapak', 'Kaka', 'Mama', 'Anak', 'C', 'mudah'],
            ['U LEU artinya...', 'Kaka Laki-laki', 'Adik Laki-laki', 'Kaka Perempuan', 'Adik Perempuan', 'C', 'mudah'],
            ['WA U artinya...', 'Kaka Perempuan', 'Adik Perempuan', 'Kaka Laki-laki', 'Adik Laki-laki', 'C', 'mudah'],
            ['WALIUSI artinya...', 'Adik Perempuan', 'Kaka Perempuan', 'Adik Laki-laki', 'Kaka Laki-laki', 'C', 'mudah'],
            ['ULEUSI artinya...', 'Adik Laki-laki', 'Anak Laki-laki', 'Adik Perempuan', 'Anak Perempuan', 'C', 'mudah'],
            ['UWANASI artinya...', 'Anak perempuan yang sudah ada anak', 'Cucu laki-laki', 'Anak laki-laki yang sudah ada anak', 'Cucu perempuan', 'C', 'mudah'],
            ['UANA MUASI artinya...', 'Anak laki-laki yang sudah ada anak', 'Anak perempuan yang sudah ada anak', 'Cucu perempuan', 'Adik perempuan', 'B', 'mudah'],
            ['MEME U artinya...', 'Mama', 'Bapak', 'Kaka', 'Cucu', 'D', 'mudah'],
            ['LATU artinya...', 'Batu', 'Raja', 'Bapak', 'Tuhan', 'B', 'mudah'],
            ['TAMAUNE artinya...', 'Parang', 'Pisau', 'Mancadu / Kapak', 'Tombak', 'C', 'mudah'],
            ['TULIYE artinya...', 'Pisau', 'Tombak', 'Panah', 'Parang', 'D', 'mudah'],
            ['TULIYE ARAYATI artinya...', 'Parang Pendek', 'Pisau', 'Parang Panjang', 'Tombak', 'C', 'mudah'],
            ['TULIYE MITI KALE artinya...', 'Parang Panjang', 'Pisau', 'Kapak', 'Parang Pendek', 'D', 'mudah'],
            ['TULIYE UKA artinya...', 'Parang', 'Tombak', 'Pisau', 'Panah', 'C', 'mudah'],
            ['WAAWESA artinya...', 'Panah', 'Senjata', 'Tombak', 'Kapak', 'C', 'mudah'],
            ['PUSULE artinya...', 'Tombak', 'Senjata', 'Pisau', 'Panah', 'D', 'mudah'],
            ['POLA artinya...', 'Tombak', 'Senjata', 'Panah', 'Pisau', 'B', 'mudah'],
            ['CEREKE artinya...', 'Gelas', 'Cerek', 'Panci', 'Mangkuk', 'B', 'mudah'],
            ['GALASI artinya...', 'Mangkuk', 'Gelas', 'Cerek', 'Panci', 'B', 'mudah'],
            ['MOKO artinya...', 'Gelas', 'Panci', 'Tacu', 'Mangkuk', 'D', 'mudah'],
            ['ULEPESI artinya...', 'Gelas', 'Mangkuk', 'Cerek', 'Panci', 'D', 'mudah'],
            ['KAWALE artinya...', 'Panci', 'Gelas', 'Tacu', 'Mangkuk', 'C', 'mudah'],
            ['SALIPA artinya...', 'Sarung', 'Gelas', 'Kain', 'Panci', 'C', 'mudah'],
            ['SALIPA SERUE artinya...', 'Kain Panjang', 'Kain Biasa', 'Kain Sarung', 'Kain Pendek', 'C', 'mudah'],
            ['SALIPA ARAYATI artinya...', 'Kain Sarung', 'Kain Pendek', 'Kain Biasa', 'Kain Panjang', 'D', 'mudah'],
            ['PATU artinya...', 'Raja', 'Batu', 'Kayu', 'Besi', 'B', 'mudah'],
            ['MAANE artinya...', 'Minum', 'Tidur', 'Makan', 'Duduk', 'C', 'sulit'],
            ['MA INU artinya...', 'Makan', 'Mandi', 'Jalan', 'Minum', 'D', 'sulit'],
            ['UANE HURI artinya...', 'Kita makan pisang', 'Kalian makan pisang', 'Saya makan pisang', 'Dia makan pisang', 'C', 'sulit'],
            ['MA ANE HURI artinya...', 'Saya makan pisang', 'Kamu makan pisang', 'Kita makan pisang', 'Kalian makan pisang', 'C', 'sulit'],
            ['U ANE LIKI artinya...', 'Kita makan papeda', 'Saya makan nasi', 'Beta makan papeda', 'Kita makan nasi', 'C', 'sulit'],
            ['MA ANE LIKI artinya...', 'Beta makan papeda', 'Saya makan pisang', 'Kita makan papeda', 'Kita makan pisang', 'C', 'sulit'],
            ['U ANE HA artinya...', 'Kita makan nasi', 'Saya makan nasi', 'Saya makan pisang', 'Kita makan keladi', 'B', 'sulit'],
            ['MA ANE UKU artinya...', 'Saya makan keladi', 'Kita makan pisang', 'Kita makan keladi', 'Kita makan nasi', 'C', 'sulit'],
            ['U MOO artinya...', 'Ada', 'Ya', 'Tidak', 'Mau', 'C', 'sulit'],
            ['HEREKA artinya...', 'Mau Kemana', 'Ada Apa', 'Kamu Buat Apa', 'Cepat', 'B', 'sulit'],
            ['MATOKO artinya...', 'Kita Mandi', 'Kita Tidur', 'Kita Lari', 'Kita Duduk', 'C', 'sulit'],
            ['MASU UMA artinya...', 'Kita Lari', 'Kita Tidur', 'Kita Mandi', 'Kita Jalan', 'C', 'sulit'],
            ['MA HAU KU artinya...', 'Kumpul', 'Kita Berkumpul', 'Kita Tidur', 'Kita Duduk', 'B', 'sulit'],
            ['HAU KU artinya...', 'Kita Berkumpul', 'Kumpul', 'Kita Tidur', 'Kita Jalan', 'B', 'sulit'],
            ['METE artinya...', 'Siang', 'Pagi', 'Malam', 'Sore', 'C', 'sulit'],
            ['MAU WA artinya...', 'Malam', 'Pagi', 'Sore', 'Siang', 'D', 'sulit'],
            ['MARAHELE artinya...', 'Kita Duduk', 'Kita Tidur', 'Kita Jalan', 'Kita Lari', 'B', 'sulit'],
            ['MATUWE artinya...', 'Kita Tidur', 'Kita Duduk', 'Kita Jalan', 'Kita Lari', 'B', 'sulit'],
            ['MATA I artinya...', 'Kita Duduk', 'Kita Tidur', 'Kita Berjalan', 'Kita Lari', 'C', 'sulit'],
            ['ANE SAHA artinya...', 'Kalian makan apa', 'Kamu makan apa', 'Kamu mau kemana', 'Kamu buat apa', 'B', 'sulit'],
            ['MI ANE SAHA artinya...', 'Kamu makan apa', 'Kamu mau kemana', 'Kalian makan apa', 'Kalian mau kemana', 'C', 'sulit'],
            ['ALOWEI MINA artinya...', 'Kalian kemari dulu', 'Kamu kemari dulu', 'Mari kita makan', 'Mari semua makan', 'B', 'sulit'],
            ['MILOWEI MINA artinya...', 'Kamu kemari dulu', 'Mari kita makan', 'Kalian kemari dulu', 'Mari semua makan', 'C', 'sulit'],
            ['AHONO SAHAE artinya...', 'Kalian ada buat apa', 'Kamu mau kemana', 'Kamu ada buat apa', 'Kamu makan apa', 'C', 'sulit'],
            ['MIHONO SAHAE artinya...', 'Kamu ada buat apa', 'Kalian ada buat apa', 'Kamu mau kemana', 'Kalian mau kemana', 'B', 'sulit'],
            ['ALOWEI MA ANE artinya...', 'Mari semua makan', 'Kamu kemari dulu', 'Mari kita makan', 'Kalian kemari dulu', 'C', 'sulit'],
            ['MILOWEI MA ANE artinya...', 'Mari kita makan', 'Mari semua makan', 'Kamu kemari dulu', 'Kalian kemari dulu', 'B', 'sulit'],
            ['AHEREKA artinya...', 'Kalian mau kemana', 'Kamu buat apa', 'Kamu makan apa', 'Kamu mau kemana', 'D', 'sulit'],
            ['MIEREKA artinya...', 'Kamu mau kemana', 'Kamu buat apa', 'Kalian mau kemana', 'Kamu makan apa', 'C', 'sulit'],
            ['HAPIA A artinya...', 'Lambat', 'Duduk', 'Cepat', 'Tidur', 'C', 'sulit'],
            ['MALEU artinya...', 'Kami lewat', 'Saya lewat', 'Kamu lewat', 'Kalian lewat', 'B', 'sulit'],
            ['MALEU MINA artinya...', 'Saya lewat', 'Kamu lewat', 'Kami lewat', 'Kalian lewat', 'C', 'sulit'],
            ['SEINA artinya...', 'Apa', 'Siapa', 'Kemana', 'Kapan', 'B', 'sulit'],
            ['YA U artinya...', 'Kamu', 'Saya', 'Kita', 'Kalian', 'B', 'sulit'],
            ['Kalau kamu mau bertanya "Siapa namamu?" dalam Bahasa Wemale, kata apa yang kamu pakai di awal?', 'Mau', 'Latu', 'Seina', 'Patu', 'C', 'sulit'],
            ['Mana pasangan yang BENAR?', 'Mau = Anjing', 'Latu = Batu', 'Patu = Raja', 'Ya U = Saya', 'D', 'sulit'],
            ['KUCING dalam Bahasa Wemale adalah...', 'Yasu', 'Mau', 'Yane', 'Maupa', 'B', 'sulit'],
            ['BATU dalam Bahasa Wemale adalah...', 'Latu', 'Patu', 'Salipa', 'Tuli ye', 'B', 'sulit'],
            ['SAYA dalam Bahasa Wemale adalah...', 'Wa U', 'Ya U', 'U Leu', 'Ma Uwa', 'B', 'sulit'],
            ['Angka 10 dalam Bahasa Wemale adalah...', 'Siwa', 'Wau', 'Hitu', 'Putusa', 'D', 'sulit'],
        ];

        foreach ($soals as [$pertanyaan, $pilihanA, $pilihanB, $pilihanC, $pilihanD, $kunciJawaban, $tingkatKesulitan]) {
            SoalKuis::updateOrCreate(
                ['pertanyaan' => $pertanyaan],
                [
                    'pilihan_a' => $pilihanA,
                    'pilihan_b' => $pilihanB,
                    'pilihan_c' => $pilihanC,
                    'pilihan_d' => $pilihanD,
                    'kunci_jawaban' => $kunciJawaban,
                    'pembahasan' => null,
                    'tingkat_kesulitan' => $tingkatKesulitan,
                    'is_aktif' => true,
                ]
            );
        }
    }
}
