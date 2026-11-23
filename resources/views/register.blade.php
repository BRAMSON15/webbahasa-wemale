<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Kamus Bahasa Suku Wemale</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
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
                            light: '#DCEBFB',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EBF4FC;
            color: #1E293B;
            overflow-x: hidden;
        }

        .custom-card-shadow {
            box-shadow: 0 25px 50px -12px rgba(12, 43, 94, 0.18), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        }

        /* Select arrow custom styling */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-[#EBF4FC] antialiased">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-2xs">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 h-16 sm:h-18 flex items-center justify-between">
            
            <!-- Left: Logo & Title -->
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('img/logo-extracted.png') }}" alt="Kamus Bahasa Suku Wemale" class="h-11 sm:h-12 w-auto object-contain">
                </a>
                <div class="hidden sm:block h-8 w-px bg-slate-300"></div>
            </div>

            <!-- Center: Navigation Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="{{ url('/') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-house text-slate-500"></i>
                    <span>Beranda</span>
                </a>
                
                <a href="{{ url('/#kamus') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-book-open text-slate-500"></i>
                    <span>Kamus</span>
                </a>

                <a href="{{ url('/#tentang') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-circle-info text-slate-500"></i>
                    <span>Tentang</span>
                </a>

                <a href="{{ url('/#bantuan') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-circle-question text-slate-500"></i>
                    <span>Bantuan</span>
                </a>

                <a href="{{ url('/#kontak') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-envelope text-slate-500"></i>
                    <span>Kontak</span>
                </a>
            </nav>

            <!-- Right: Action Buttons (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ url('/register') }}" class="bg-[#133E87] text-white px-5 py-2 rounded-full font-semibold text-sm shadow-sm">
                    Daftar
                </a>
                <a href="{{ url('/login') }}" class="text-slate-700 hover:text-[#133E87] px-5 py-2 rounded-full font-semibold text-sm border border-slate-200 hover:border-[#133E87] transition">
                    <i class="fa-solid fa-user text-xs mr-1.5"></i>
                    <span>Login</span>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="md:hidden flex items-center gap-2">
                <a href="{{ url('/login') }}" class="bg-[#133E87] text-white px-4 py-1.5 rounded-full font-semibold text-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-user text-[10px]"></i>
                    <span>Login</span>
                </a>
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-700 hover:text-[#133E87] text-xl focus:outline-none">
                    <i id="mobileMenuIcon" class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-6 py-4 space-y-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-house w-4 text-slate-400"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ url('/#kamus') }}" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-book-open w-4 text-slate-400"></i>
                <span>Kamus</span>
            </a>
            <a href="{{ url('/#tentang') }}" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-circle-info w-4 text-slate-400"></i>
                <span>Tentang</span>
            </a>
            <a href="{{ url('/#bantuan') }}" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-circle-question w-4 text-slate-400"></i>
                <span>Bantuan</span>
            </a>
            <a href="{{ url('/#kontak') }}" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-envelope w-4 text-slate-400"></i>
                <span>Kontak</span>
            </a>
            <div class="border-t border-slate-100 pt-2 flex items-center justify-between">
                <a href="{{ url('/login') }}" class="text-sm font-semibold text-[#133E87]">Sudah punya akun? Login</a>
            </div>
        </div>
    </header>

    <!-- ================= MAIN CONTAINER ================= -->
    <main class="flex-1 flex items-center justify-center py-4 sm:py-6 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <!-- Decorative Ethnic Pattern Watermark (Top-Right) -->
        <div class="absolute top-0 right-0 w-80 h-80 opacity-40 pointer-events-none select-none z-0 hidden lg:block">
            <img src="{{ asset('img/register-pattern-tr.png') }}" alt="" class="w-full h-full object-contain object-top-right">
        </div>

        <div class="w-full max-w-[1240px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center relative z-10">
            
            <!-- ================= LEFT COLUMN: SCENERY & BRAND HIGHLIGHT ================= -->
            <div class="lg:col-span-7 flex flex-col justify-center select-none">
                <!-- Clean scenery illustration with stilt house, typography, feature badges & bottom wave -->
                <div class="w-full relative overflow-hidden rounded-3xl shadow-xl border border-white/60">
                    <img 
                        src="{{ asset('img/register-left-clean.png') }}" 
                        alt="Bergabung Bersama Kami di Kamus Bahasa Suku Wemale" 
                        class="w-full h-auto block select-none pointer-events-none mx-auto"
                    />
                </div>
            </div>

            <!-- ================= RIGHT COLUMN: REGISTRATION CARD ================= -->
            <div class="lg:col-span-5 flex justify-center w-full">
                <div class="w-full max-w-[440px] bg-white rounded-3xl p-5 sm:p-6 custom-card-shadow border border-slate-100 relative">
                    
                    <!-- Decorative Traditional Pattern in Bottom-Left of Card Area -->
                    <div class="absolute -bottom-6 -left-6 w-24 h-24 opacity-20 pointer-events-none select-none z-0 hidden sm:block">
                        <img src="{{ asset('img/register-pattern-bl.png') }}" alt="" class="w-full h-full object-contain">
                    </div>

                    <div class="relative z-10">
                        <!-- Top Icon Badge (User with Plus & Blue Wings) -->
                        <div class="flex justify-center mb-1.5">
                            <img src="{{ asset('img/register-badge.png') }}" alt="Daftar Akun" class="h-11 sm:h-12 w-auto object-contain select-none">
                        </div>

                        <!-- Card Header -->
                        <div class="text-center mb-3.5">
                            <h2 class="text-2xl font-extrabold text-[#0C2B5E] tracking-tight">
                                Daftar Akun
                            </h2>
                            <p class="text-slate-500 text-xs mt-0.5">
                                Isi data diri Anda untuk membuat akun
                            </p>
                        </div>

                        <!-- Session / Validation Alerts -->
                        @if (isset($errors) && $errors->any())
                            <div class="mb-3 p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs space-y-1">
                                @foreach ($errors->all() as $error)
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                                        <span>{{ $error }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-3 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- Registration Form -->
                        <form action="{{ route('register') }}" method="POST" class="space-y-2.5">
                            @csrf

                            <!-- 1. Nama Lengkap -->
                            <div>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3.5 text-slate-400 text-xs sm:text-sm">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        placeholder="Nama Lengkap" 
                                        required
                                        class="w-full bg-[#F8FAFC] border border-slate-200/90 focus:border-[#133E87] focus:bg-white rounded-xl py-2 pl-9 sm:pl-10 pr-3.5 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                                    />
                                </div>
                            </div>

                            <!-- 2. Alamat Email -->
                            <div>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3.5 text-slate-400 text-xs sm:text-sm">
                                        <i class="fa-solid fa-envelope"></i>
                                    </span>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email') }}"
                                        placeholder="Alamat Email" 
                                        required
                                        class="w-full bg-[#F8FAFC] border border-slate-200/90 focus:border-[#133E87] focus:bg-white rounded-xl py-2 pl-9 sm:pl-10 pr-3.5 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                                    />
                                </div>
                            </div>

                            <!-- 3. Password -->
                            <div>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3.5 text-slate-400 text-xs sm:text-sm">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        id="regPassword"
                                        name="password" 
                                        placeholder="Password" 
                                        required
                                        class="w-full bg-[#F8FAFC] border border-slate-200/90 focus:border-[#133E87] focus:bg-white rounded-xl py-2 pl-9 sm:pl-10 pr-9 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                                    />
                                    <button 
                                        type="button" 
                                        onclick="togglePasswordVisibility('regPassword', 'regPassIcon')" 
                                        class="absolute right-3.5 text-slate-400 hover:text-slate-600 transition"
                                    >
                                        <i id="regPassIcon" class="fa-regular fa-eye-slash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- 4. Konfirmasi Password -->
                            <div>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3.5 text-slate-400 text-xs sm:text-sm">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        id="regConfirmPassword"
                                        name="password_confirmation" 
                                        placeholder="Konfirmasi Password" 
                                        required
                                        class="w-full bg-[#F8FAFC] border border-slate-200/90 focus:border-[#133E87] focus:bg-white rounded-xl py-2 pl-9 sm:pl-10 pr-9 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                                    />
                                    <button 
                                        type="button" 
                                        onclick="togglePasswordVisibility('regConfirmPassword', 'regConfirmIcon')" 
                                        class="absolute right-3.5 text-slate-400 hover:text-slate-600 transition"
                                    >
                                        <i id="regConfirmIcon" class="fa-regular fa-eye-slash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- 5. Pilih Peran -->
                            <div>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3.5 text-slate-400 text-xs sm:text-sm pointer-events-none">
                                        <i class="fa-solid fa-user-group"></i>
                                    </span>
                                    <select 
                                        name="role" 
                                        required
                                        class="w-full bg-[#F8FAFC] border border-slate-200/90 focus:border-[#133E87] focus:bg-white rounded-xl py-2 pl-9 sm:pl-10 pr-9 text-slate-700 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition cursor-pointer"
                                    >
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Peran</option>
                                        @php
                                            $daftarPeran = $roles ?? \App\Enums\UserRole::registrationOptions();
                                        @endphp
                                        @foreach($daftarPeran as $kunciPeran => $labelPeran)
                                            <option value="{{ $kunciPeran }}" {{ old('role') === $kunciPeran ? 'selected' : '' }}>
                                                {{ $labelPeran }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-3.5 text-slate-400 text-[10px] pointer-events-none">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Submit Button: Daftar Sekarang -->
                            <div class="pt-1">
                                <button 
                                    type="submit" 
                                    class="w-full bg-[#133E87] hover:bg-[#0C2B5E] text-white font-semibold py-2.5 sm:py-3 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer text-xs sm:text-sm active:scale-[0.99]"
                                >
                                    <i class="fa-solid fa-user-plus text-xs"></i>
                                    <span>Daftar Sekarang</span>
                                </button>
                            </div>
                        </form>

                        <!-- Divider "atau" -->
                        <div class="relative flex items-center justify-center my-2.5">
                            <div class="border-t border-slate-200 w-full"></div>
                            <span class="bg-white px-3 text-[11px] text-slate-400 font-medium">atau</span>
                            <div class="border-t border-slate-200 w-full"></div>
                        </div>

                        <!-- Google Signup Button -->
                        <!-- <div>
                            <button 
                                type="button" 
                                onclick="alert('Fitur pendaftaran melalui Akun Google sedang dalam integrasi.')"
                                class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold py-2 rounded-xl flex items-center justify-center gap-2.5 transition-all duration-150 shadow-2xs hover:shadow text-xs sm:text-sm cursor-pointer"
                            >
                                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17Z"/>
                                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/>
                                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.14-1.55.38-2.27V6.58H1.25C.45 8.18 0 10.03 0 12s.45 3.82 1.25 5.42l4.03-3.15Z"/>
                                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/>
                                </svg>
                                <span>Daftar dengan Google</span>
                            </button>
                        </div> -->

                        <!-- Footer Link: Sudah punya akun? Login di sini -->
                        <div class="text-center mt-3.5">
                            <p class="text-xs text-slate-600">
                                Sudah punya akun? 
                                <a href="{{ url('/login') }}" class="font-bold text-[#133E87] hover:underline underline-offset-4">
                                    Login di sini
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('mobileMenuIcon');
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        }

        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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
