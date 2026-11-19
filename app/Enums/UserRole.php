<?php

namespace App\Enums;

/**
 * Peran pengguna dalam sistem Kamus Bahasa Suku Wemale.
 *
 * Admin mengelola seluruh data kamus melalui panel dashboard,
 * sedangkan peran lainnya merupakan pengguna terdaftar yang
 * mendaftar melalui halaman registrasi.
 */
enum UserRole: string
{
    case Admin = 'admin';
    case Pengguna = 'pengguna';
    case Pelajar = 'pelajar';
    case Peneliti = 'peneliti';
    case Kontributor = 'kontributor';

    /**
     * Daftar peran yang dapat dipilih saat registrasi.
     *
     * @return array<string, string>
     */
    public static function registrationOptions(): array
    {
        return [
            self::Pengguna->value => 'Pengguna Umum / Masyarakat',
            self::Pelajar->value => 'Pelajar / Mahasiswa',
            self::Peneliti->value => 'Peneliti / Akademisi Budaya',
            self::Kontributor->value => 'Kontributor Kosakata Adat',
        ];
    }

    /**
     * Label tampilan untuk peran.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Pengguna => 'Pengguna Umum',
            self::Pelajar => 'Pelajar',
            self::Peneliti => 'Peneliti',
            self::Kontributor => 'Kontributor',
        };
    }
}
