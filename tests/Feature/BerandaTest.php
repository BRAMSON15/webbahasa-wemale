<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Kata;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BerandaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that beranda loads successfully and displays key content.
     */
    public function test_beranda_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Kamus Bahasa Suku Wemale');
        $response->assertSee('Kata Populer');
        $response->assertSee('Cari Kata');
        $response->assertSee('Koleksi Istilah');
        $response->assertSee('Tentang Kamus');
        $response->assertSee('Cara Menggunakan Kamus');
        $response->assertSee('Ada kosakata yang ingin ditambahkan?');
    }

    public function test_help_and_contact_navigation_render_valid_targets_and_routes(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee('id="bantuan"', false);
        $response->assertSee('id="kontak"', false);
        $response->assertSee('href="#bantuan"', false);
        $response->assertSee('href="#kontak"', false);
        $response->assertSee('href="'.route('login').'"', false);
        $response->assertSee('href="'.route('register').'"', false);
    }

    /**
     * Test alternative routes for homepage.
     */
    public function test_beranda_alternate_routes(): void
    {
        $this->get('/beranda')->assertStatus(200);
        $this->get('/halamanutama')->assertStatus(200);
    }

    /**
     * Test search endpoint returns JSON.
     */
    public function test_cari_endpoint_returns_json(): void
    {
        Kata::create([
            'kata_wemale' => 'Mama',
            'arti_indonesia' => 'Ibu',
            'is_populer' => true,
        ]);

        $response = $this->getJson('/cari?q=Mama');

        $response->assertStatus(200);
        $response->assertJsonPath('total', 1);
        $response->assertJsonPath('hasil.0.kata', 'Mama');
    }

    /**
     * Test that public login page is accessible and shows visitor login.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login Pengunjung');
        $response->assertDontSee('Login Admin');
        $response->assertSee('login-left-clean.png');
        $response->assertSee('Selamat Datang di Kamus Bahasa Wemale');
        $response->assertSee('Kembali ke Beranda');
    }

    /**
     * Test dedicated visitor login route.
     */
    public function test_dedicated_pengunjung_login_route_is_accessible(): void
    {
        $response = $this->get('/login/pengunjung');

        $response->assertStatus(200);
        $response->assertSee('Login Pengunjung');
        $response->assertSee('Selamat Datang di Kamus Bahasa Wemale');
    }

    /**
     * Test dedicated admin login route.
     */
    public function test_dedicated_admin_login_route_is_accessible(): void
    {
        $response = $this->get('/login/admin');

        $response->assertStatus(200);
        $response->assertSee('Login Admin');
        $response->assertSee('Selamat Datang di Panel Admin');
    }

    /**
     * Test that register page is accessible.
     */
    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun');
        $response->assertSee('register-left-clean.png');
        $response->assertSee('Bergabung Bersama Kami');
        $response->assertSee('Daftar Sekarang');
        $response->assertSee('Daftar dengan Google');
        $response->assertSee('Sudah punya akun?');
    }

    /**
     * Test that unauthenticated user is redirected from admin dashboard.
     */
    public function test_admin_dashboard_requires_authentication(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated admin can access admin dashboard.
     */
    public function test_admin_dashboard_page_is_accessible_for_admin(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@wemale.test',
            'password' => bcrypt('password'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin');
        $response->assertSee('Selamat Datang, Admin!');
        $response->assertSee('sidebar-logo.png');
        $response->assertSee('dashboard-banner.png');
        $response->assertDontSee('brightness-0 invert');
        $response->assertSee('Statistik Penggunaan Kamus');
        $response->assertSee('Aktivitas Terbaru');
    }

    /**
     * Test that all sidebar menu pages in admin panel are accessible for admin.
     */
    public function test_admin_sidebar_menu_pages_are_accessible_for_admin(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin_menu',
            'email' => 'admin_menu@wemale.test',
            'password' => bcrypt('password'),
            'role' => UserRole::Admin,
        ]);

        // 1. Kelola Kamus
        $resKamus = $this->actingAs($admin)->get('/admin/kelola-kamus');
        $resKamus->assertStatus(200);
        $resKamus->assertSee('Kelola Kamus Bahasa Suku Wemale');
        $resKamus->assertSee('Daftar Kosakata');

        // 2. Kelola Kategori
        $resKategori = $this->actingAs($admin)->get('/admin/kelola-kategori');
        $resKategori->assertStatus(200);
        $resKategori->assertSee('Kelola Kategori Kosakata');
        $resKategori->assertSee('Daftar Kategori Kamus');

        // 3. Kelola Kuis
        $resKuis = $this->actingAs($admin)->get('/admin/kelola-kuis');
        $resKuis->assertStatus(200);
        $resKuis->assertSee('Kelola Kuis Bahasa Wemale');
        $resKuis->assertSee('Daftar Soal Kuis');

        // 4. Kelola Pengguna
        $resPengguna = $this->actingAs($admin)->get('/admin/kelola-pengguna');
        $resPengguna->assertStatus(200);
        $resPengguna->assertSee('Kelola Pengguna & Hak Akses');
        $resPengguna->assertSee('Daftar Akun Pengguna');

        // 4. Informasi Website
        $resInfo = $this->actingAs($admin)->get('/admin/informasi-website');
        $resInfo->assertStatus(200);
        $resInfo->assertSee('Informasi & Profil Website');
        $resInfo->assertSee('Identitas Utama Website');

        // 5. Laporan
        $resLaporan = $this->actingAs($admin)->get('/admin/laporan');
        $resLaporan->assertStatus(200);
        $resLaporan->assertSee('Laporan & Analitik Penggunaan Kamus');
        $resLaporan->assertSee('Total Pencarian Kata');

        // 6. Pengaturan
        $resPengaturan = $this->actingAs($admin)->get('/admin/pengaturan');
        $resPengaturan->assertStatus(200);
        $resPengaturan->assertSee('Pengaturan Akun & Sistem');
        $resPengaturan->assertSee('Profil Administrator');
    }

    /**
     * Test that guest is redirected from beranda pengunjung to login.
     */
    public function test_beranda_pengunjung_requires_authentication(): void
    {
        $response = $this->get('/pengunjung/beranda');
        $response->assertRedirect('/login');
    }

    /**
     * Test registered visitor login redirects to beranda pengunjung.
     */
    public function test_registered_visitor_login_redirects_to_beranda_pengunjung(): void
    {
        $pengunjung = User::create([
            'name' => 'Wemale Visitor',
            'username' => 'wemale_visitor',
            'email' => 'visitor@wemale.test',
            'password' => bcrypt('secret123'),
            'role' => UserRole::Pelajar,
        ]);

        $response = $this->post('/login', [
            'username' => 'visitor@wemale.test',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/pengunjung/beranda');
        $this->assertAuthenticatedAs($pengunjung);
    }

    /**
     * Test admin login redirects to admin dashboard.
     */
    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin Officer',
            'username' => 'admin_officer',
            'email' => 'officer@wemale.test',
            'password' => bcrypt('adminsecret'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->post('/login', [
            'username' => 'admin_officer',
            'password' => 'adminsecret',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * Test that beranda pengunjung loads properly for authenticated visitor.
     */
    public function test_beranda_pengunjung_loads_properly_for_authenticated_visitor(): void
    {
        $pengunjung = User::create([
            'name' => 'Siti Wemale',
            'username' => 'siti_wemale',
            'email' => 'siti@wemale.test',
            'password' => bcrypt('password'),
            'role' => UserRole::Pelajar,
        ]);

        Kata::create([
            'kata_wemale' => 'Leko',
            'arti_indonesia' => 'Daun',
            'contoh' => 'Leko maso',
            'terjemahan_contoh' => 'Daun hijau',
            'is_populer' => true,
        ]);

        $response = $this->actingAs($pengunjung)->get('/pengunjung/beranda');

        $response->assertStatus(200);
        $response->assertSee('Siti Wemale');
        $response->assertSee('Kamus Bahasa');
        $response->assertSee('Suku Wemale');
        $response->assertSee('Pelajar');
        $response->assertSee('Leko');
        $response->assertSee('Kata Populer');
        $response->assertSee('Favorit Saya');
    }

    /**
     * Test that visitor can submit word contribution via endpoint.
     */
    public function test_visitor_can_submit_word_contribution(): void
    {
        $pengunjung = User::create([
            'name' => 'Kontributor Adat',
            'username' => 'kontributor_adat',
            'email' => 'kontri@wemale.test',
            'password' => bcrypt('password'),
            'role' => UserRole::Kontributor,
        ]);

        $response = $this->actingAs($pengunjung)->postJson('/pengunjung/usulkan-kata', [
            'kata_wemale' => 'Ina',
            'arti_indonesia' => 'Ibu Kandung',
            'contoh' => 'Ina mai',
            'terjemahan_contoh' => 'Ibu datang',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('aktivitas', [
            'user_id' => $pengunjung->id,
            'tipe' => 'kontribusi',
        ]);
    }
}
