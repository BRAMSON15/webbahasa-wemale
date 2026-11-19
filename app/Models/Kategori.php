<?php

namespace App\Models;

use Database\Factories\KategoriFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Kategori extends Model
{
    /** @use HasFactory<KategoriFactory> */
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = ['nama_kategori', 'slug', 'deskripsi'];

    /**
     * Boot the model and generate slug automatically.
     */
    protected static function booted(): void
    {
        static::creating(function (Kategori $kategori) {
            $kategori->slug ??= Str::slug($kategori->nama_kategori);
        });

        static::updating(function (Kategori $kategori) {
            if ($kategori->isDirty('nama_kategori') && ! $kategori->isDirty('slug')) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });
    }

    /**
     * Daftar kata yang termasuk dalam kategori ini.
     *
     * @return HasMany<Kata, $this>
     */
    public function katas()
    {
        return $this->hasMany(Kata::class);
    }
}
