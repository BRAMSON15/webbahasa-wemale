<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalKuis extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'soal_kuis';

    /** @var array<int, string> */
    protected $fillable = [
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'kunci_jawaban',
        'pembahasan',
        'tingkat_kesulitan',
        'is_aktif',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'is_aktif' => 'boolean',
    ];
}
