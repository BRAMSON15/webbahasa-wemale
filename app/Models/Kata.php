<?php

namespace App\Models;

use Database\Factories\KataFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kata extends Model
{
    /** @use HasFactory<KataFactory> */
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'kata_wemale',
        'arti_indonesia',
        'contoh',
        'terjemahan_contoh',
        'kategori_id',
        'is_populer',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'is_populer' => 'boolean',
    ];

    /**
     * Kategori dari kata ini.
     *
     * @return BelongsTo<Kategori, $this>
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Scope untuk kata yang ditandai populer.
     *
     * @param  Builder<Kata>  $query
     */
    public function scopePopuler(Builder $query): Builder
    {
        return $query->where('is_populer', true);
    }

    /**
     * Scope pencarian kata berdasarkan kata Wemale atau arti Indonesia.
     *
     * @param  Builder<Kata>  $query
     */
    public function scopeCari(Builder $query, string $kata): Builder
    {
        $term = '%'.$kata.'%';

        return $query->where('kata_wemale', 'like', $term)
            ->orWhere('arti_indonesia', 'like', $term);
    }
}
