<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKuis extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'riwayat_kuis';

    /** @var array<int, string> */
    protected $fillable = [
        'user_id',
        'total_soal',
        'jawaban_benar',
        'skor',
    ];

    /**
     * User yang mengerjakan kuis.
     *
     * @return BelongsTo<User, $this>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
