<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Kata;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Utama',
            'username' => 'admin_crud',
            'email' => 'admin_crud@wemale.test',
            'password' => bcrypt('password123'),
            'role' => UserRole::Admin,
        ]);
    }

    /**
     * Test CRUD Kata (Kosakata Wemale).
     */
    public function test_admin_can_create_update_and_delete_kata(): void
    {
        $kategori = Kategori::create([
            'nama_kategori' => 'Kata Benda',
            'deskripsi' => 'Rumpun kata benda',
        ]);

        // 1. Create (Store)
        $resStore = $this->actingAs($this->admin)->post('/admin/kelola-kamus', [
            'kata_wemale' => 'Luma',
            'arti_indonesia' => 'Rumah',
            'kategori_id' => $kategori->id,
            'contoh' => 'Luma meita',
            'terjemahan_contoh' => 'Rumah besar',
            'is_populer' => 1,
        ]);

        $resStore->assertRedirect();
        $resStore->assertSessionHas('success');

        $this->assertDatabaseHas('katas', [
            'kata_wemale' => 'Luma',
            'arti_indonesia' => 'Rumah',
            'is_populer' => true,
        ]);

        $kata = Kata::where('kata_wemale', 'Luma')->firstOrFail();

        // 2. Update
        $resUpdate = $this->actingAs($this->admin)->put("/admin/kelola-kamus/{$kata->id}", [
            'kata_wemale' => 'Luma Adat',
            'arti_indonesia' => 'Rumah Adat',
            'kategori_id' => $kategori->id,
            'contoh' => 'Luma adat hena',
            'terjemahan_contoh' => 'Rumah adat kami',
            'is_populer' => 0,
        ]);

        $resUpdate->assertRedirect();
        $resUpdate->assertSessionHas('success');

        $this->assertDatabaseHas('katas', [
            'id' => $kata->id,
            'kata_wemale' => 'Luma Adat',
            'arti_indonesia' => 'Rumah Adat',
            'is_populer' => false,
        ]);

        // 3. Delete (Destroy)
        $resDelete = $this->actingAs($this->admin)->delete("/admin/kelola-kamus/{$kata->id}");

        $resDelete->assertRedirect();
        $resDelete->assertSessionHas('success');
        $this->assertDatabaseMissing('katas', ['id' => $kata->id]);
    }

    /**
     * Test CRUD Kategori Kosakata.
     */
    public function test_admin_can_create_update_and_delete_kategori(): void
    {
        // 1. Create (Store)
        $resStore = $this->actingAs($this->admin)->post('/admin/kelola-kategori', [
            'nama_kategori' => 'Ungkapan Adat',
            'deskripsi' => 'Ungkapan tuturan para tetua adat',
        ]);

        $resStore->assertRedirect();
        $resStore->assertSessionHas('success');

        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Ungkapan Adat',
            'slug' => 'ungkapan-adat',
        ]);

        $kategori = Kategori::where('nama_kategori', 'Ungkapan Adat')->firstOrFail();

        // 2. Update
        $resUpdate = $this->actingAs($this->admin)->put("/admin/kelola-kategori/{$kategori->id}", [
            'nama_kategori' => 'Tradisi & Adat',
            'deskripsi' => 'Rumpun tradisi dan upacara adat',
        ]);

        $resUpdate->assertRedirect();
        $resUpdate->assertSessionHas('success');

        $this->assertDatabaseHas('kategoris', [
            'id' => $kategori->id,
            'nama_kategori' => 'Tradisi & Adat',
            'slug' => 'tradisi-adat',
        ]);

        // 3. Delete (Destroy)
        $resDelete = $this->actingAs($this->admin)->delete("/admin/kelola-kategori/{$kategori->id}");

        $resDelete->assertRedirect();
        $resDelete->assertSessionHas('success');
        $this->assertDatabaseMissing('kategoris', ['id' => $kategori->id]);
    }

    /**
     * Test CRUD Pengguna (Users).
     */
    public function test_admin_can_create_update_and_delete_user(): void
    {
        // 1. Create (Store)
        $resStore = $this->actingAs($this->admin)->post('/admin/kelola-pengguna', [
            'name' => 'Budi Peneliti',
            'email' => 'budi@peneliti.test',
            'role' => 'peneliti',
            'password' => 'secret123',
        ]);

        $resStore->assertRedirect();
        $resStore->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Budi Peneliti',
            'email' => 'budi@peneliti.test',
            'role' => 'peneliti',
        ]);

        $user = User::where('email', 'budi@peneliti.test')->firstOrFail();

        // 2. Update
        $resUpdate = $this->actingAs($this->admin)->put("/admin/kelola-pengguna/{$user->id}", [
            'name' => 'Budi Peneliti Senior',
            'email' => 'budi_senior@peneliti.test',
            'role' => 'kontributor',
        ]);

        $resUpdate->assertRedirect();
        $resUpdate->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Budi Peneliti Senior',
            'email' => 'budi_senior@peneliti.test',
            'role' => 'kontributor',
        ]);

        // 3. Delete (Destroy)
        $resDelete = $this->actingAs($this->admin)->delete("/admin/kelola-pengguna/{$user->id}");

        $resDelete->assertRedirect();
        $resDelete->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        // 4. Admin cannot delete self
        $resSelfDelete = $this->actingAs($this->admin)->delete("/admin/kelola-pengguna/{$this->admin->id}");
        $resSelfDelete->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    /**
     * Test Admin Settings & Profile update.
     */
    public function test_admin_can_update_profile_password_and_system(): void
    {
        // 1. Update Profile
        $resProfile = $this->actingAs($this->admin)->put('/admin/pengaturan/profil', [
            'name' => 'Admin Baru',
            'username' => 'admin_baru',
            'email' => 'baru@wemale.test',
        ]);

        $resProfile->assertRedirect();
        $resProfile->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'name' => 'Admin Baru',
            'username' => 'admin_baru',
            'email' => 'baru@wemale.test',
        ]);

        // 2. Update Password
        $resPass = $this->actingAs($this->admin)->put('/admin/pengaturan/password', [
            'current_password' => 'password123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $resPass->assertRedirect();
        $resPass->assertSessionHas('success');

        $this->admin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $this->admin->password));

        // 3. Update System Configuration
        $resSistem = $this->actingAs($this->admin)->post('/admin/pengaturan/sistem', [
            'pencarian_terbuka' => 1,
            'moderasi_kata' => 1,
        ]);

        $resSistem->assertRedirect();
        $resSistem->assertSessionHas('success');
    }

    /**
     * Test Informasi Website update.
     */
    public function test_admin_can_update_informasi_website(): void
    {
        $res = $this->actingAs($this->admin)->post('/admin/informasi-website', [
            'nama_platform' => 'Kamus Besar Bahasa Suku Wemale',
            'slogan' => 'Melestarikan Budaya Seram',
            'deskripsi' => 'Deskripsi platform baru',
            'visi' => 'Visi baru',
            'misi' => 'Misi baru',
        ]);

        $res->assertRedirect();
        $res->assertSessionHas('success');
    }
}
