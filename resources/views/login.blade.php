<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($type ?? 'pengunjung') === 'admin' ? 'Login Admin | Kamus Bahasa Suku Wemale' : 'Login Pengunjung | Kamus Bahasa Suku Wemale' }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        wemale: {
                            navy: '#0C2B5E',
                            blue: '#133E87',
                            sky: '#2B7BE9',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen w-full flex flex-col lg:flex-row bg-[#073271] antialiased overflow-x-hidden">

    @php
        $isAdmin = ($type ?? 'pengunjung') === 'admin';
    @endphp

    <!-- ================= LEFT COLUMN: FULL BLEED SCENERY WITH RUMAH ADAT ================= -->
    <div class="lg:w-[58%] xl:w-[62%] relative min-h-[460px] lg:min-h-screen flex flex-col justify-between overflow-hidden bg-[#073271] select-none">
        
        <!-- Scenery Image Filling the Whole Left Screen (No empty margins) -->
        <img 
            src="{{ asset('img/login-left-clean.png') }}?v={{ filemtime(public_path('img/login-left-clean.png')) }}" 
            alt="Kamus Bahasa Suku Wemale Login Banner" 
            class="absolute inset-0 w-full h-full object-cover object-top select-none pointer-events-none"
        />

        <!-- Top Navigation Button -->
        <div class="relative z-10 p-6 sm:p-8 lg:p-10">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-md text-white text-xs font-bold transition shadow-sm">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Bottom Welcome Text & Feature Highlights -->
        <div class="relative z-10 p-7 sm:p-10 lg:p-12 text-white mt-auto bg-gradient-to-t from-[#062452]/95 via-[#062452]/75 to-transparent pt-16">
            <div class="w-14 h-1 bg-white/70 rounded-full mb-3.5"></div>

            @if($isAdmin)
                <h3 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-white mb-2.5 drop-shadow">
                    Selamat Datang di Panel Admin
                </h3>
                <p class="text-xs sm:text-sm text-blue-100/90 font-normal leading-relaxed max-w-lg drop-shadow mb-4">
                    Kelola data kamus Bahasa Suku Wemale dengan mudah dan fitur-fitur pengelolaan data.
                </p>
                <div class="flex flex-wrap gap-2 text-[11px] font-semibold text-white/90">
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-book-bookmark text-sky-300"></i> Kelola Kamus
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-amber-300"></i> Bank Soal Kuis
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-users text-emerald-300"></i> Kelola Pengguna
                    </span>
                </div>
            @else
                <h3 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-white mb-2.5 drop-shadow">
                    Selamat Datang di Kamus Bahasa Wemale
                </h3>
                <p class="text-xs sm:text-sm text-blue-100/90 font-normal leading-relaxed max-w-lg drop-shadow mb-4">
                    Akses kosakata favorit Anda, ikuti kuis pemahaman bahasa daerah, dan berkontribusi melestarikan budaya suku Wemale.
                </p>
                <div class="flex flex-wrap gap-2 text-[11px] font-semibold text-white/90">
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-400"></i> Simpan Favorit
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-graduation-cap text-sky-300"></i> Kuis Kosakata
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-nib text-emerald-300"></i> Usulan Kata
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- ================= RIGHT COLUMN: CLEAN DEDICATED LOGIN FORM ================= -->
    <div class="lg:w-[42%] xl:w-[38%] min-h-screen bg-white flex flex-col justify-center px-6 sm:px-12 lg:px-14 xl:px-16 py-10 relative z-10 shadow-2xl border-l border-slate-100">
        
        <!-- Decorative Ethnic Pattern Watermark (Top-Right) -->
        <div class="absolute top-0 right-0 w-44 h-44 opacity-20 pointer-events-none select-none z-0 hidden lg:block">
            <img src="{{ asset('img/register-pattern-tr.png') }}" alt="" class="w-full h-full object-contain object-top-right">
        </div>

        <div class="w-full max-w-sm mx-auto relative z-10">

            <!-- Icon Badge -->
            <div class="flex justify-center mb-5">
                <div class="w-20 h-20 rounded-full bg-[#E1F0FD] flex items-center justify-center shadow-xs">
                    <div class="w-14 h-14 rounded-full bg-[#133E87] flex items-center justify-center text-white text-xl relative shadow-md">
                        <i class="fa-solid fa-user"></i>
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-white flex items-center justify-center text-[10px] text-[#133E87] shadow-xs">
                            <i class="fa-solid {{ $isAdmin ? 'fa-gear' : 'fa-book-open' }}"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Form Header (Dedicated to Login Pengunjung for Public) -->
            <div class="text-center mb-6">
                @if($isAdmin)
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E] tracking-tight">Login Admin</h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Masuk untuk mengakses panel pengelolaan data</p>
                @else
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E] tracking-tight">Login Pengunjung</h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Masuk untuk mengakses kuis & kata favorit Anda</p>
                @endif
            </div>

            <!-- Session / Validation Alerts -->
            @if (session('error'))
                <div class="mb-4 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Username / Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Username atau Email</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400 text-sm">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input 
                            type="text" 
                            name="username" 
                            value="{{ old('username') }}"
                            placeholder="Masukkan username atau email" 
                            required
                            class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#133E87] focus:bg-white rounded-xl py-3 pl-11 pr-4 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                        />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                        <a href="{{ url('/register') }}" class="text-xs font-semibold text-[#133E87] hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400 text-sm">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            id="passwordInput"
                            name="password" 
                            placeholder="Masukkan kata sandi" 
                            required
                            class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#133E87] focus:bg-white rounded-xl py-3 pl-11 pr-11 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                        />
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-4 text-slate-400 hover:text-slate-600 transition"
                            title="Lihat Kata Sandi"
                        >
                            <i id="passwordIcon" class="fa-regular fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-0.5">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#133E87] focus:ring-[#133E87]">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full bg-[#133E87] hover:bg-[#0C2B5E] text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer text-sm sm:text-base active:scale-[0.99]"
                    >
                        <i class="fa-solid fa-arrow-right-to-bracket text-sm"></i>
                        <span>{{ $isAdmin ? 'Login Admin' : 'Login Pengunjung' }}</span>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="relative flex items-center justify-center my-5">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-xs text-slate-400 font-medium">atau</span>
                <div class="border-t border-slate-200 w-full"></div>
            </div>

            <!-- Register & Navigation Links -->
            <div class="text-center space-y-3">
                <p class="text-xs sm:text-sm text-slate-600">
                    Belum punya akun? 
                    <a href="{{ url('/register') }}" class="font-bold text-[#133E87] hover:underline underline-offset-4">
                        Daftar Akun di sini
                    </a>
                </p>

                @if($isAdmin)
                    <div>
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-500 hover:text-[#133E87] transition underline underline-offset-2">
                            Masuk sebagai Pengunjung
                        </a>
                    </div>
                @endif

                <div class="pt-1">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-[#133E87] transition">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span>Kembali ke Beranda Utama</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('passwordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>
