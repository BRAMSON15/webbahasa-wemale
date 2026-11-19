<?php

namespace App\Models;

use Database\Factories\AktivitasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktivitas extends Model
{
    /** @use HasFactory<AktivitasFactory> */
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['user_id', 'tipe', 'deskripsi'];

    /**
     * Pengguna yang melakukan aktivitas.
     *
     * @return BelongsTo<User, $this>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
