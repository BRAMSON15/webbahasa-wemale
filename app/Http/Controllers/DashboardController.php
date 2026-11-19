<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Kata;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik dan aktivitas terbaru.
     */
    public function index(): View
    {
        $totalKata = Kata::count();
        $totalPengguna = User::count();
        $totalKategori = Kategori::count();
        $tingkatAkses = $this->hitungTingkatAkses();

        $aktivitasTerbaru = Aktivitas::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $statistikHarian = $this->statistikPencarianHarian();

        return view('admin.dashboard', [
            'totalKata' => $totalKata,
            'totalPengguna' => $totalPengguna,
            'totalKategori' => $totalKategori,
            'tingkatAkses' => $tingkatAkses,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'statistikHarian' => $statistikHarian,
        ]);
    }

    /**
     * Tampilkan halaman kelola kosakata kamus.
     */
    public function kelolaKamus(): View
    {
        $totalKata = Kata::count();
        $totalPopuler = Kata::where('is_populer', true)->count();
        $totalKategori = Kategori::count();

        $daftarKata = Kata::with('kategori')
            ->orderBy('kata_wemale', 'asc')
            ->get();

        $kategoriList = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('admin.menu-sidebar.kelola-kamus', [
            'totalKata' => $totalKata,
            'totalPopuler' => $totalPopuler,
            'totalKategori' => $totalKategori,
            'katas' => $daftarKata,
            'daftarKata' => $daftarKata,
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Tampilkan halaman kelola kategori kosakata.
     */
    public function kelolaKategori(): View
    {
        $totalKategori = Kategori::count();
        $kategoriTerbanyak = Kategori::withCount('katas')
            ->orderByDesc('katas_count')
            ->first();

        $kategoris = Kategori::withCount('katas')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('admin.menu-sidebar.kelola-kategori', [
            'totalKategori' => $totalKategori,
            'kategoriTerbanyak' => $kategoriTerbanyak,
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Tampilkan halaman kelola pengguna dan hak akses.
     */
    public function kelolaPengguna(): View
    {
        $totalPengguna = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $users = User::latest()->get();

        return view('admin.menu-sidebar.kelola-pengguna', [
            'totalPengguna' => $totalPengguna,
            'totalAdmin' => $totalAdmin,
            'users' => $users,
        ]);
    }

    /**
     * Tampilkan halaman informasi dan profil website.
     */
    public function informasiWebsite(): View
    {
        return view('admin.menu-sidebar.informasi-website');
    }

    /**
     * Tampilkan halaman laporan dan analitik penggunaan kamus.
     */
    public function laporan(): View
    {
        $aktivitasTerbaru = Aktivitas::with('user')
            ->latest()
            ->limit(15)
            ->get();

        return view('admin.menu-sidebar.laporan', [
            'aktivitasTerbaru' => $aktivitasTerbaru,
        ]);
    }

    /**
     * Tampilkan halaman pengaturan akun administrator dan konfigurasi sistem.
     */
    public function pengaturan(): View
    {
        return view('admin.menu-sidebar.pengaturan');
    }

    /**
     * Hitung tingkat akses berdasarkan rasio pengguna aktif terhadap total pengguna.
     */
    private function hitungTingkatAkses(): float
    {
        $totalPengguna = User::count();

        if ($totalPengguna === 0) {
            return 0.0;
        }

        $penggunaAktif = User::whereNotNull('email_verified_at')->count();
        $rasio = ($penggunaAktif / $totalPengguna) * 100;

        return round($rasio, 1);
    }

    /**
     * Statistik aktivitas harian untuk grafik dashboard (7 hari terakhir).
     *
     * @return array<int, array{label: string, nilai: int}>
     */
    private function statistikPencarianHarian(): array
    {
        $hari = ['Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min', 'Sen'];

        $aktivitasPerHari = Aktivitas::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('tanggal')
            ->pluck('jumlah', 'tanggal')
            ->mapWithKeys(fn ($jumlah, $tanggal) => [$tanggal => $jumlah])
            ->toArray();

        $statistik = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->toDateString();
            $indeksHari = (now()->subDays($i)->dayOfWeekIso - 1) % 7;

            $statistik[] = [
                'label' => $hari[$indeksHari],
                'nilai' => $aktivitasPerHari[$tanggal] ?? 0,
            ];
        }

        return $statistik;
    }
}
