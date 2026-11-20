<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Aktivitas;
use App\Models\Kata;
use App\Models\Kategori;
use App\Models\RiwayatKuis;
use App\Models\SoalKuis;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $penambahanBulanIni = Kata::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $daftarKata = Kata::with('kategori')
            ->orderBy('kata_wemale', 'asc')
            ->get();

        $kategoriList = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('admin.menu-sidebar.kelola-kamus', [
            'totalKata' => $totalKata,
            'totalPopuler' => $totalPopuler,
            'totalKategori' => $totalKategori,
            'penambahanBulanIni' => $penambahanBulanIni,
            'katas' => $daftarKata,
            'daftarKata' => $daftarKata,
            'kategoris' => $kategoriList,
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Simpan kosakata baru ke database.
     */
    public function storeKata(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kata_wemale' => ['required', 'string', 'max:255'],
            'arti_indonesia' => ['required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'exists:kategoris,id'],
            'contoh' => ['nullable', 'string', 'max:500'],
            'terjemahan_contoh' => ['nullable', 'string', 'max:500'],
            'is_populer' => ['nullable', 'boolean'],
        ], [
            'kata_wemale.required' => 'Kosakata Bahasa Wemale wajib diisi.',
            'arti_indonesia.required' => 'Arti Bahasa Indonesia wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        $kata = Kata::create([
            'kata_wemale' => $validated['kata_wemale'],
            'arti_indonesia' => $validated['arti_indonesia'],
            'kategori_id' => $validated['kategori_id'] ?? null,
            'contoh' => $validated['contoh'] ?? null,
            'terjemahan_contoh' => $validated['terjemahan_contoh'] ?? null,
            'is_populer' => $request->boolean('is_populer'),
        ]);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'tambah',
            'deskripsi' => 'Menambahkan kosakata baru: "'.$kata->kata_wemale.'" ('.$kata->arti_indonesia.').',
        ]);

        return back()->with('success', 'Kosakata "'.$kata->kata_wemale.'" berhasil ditambahkan ke kamus.');
    }

    /**
     * Perbarui data kosakata yang ada.
     */
    public function updateKata(Request $request, Kata $kata): RedirectResponse
    {
        $validated = $request->validate([
            'kata_wemale' => ['required', 'string', 'max:255'],
            'arti_indonesia' => ['required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'exists:kategoris,id'],
            'contoh' => ['nullable', 'string', 'max:500'],
            'terjemahan_contoh' => ['nullable', 'string', 'max:500'],
            'is_populer' => ['nullable', 'boolean'],
        ], [
            'kata_wemale.required' => 'Kosakata Bahasa Wemale wajib diisi.',
            'arti_indonesia.required' => 'Arti Bahasa Indonesia wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        $kata->update([
            'kata_wemale' => $validated['kata_wemale'],
            'arti_indonesia' => $validated['arti_indonesia'],
            'kategori_id' => $validated['kategori_id'] ?? null,
            'contoh' => $validated['contoh'] ?? null,
            'terjemahan_contoh' => $validated['terjemahan_contoh'] ?? null,
            'is_populer' => $request->boolean('is_populer'),
        ]);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'ubah',
            'deskripsi' => 'Memperbarui data kosakata: "'.$kata->kata_wemale.'".',
        ]);

        return back()->with('success', 'Kosakata "'.$kata->kata_wemale.'" berhasil diperbarui.');
    }

    /**
     * Hapus kosakata dari kamus.
     */
    public function destroyKata(Kata $kata): RedirectResponse
    {
        $namaKata = $kata->kata_wemale;
        $kata->delete();

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'hapus',
            'deskripsi' => 'Menghapus kosakata: "'.$namaKata.'" dari kamus.',
        ]);

        return back()->with('success', 'Kosakata "'.$namaKata.'" berhasil dihapus.');
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

        $kategoriTerisi = Kategori::has('katas')->count();
        $persenTerisi = $totalKategori > 0 ? round(($kategoriTerisi / $totalKategori) * 100) : 0;

        return view('admin.menu-sidebar.kelola-kategori', [
            'totalKategori' => $totalKategori,
            'kategoriTerbanyak' => $kategoriTerbanyak,
            'kategoris' => $kategoris,
            'persenTerisi' => $persenTerisi,
        ]);
    }

    /**
     * Simpan kategori kosakata baru.
     */
    public function storeKategori(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategoris,nama_kategori'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori ini sudah terdaftar.',
        ]);

        $kategori = Kategori::create($validated);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'tambah',
            'deskripsi' => 'Menambahkan kategori kosakata baru: "'.$kategori->nama_kategori.'".',
        ]);

        return back()->with('success', 'Kategori "'.$kategori->nama_kategori.'" berhasil ditambahkan.');
    }

    /**
     * Perbarui data kategori kosakata.
     */
    public function updateKategori(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategoris', 'nama_kategori')->ignore($kategori->id)],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori ini sudah digunakan oleh kategori lain.',
        ]);

        $kategori->update($validated);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'ubah',
            'deskripsi' => 'Memperbarui kategori kosakata: "'.$kategori->nama_kategori.'".',
        ]);

        return back()->with('success', 'Kategori "'.$kategori->nama_kategori.'" berhasil diperbarui.');
    }

    /**
     * Hapus kategori kosakata.
     */
    public function destroyKategori(Kategori $kategori): RedirectResponse
    {
        $namaKategori = $kategori->nama_kategori;

        // Lepas referensi kategori pada kata-kata terkait
        $kategori->katas()->update(['kategori_id' => null]);
        $kategori->delete();

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'hapus',
            'deskripsi' => 'Menghapus kategori: "'.$namaKategori.'".',
        ]);

        return back()->with('success', 'Kategori "'.$namaKategori.'" berhasil dihapus.');
    }

    /**
     * Tampilkan halaman kelola pengguna dan hak akses.
     */
    public function kelolaPengguna(): View
    {
        $totalPengguna = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPenggunaUmum = User::where('role', '!=', 'admin')->count();
        $users = User::latest()->get();

        return view('admin.menu-sidebar.kelola-pengguna', [
            'totalPengguna' => $totalPengguna,
            'totalAdmin' => $totalAdmin,
            'totalPenggunaUmum' => $totalPenggunaUmum,
            'users' => $users,
        ]);
    }

    /**
     * Tambah akun pengguna baru oleh admin.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', Rule::in(['admin', 'pengguna', 'pelajar', 'peneliti', 'kontributor'])],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $usernameBase = explode('@', $validated['email'])[0];
        $username = $usernameBase;
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $usernameBase.$i++;
        }

        $user = User::create([
            'name' => $validated['name'],
            'username' => $username,
            'email' => $validated['email'],
            'role' => UserRole::from($validated['role']),
            'password' => $validated['password'],
        ]);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'tambah',
            'deskripsi' => 'Membuat akun pengguna baru: "'.$user->name.'" ('.$user->role->label().').',
        ]);

        return back()->with('success', 'Pengguna "'.$user->name.'" berhasil ditambahkan.');
    }

    /**
     * Perbarui data atau peran akun pengguna.
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'pengguna', 'pelajar', 'peneliti', 'kontributor'])],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email sudah digunakan pengguna lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => UserRole::from($validated['role']),
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $user->update($updateData);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'ubah',
            'deskripsi' => 'Memperbarui profil & peran pengguna: "'.$user->name.'".',
        ]);

        return back()->with('success', 'Data pengguna "'.$user->name.'" berhasil diperbarui.');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $namaUser = $user->name;
        $user->delete();

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'hapus',
            'deskripsi' => 'Menghapus akun pengguna: "'.$namaUser.'".',
        ]);

        return back()->with('success', 'Akun pengguna "'.$namaUser.'" berhasil dihapus.');
    }

    /**
     * Tampilkan halaman kelola soal kuis bahasa Wemale.
     */
    public function kelolaKuis(): View
    {
        $soalList = SoalKuis::latest()->get();
        $totalSoal = SoalKuis::count();
        $totalAktif = SoalKuis::where('is_aktif', true)->count();
        $totalRiwayat = RiwayatKuis::count();
        $rataSkor = $totalRiwayat > 0 ? round(RiwayatKuis::avg('skor') ?? 0, 1) : 0;

        return view('admin.menu-sidebar.kelola-kuis', [
            'soalList' => $soalList,
            'totalSoal' => $totalSoal,
            'totalAktif' => $totalAktif,
            'totalRiwayat' => $totalRiwayat,
            'rataSkor' => $rataSkor,
        ]);
    }

    /**
     * Simpan soal kuis baru ke database.
     */
    public function storeSoalKuis(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pertanyaan' => ['required', 'string'],
            'pilihan_a' => ['required', 'string', 'max:255'],
            'pilihan_b' => ['required', 'string', 'max:255'],
            'pilihan_c' => ['required', 'string', 'max:255'],
            'pilihan_d' => ['required', 'string', 'max:255'],
            'kunci_jawaban' => ['required', 'string', 'in:A,B,C,D'],
            'tingkat_kesulitan' => ['required', 'string', 'in:mudah,sedang,sulit'],
            'pembahasan' => ['nullable', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ], [
            'pertanyaan.required' => 'Pertanyaan kuis wajib diisi.',
            'pilihan_a.required' => 'Pilihan A wajib diisi.',
            'pilihan_b.required' => 'Pilihan B wajib diisi.',
            'pilihan_c.required' => 'Pilihan C wajib diisi.',
            'pilihan_d.required' => 'Pilihan D wajib diisi.',
            'kunci_jawaban.required' => 'Kunci jawaban wajib dipilih.',
            'tingkat_kesulitan.required' => 'Tingkat kesulitan wajib dipilih.',
        ]);

        $soal = SoalKuis::create([
            'pertanyaan' => $validated['pertanyaan'],
            'pilihan_a' => $validated['pilihan_a'],
            'pilihan_b' => $validated['pilihan_b'],
            'pilihan_c' => $validated['pilihan_c'],
            'pilihan_d' => $validated['pilihan_d'],
            'kunci_jawaban' => strtoupper($validated['kunci_jawaban']),
            'tingkat_kesulitan' => $validated['tingkat_kesulitan'],
            'pembahasan' => $validated['pembahasan'] ?? null,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'tambah',
            'deskripsi' => 'Menambahkan soal kuis baru: "'.$soal->pertanyaan.'".',
        ]);

        return back()->with('success', 'Soal kuis baru berhasil ditambahkan.');
    }

    /**
     * Perbarui data soal kuis.
     */
    public function updateSoalKuis(Request $request, SoalKuis $soalKuis): RedirectResponse
    {
        $validated = $request->validate([
            'pertanyaan' => ['required', 'string'],
            'pilihan_a' => ['required', 'string', 'max:255'],
            'pilihan_b' => ['required', 'string', 'max:255'],
            'pilihan_c' => ['required', 'string', 'max:255'],
            'pilihan_d' => ['required', 'string', 'max:255'],
            'kunci_jawaban' => ['required', 'string', 'in:A,B,C,D'],
            'tingkat_kesulitan' => ['required', 'string', 'in:mudah,sedang,sulit'],
            'pembahasan' => ['nullable', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ], [
            'pertanyaan.required' => 'Pertanyaan kuis wajib diisi.',
            'pilihan_a.required' => 'Pilihan A wajib diisi.',
            'pilihan_b.required' => 'Pilihan B wajib diisi.',
            'pilihan_c.required' => 'Pilihan C wajib diisi.',
            'pilihan_d.required' => 'Pilihan D wajib diisi.',
            'kunci_jawaban.required' => 'Kunci jawaban wajib dipilih.',
            'tingkat_kesulitan.required' => 'Tingkat kesulitan wajib dipilih.',
        ]);

        $soalKuis->update([
            'pertanyaan' => $validated['pertanyaan'],
            'pilihan_a' => $validated['pilihan_a'],
            'pilihan_b' => $validated['pilihan_b'],
            'pilihan_c' => $validated['pilihan_c'],
            'pilihan_d' => $validated['pilihan_d'],
            'kunci_jawaban' => strtoupper($validated['kunci_jawaban']),
            'tingkat_kesulitan' => $validated['tingkat_kesulitan'],
            'pembahasan' => $validated['pembahasan'] ?? null,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'ubah',
            'deskripsi' => 'Memperbarui soal kuis: "'.$soalKuis->pertanyaan.'".',
        ]);

        return back()->with('success', 'Soal kuis berhasil diperbarui.');
    }

    /**
     * Hapus soal kuis.
     */
    public function destroySoalKuis(SoalKuis $soalKuis): RedirectResponse
    {
        $pertanyaan = $soalKuis->pertanyaan;
        $soalKuis->delete();

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'hapus',
            'deskripsi' => 'Menghapus soal kuis: "'.$pertanyaan.'".',
        ]);

        return back()->with('success', 'Soal kuis berhasil dihapus.');
    }

    /**
     * Tampilkan halaman informasi dan profil website.
     */
    public function informasiWebsite(): View
    {
        return view('admin.menu-sidebar.informasi-website');
    }

    /**
     * Simpan pembaruan informasi website.
     */
    public function updateInformasiWebsite(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_platform' => ['required', 'string', 'max:255'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'visi' => ['nullable', 'string', 'max:1000'],
            'misi' => ['nullable', 'string', 'max:1000'],
        ]);

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'ubah',
            'deskripsi' => 'Memperbarui identitas dan informasi website Kamus Bahasa Suku Wemale.',
        ]);

        return back()->with('success', 'Informasi website dan visi misi berhasil diperbarui.');
    }

    /**
     * Tampilkan halaman laporan dan analitik penggunaan kamus.
     */
    public function laporan(): View
    {
        $totalAktivitas = Aktivitas::count();
        $totalKata = Kata::count();
        $kataPopulerTeratas = Kata::where('is_populer', true)->first() ?? Kata::first();
        $kataBulanIni = Kata::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $hariPertama = Aktivitas::min('created_at');
        $selisihHari = $hariPertama ? max(1, min(30, now()->diffInDays($hariPertama) + 1)) : 1;
        $rataAksesHarian = round(Aktivitas::where('created_at', '>=', now()->subDays(30))->count() / $selisihHari, 1);

        $kategoriDistribusi = Kategori::withCount('katas')
            ->orderByDesc('katas_count')
            ->get()
            ->map(function ($kategori) use ($totalKata) {
                return [
                    'nama' => $kategori->nama_kategori,
                    'jumlah' => $kategori->katas_count,
                    'persen' => $totalKata > 0 ? round(($kategori->katas_count / $totalKata) * 100, 1) : 0,
                ];
            });

        $aktivitasTerbaru = Aktivitas::with('user')
            ->latest()
            ->limit(15)
            ->get();

        $statistikTren = $this->statistikPencarianHarian();

        return view('admin.menu-sidebar.laporan', [
            'totalAktivitas' => $totalAktivitas,
            'kataPopulerTeratas' => $kataPopulerTeratas,
            'kataBulanIni' => $kataBulanIni,
            'rataAksesHarian' => $rataAksesHarian,
            'kategoriDistribusi' => $kategoriDistribusi,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'statistikTren' => $statistikTren,
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
     * Perbarui profil administrator.
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', Rule::unique('users', 'username')->ignore($admin->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($admin->id)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $admin->update($validated);

        Aktivitas::create([
            'user_id' => $admin->id,
            'tipe' => 'ubah',
            'deskripsi' => 'Admin "'.$admin->username.'" memperbarui data profil akun.',
        ]);

        return back()->with('success', 'Profil administrator berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi administrator.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $admin->update([
            'password' => $request->string('password'),
        ]);

        Aktivitas::create([
            'user_id' => $admin->id,
            'tipe' => 'ubah',
            'deskripsi' => 'Admin "'.$admin->username.'" memperbarui kata sandi.',
        ]);

        return back()->with('success', 'Kata sandi berhasil diubah dengan sukses.');
    }

    /**
     * Simpan konfigurasi parameter sistem kamus.
     */
    public function updateSistem(Request $request): RedirectResponse
    {
        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'ubah',
            'deskripsi' => 'Admin memperbarui parameter konfigurasi sistem kamus.',
        ]);

        return back()->with('success', 'Parameter konfigurasi sistem kamus berhasil disimpan.');
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
