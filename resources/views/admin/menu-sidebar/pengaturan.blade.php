@extends('admin.layout')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan Akun & Sistem')
@section('page_subtitle', 'Kelola informasi profil administrator, keamanan kata sandi, dan parameter aplikasi')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Settings Navigation & Quick Profile (4 cols) -->
        <div class="lg:col-span-4 space-y-5">
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-xs flex flex-col items-center text-center">
                <div class="relative mb-3">
                    <img src="{{ asset('img/admin-avatar.png') }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-slate-100 shadow-md">
                    <button class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-[#133E87] text-white text-xs flex items-center justify-center hover:bg-[#0C2B5E] shadow-sm transition">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                </div>
                <h4 class="font-extrabold text-base text-[#0C2B5E]">{{ Auth::user()?->name ?? 'Administrator' }}</h4>
                <p class="text-xs text-slate-500">{{ Auth::user()?->email ?? 'admin@wemale.test' }}</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-[#E1F0FD] text-[#133E87] mt-3">
                    <i class="fa-solid fa-shield-halved"></i> Super Administrator
                </span>
            </div>

            <!-- Quick Settings Navigation -->
            <div class="bg-white rounded-2xl p-3 border border-slate-100 shadow-xs space-y-1 text-xs font-bold text-slate-700">
                <a href="#profil" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-slate-100 text-[#133E87] transition">
                    <i class="fa-solid fa-user-gear w-4 text-center"></i>
                    <span>Profil Administrator</span>
                </a>
                <a href="#keamanan" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-[#133E87] transition">
                    <i class="fa-solid fa-lock w-4 text-center"></i>
                    <span>Keamanan & Password</span>
                </a>
                <a href="#sistem" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-[#133E87] transition">
                    <i class="fa-solid fa-sliders w-4 text-center"></i>
                    <span>Konfigurasi Kamus</span>
                </a>
            </div>
        </div>

        <!-- Right: Settings Forms (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Profil Form -->
            <div id="profil" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-xs">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-5">
                    <span class="w-8 h-8 rounded-lg bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-user-pen"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-base text-[#0C2B5E]">Informasi Akun Profil</h3>
                        <p class="text-xs text-slate-500">Perbarui nama pengguna, alamat email, dan identitas admin</p>
                    </div>
                </div>

                <form class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()?->name ?? 'Administrator' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Username</label>
                            <input type="text" value="{{ Auth::user()?->username ?? 'admin' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Alamat Email Resmi</label>
                        <input type="email" value="{{ Auth::user()?->email ?? 'admin@wemale.test' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="button" onclick="alert('Profil berhasil diperbarui!');" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-sm transition">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Form -->
            <div id="keamanan" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-xs">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-5">
                    <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-base text-[#0C2B5E]">Keamanan Kata Sandi</h3>
                        <p class="text-xs text-slate-500">Pastikan akun menggunakan password yang kuat dan unik</p>
                    </div>
                </div>

                <form class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                        <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Konfirmasi Sandi Baru</label>
                            <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="button" onclick="alert('Kata sandi berhasil diubah!');" class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-sm transition">
                            Perbarui Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Konfigurasi Kamus -->
            <div id="sistem" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-xs">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-5">
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-sliders"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-base text-[#0C2B5E]">Parameter Sistem Kamus</h3>
                        <p class="text-xs text-slate-500">Konfigurasi batasan pencarian, moderasi, dan performa aplikasi</p>
                    </div>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <div>
                            <p class="font-bold text-slate-800">Pencarian Publik Terbuka</p>
                            <p class="text-[11px] text-slate-400">Izinkan pengunjung tanpa login untuk mencari kosakata</p>
                        </div>
                        <input type="checkbox" checked class="w-4 h-4 rounded text-[#133E87] focus:ring-0">
                    </div>

                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <div>
                            <p class="font-bold text-slate-800">Moderasi Usulan Kata Baru</p>
                            <p class="text-[11px] text-slate-400">Semua usulan kosakata baru dari pengguna wajib disetujui admin</p>
                        </div>
                        <input type="checkbox" checked class="w-4 h-4 rounded text-[#133E87] focus:ring-0">
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-bold text-slate-800">Mode Pemeliharaan (Maintenance)</p>
                            <p class="text-[11px] text-slate-400">Tampilkan halaman pemeliharaan sementara saat pembaruan data</p>
                        </div>
                        <input type="checkbox" class="w-4 h-4 rounded text-[#133E87] focus:ring-0">
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
