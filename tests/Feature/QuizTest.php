<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\SoalKuis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $pengunjung;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Kuis',
            'username' => 'admin_kuis',
            'email' => 'admin_kuis@wemale.test',
            'password' => bcrypt('password123'),
            'role' => UserRole::Admin,
        ]);

        $this->pengunjung = User::create([
            'name' => 'Pengunjung Kuis',
            'username' => 'pengunjung_kuis',
            'email' => 'pengunjung_kuis@wemale.test',
            'password' => bcrypt('password123'),
            'role' => UserRole::Pengguna,
        ]);
    }

    /**
     * Admin dapat melihat halaman kelola kuis.
     */
    public function test_admin_can_view_kelola_kuis_page(): void
    {
        SoalKuis::create([
            'pertanyaan' => 'Apa arti kata "Luma"?',
            'pilihan_a' => 'Rumah',
            'pilihan_b' => 'Kebun',
            'pilihan_c' => 'Hutan',
            'pilihan_d' => 'Sungai',
            'kunci_jawaban' => 'A',
            'tingkat_kesulitan' => 'mudah',
            'pembahasan' => 'Luma berarti rumah atau tempat tinggal.',
            'is_aktif' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/kelola-kuis');

        $response->assertStatus(200);
        $response->assertSee('Kelola Kuis Bahasa Wemale');
        $response->assertSee('Daftar Soal Kuis');
        $response->assertSee('Apa arti kata &quot;Luma&quot;?', false);
    }

    /**
     * Admin dapat membuat, memperbarui, dan menghapus soal kuis.
     */
    public function test_admin_can_create_update_and_delete_soal_kuis(): void
    {
        // 1. Create (Store)
        $storeRes = $this->actingAs($this->admin)->post('/admin/kelola-kuis', [
            'pertanyaan' => 'Apa arti kata "Lumau" dalam bahasa Indonesia?',
            'pilihan_a' => 'Rumah Adat',
            'pilihan_b' => 'Batu Keramat',
            'pilihan_c' => 'Perahu Tradisional',
            'pilihan_d' => 'Pohon Beringin',
            'kunci_jawaban' => 'A',
            'tingkat_kesulitan' => 'sedang',
            'pembahasan' => 'Lumau merupakan sebutan untuk rumah adat tradisional suku Wemale.',
            'is_aktif' => 1,
        ]);

        $storeRes->assertRedirect();
        $storeRes->assertSessionHas('success');

        $this->assertDatabaseHas('soal_kuis', [
            'pertanyaan' => 'Apa arti kata "Lumau" dalam bahasa Indonesia?',
            'kunci_jawaban' => 'A',
            'tingkat_kesulitan' => 'sedang',
            'is_aktif' => true,
        ]);

        $soal = SoalKuis::where('pertanyaan', 'Apa arti kata "Lumau" dalam bahasa Indonesia?')->firstOrFail();

        // 2. Update
        $updateRes = $this->actingAs($this->admin)->put('/admin/kelola-kuis/'.$soal->id, [
            'pertanyaan' => 'Apa arti kata "Lumau" menurut tradisi Wemale?',
            'pilihan_a' => 'Rumah Adat / Tempat Tinggal',
            'pilihan_b' => 'Batu Keramat',
            'pilihan_c' => 'Perahu Nelayan',
            'pilihan_d' => 'Pohon Sagu',
            'kunci_jawaban' => 'A',
            'tingkat_kesulitan' => 'mudah',
            'pembahasan' => 'Lumau adalah rumah tempat berlindung dan tempat musyawarah keluarga suku Wemale.',
            'is_aktif' => 1,
        ]);

        $updateRes->assertRedirect();
        $updateRes->assertSessionHas('success');

        $this->assertDatabaseHas('soal_kuis', [
            'id' => $soal->id,
            'pertanyaan' => 'Apa arti kata "Lumau" menurut tradisi Wemale?',
            'tingkat_kesulitan' => 'mudah',
        ]);

        // 3. Destroy (Delete)
        $destroyRes = $this->actingAs($this->admin)->delete('/admin/kelola-kuis/'.$soal->id);

        $destroyRes->assertRedirect();
        $destroyRes->assertSessionHas('success');

        $this->assertDatabaseMissing('soal_kuis', [
            'id' => $soal->id,
        ]);
    }

    /**
     * Pengguna biasa tidak dapat mengakses panel kelola kuis admin dan diarahkan ke login.
     */
    public function test_non_admin_cannot_access_kelola_kuis(): void
    {
        $response = $this->actingAs($this->pengunjung)->get('/admin/kelola-kuis');
        $response->assertRedirect('/login');
    }

    /**
     * Pengunjung terdaftar dapat membuka halaman kuis.
     */
    public function test_registered_visitor_can_view_quiz_page(): void
    {
        SoalKuis::create([
            'pertanyaan' => 'Bagaimana mengucap salam dalam bahasa Wemale?',
            'pilihan_a' => 'Tabea',
            'pilihan_b' => 'Mai',
            'pilihan_c' => 'Sio',
            'pilihan_d' => 'Ale',
            'kunci_jawaban' => 'A',
            'tingkat_kesulitan' => 'mudah',
            'is_aktif' => true,
        ]);

        $response = $this->actingAs($this->pengunjung)->get('/pengunjung/kuis');

        $response->assertStatus(200);
        $response->assertSee('Asah Penguasaan Bahasa Daerah Suku Wemale');
        $response->assertSee('Bagaimana mengucap salam dalam bahasa Wemale?');
    }

    /**
     * Pengunjung belum login diarahkan ke login saat mengakses halaman kuis.
     */
    public function test_guest_is_redirected_to_login_when_accessing_quiz(): void
    {
        $response = $this->get('/pengunjung/kuis');
        $response->assertRedirect('/login');
    }

    /**
     * Pengunjung dapat mengirim jawaban kuis dan mendapatkan evaluasi skor instan.
     */
    public function test_visitor_can_submit_quiz_answers_and_get_results(): void
    {
        $soal1 = SoalKuis::create([
            'pertanyaan' => 'Pertanyaan 1',
            'pilihan_a' => 'Benar',
            'pilihan_b' => 'Salah 1',
            'pilihan_c' => 'Salah 2',
            'pilihan_d' => 'Salah 3',
            'kunci_jawaban' => 'A',
            'tingkat_kesulitan' => 'mudah',
            'pembahasan' => 'Penjelasan 1',
            'is_aktif' => true,
        ]);

        $soal2 = SoalKuis::create([
            'pertanyaan' => 'Pertanyaan 2',
            'pilihan_a' => 'Salah 1',
            'pilihan_b' => 'Benar',
            'pilihan_c' => 'Salah 2',
            'pilihan_d' => 'Salah 3',
            'kunci_jawaban' => 'B',
            'tingkat_kesulitan' => 'sedang',
            'pembahasan' => 'Penjelasan 2',
            'is_aktif' => true,
        ]);

        // Jawab soal 1 benar (A), soal 2 salah (C)
        $response = $this->actingAs($this->pengunjung)->postJson('/pengunjung/kuis/submit', [
            'jawaban' => [
                $soal1->id => 'A',
                $soal2->id => 'C',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'skor' => 50,
            'total_soal' => 2,
            'jawaban_benar' => 1,
        ]);

        // Memastikan tersimpan di riwayat kuis
        $this->assertDatabaseHas('riwayat_kuis', [
            'user_id' => $this->pengunjung->id,
            'total_soal' => 2,
            'jawaban_benar' => 1,
            'skor' => 50,
        ]);
    }
}
