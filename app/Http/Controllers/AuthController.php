<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Aktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login utama (dengan opsi Pengunjung & Admin).
     */
    public function showLogin(Request $request)
    {
        $type = $request->query('type', 'pengunjung');

        return view('login', [
            'type' => in_array($type, ['admin', 'pengunjung']) ? $type : 'pengunjung',
        ]);
    }

    /**
     * Tampilkan halaman login khusus pengunjung & pengguna umum.
     */
    public function showPengunjungLogin()
    {
        return view('login', ['type' => 'pengunjung']);
    }

    /**
     * Tampilkan halaman login khusus administrator.
     */
    public function showAdminLogin()
    {
        return view('login', ['type' => 'admin']);
    }

    /**
     * Proses login berdasarkan username atau email dan password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = $credentials['username'];
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attempt = Auth::attempt([
            $field => $loginInput,
            'password' => $credentials['password'],
        ], $request->boolean('remember'));

        // Coba field alternatif jika percobaan pertama tidak cocok
        if (! $attempt) {
            $altField = ($field === 'email') ? 'username' : 'email';
            $attempt = Auth::attempt([
                $altField => $loginInput,
                'password' => $credentials['password'],
            ], $request->boolean('remember'));
        }

        if (! $attempt) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        // Administrator diarahkan ke Dashboard Admin
        if ($user->isAdmin()) {
            Aktivitas::create([
                'user_id' => $user->id,
                'tipe' => 'sistem',
                'deskripsi' => 'Admin "'.$user->username.'" masuk ke panel dashboard.',
            ]);

            return redirect()->route('admin.dashboard');
        }

        // Pengunjung terdaftar diarahkan ke Beranda Pengunjung
        Aktivitas::create([
            'user_id' => $user->id,
            'tipe' => 'masuk',
            'deskripsi' => 'Pengguna "'.$user->name.'" berhasil masuk ke kamus.',
        ]);

        return redirect()->route('pengunjung.beranda');
    }

    /**
     * Tampilkan halaman registrasi akun.
     */
    public function showRegister()
    {
        return view('register', [
            'roles' => UserRole::registrationOptions(),
        ]);
    }

    /**
     * Proses registrasi akun baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', 'in:'.implode(',', array_keys(UserRole::registrationOptions()))],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password.',
            'role.required' => 'Pilih peran terlebih dahulu.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        $usernameBase = explode('@', $validated['email'])[0];
        $username = $this->uniqueUsername($usernameBase);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $username,
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => UserRole::from($validated['role']),
        ]);

        Aktivitas::create([
            'user_id' => $user->id,
            'tipe' => 'daftar',
            'deskripsi' => 'Pengguna baru terdaftar: "'.$user->name.'"',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login untuk mulai menjelajahi kamus.');
    }

    /**
     * Logout pengguna yang sedang masuk.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }

    /**
     * Hasilkan username unik berdasarkan basis email.
     */
    private function uniqueUsername(string $base): string
    {
        $username = $base;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base.$i++;
        }

        return $username;
    }
}
