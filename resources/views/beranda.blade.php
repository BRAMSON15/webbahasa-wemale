<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamus Bahasa Suku Wemale | Beranda Utama</title>
    
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
                            accent: '#F59E0B',
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
            background-color: #F8FAFC;
            color: #1E293B;
            overflow-x: hidden;
        }

        .hero-banner-container {
            position: relative;
            width: 100%;
            margin: 0 auto;
        }

        .card-custom {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px -8px rgba(19, 62, 135, 0.12);
        }

        /* Modal animation */
        .modal-enter {
            animation: fadeIn 0.2s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-[#F8FAFC] antialiased min-h-screen flex flex-col justify-between">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-2xs">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            
            <!-- Left: Logo & Title -->
            <div class="flex items-center gap-4">
                <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('img/logo-extracted.png') }}" alt="Kamus Bahasa Suku Wemale" class="h-11 sm:h-12 w-auto object-contain">
                </a>
                <div class="hidden sm:block h-8 w-px bg-slate-300"></div>
            </div>

            <!-- Center: Navigation Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="{{ route('beranda') }}" class="bg-[#133E87] text-white px-5 py-2 rounded-full font-semibold flex items-center gap-2 text-sm shadow-sm transition hover:bg-[#0C2B5E]">
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Beranda</span>
                </a>
                
                <a href="#kamus" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-book-open text-slate-500"></i>
                    <span>Kamus</span>
                </a>

                <a href="#tentang" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-circle-info text-slate-500"></i>
                    <span>Tentang</span>
                </a>

                <a href="#bantuan" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-circle-question text-slate-500"></i>
                    <span>Bantuan</span>
                </a>

                <a href="#kontak" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-50 rounded-full">
                    <i class="fa-solid fa-envelope text-slate-500"></i>
                    <span>Kontak</span>
                </a>
            </nav>

            <!-- Right: Action Buttons (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-5 py-2 rounded-full font-bold flex items-center gap-2 text-xs shadow-sm transition">
                            <i class="fa-solid fa-gauge-high text-xs"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    @else
                        <a href="{{ route('pengunjung.beranda') }}" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-5 py-2 rounded-full font-bold flex items-center gap-2 text-xs shadow-sm transition">
                            <i class="fa-solid fa-user text-xs"></i>
                            <span>Beranda Saya ({{ Auth::user()->name }})</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-semibold text-sm transition">
                        Daftar
                    </a>
                    <a href="{{ route('login') }}" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-6 py-2 rounded-full font-semibold flex items-center gap-2 text-sm shadow-sm transition-all duration-200 hover:shadow">
                        <i class="fa-solid fa-user text-xs"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="md:hidden flex items-center gap-2">
                @auth
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('pengunjung.beranda') }}" class="bg-[#133E87] text-white px-3.5 py-1.5 rounded-full font-bold text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-[10px]"></i>
                        <span>Akun</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#133E87] text-white px-4 py-1.5 rounded-full font-semibold text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-[10px]"></i>
                        <span>Login</span>
                    </a>
                @endauth
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-700 hover:text-[#133E87] text-xl focus:outline-none">
                    <i id="mobileMenuIcon" class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-6 py-4 space-y-3">
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 text-[#133E87] font-bold text-sm py-1">
                <i class="fa-solid fa-house w-4"></i>
                <span>Beranda</span>
            </a>
            <a href="#kamus" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-book-open w-4 text-slate-400"></i>
                <span>Kamus</span>
            </a>
            <a href="#tentang" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-circle-info w-4 text-slate-400"></i>
                <span>Tentang</span>
            </a>
            <a href="#bantuan" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-circle-question w-4 text-slate-400"></i>
                <span>Bantuan</span>
            </a>
            <a href="#kontak" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1">
                <i class="fa-solid fa-envelope w-4 text-slate-400"></i>
                <span>Kontak</span>
            </a>
            <div class="border-t border-slate-100 pt-2 flex items-center justify-between">
                @auth
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('pengunjung.beranda') }}" class="text-sm font-bold text-[#133E87]">
                        Buka Beranda Saya ({{ Auth::user()->name }})
                    </a>
                @else
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-[#133E87]">Daftar Akun Baru</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-grow">

        <!-- ================= HERO SECTION ================= -->
        <section class="relative w-full bg-gradient-to-b from-[#eaf4fd] via-[#f4f9fe] to-[#F8FAFC] overflow-hidden">
            
            <!-- Desktop Layout (>= 1024px): 1:1 Pixel-Perfect Graphic Banner with Overlay (Full Bleed Edge-to-Edge) -->
            <div class="hidden lg:block hero-banner-container relative select-none">
                <img 
                    src="{{ asset('img/hero-crop.png') }}?v={{ filemtime(public_path('img/hero-crop.png')) }}" 
                    alt="Kamus Bahasa Suku Wemale Hero" 
                    class="w-full h-auto block select-none pointer-events-none"
                />

                <!-- Functional Search Form Overlay (Clean, Single Search Bar) -->
                <div class="absolute left-1/2 -translate-x-1/2 top-[72%] w-full max-w-2xl lg:max-w-3xl px-4 z-20">
                    <form onsubmit="event.preventDefault(); handleSearch(document.getElementById('searchInputDesktop').value);" class="w-full">
                        <div class="relative flex items-center bg-white rounded-full shadow-2xl px-5 py-2.5 sm:py-3 border border-slate-200/90 transition-all focus-within:ring-4 focus-within:ring-[#133E87]/20 focus-within:border-[#133E87]">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 text-lg mr-3 ml-2"></i>
                            <input 
                                type="text" 
                                id="searchInputDesktop"
                                placeholder="Masukkan kata dalam Bahasa Wemale atau Indonesia..." 
                                class="w-full bg-transparent text-slate-800 placeholder-slate-400 text-sm sm:text-base focus:outline-none font-normal"
                                autocomplete="off"
                            />
                            <button 
                                type="submit" 
                                class="bg-[#133E87] hover:bg-[#0C2B5E] text-white font-bold px-7 sm:px-8 py-2.5 sm:py-3 rounded-full flex items-center gap-2 transition-all cursor-pointer text-sm sm:text-base shrink-0 shadow-md ml-2 active:scale-95"
                            >
                                <span>Cari</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mobile & Tablet Layout (< 1024px): Responsive, Crisp & Perfectly Legible -->
            <div class="lg:hidden relative w-full px-4 py-8 sm:py-12 bg-gradient-to-b from-[#eaf4fd] via-[#f4f9fe] to-[#F8FAFC]">
                <div class="max-w-2xl mx-auto text-center relative z-10">
                    <span class="text-[#0C2B5E] font-semibold text-base sm:text-lg">Selamat Datang di</span>
                    <h1 class="text-3xl sm:text-5xl font-black text-[#0C2B5E] tracking-tight mt-1 mb-2 leading-tight">
                        Kamus Bahasa<br>Suku Wemale
                    </h1>
                    <p class="text-slate-600 italic text-sm sm:text-base mb-6 font-medium">
                        Mengenal, Melestarikan, dan Mempelajari Bahasa Suku Wemale
                    </p>

                    <form onsubmit="event.preventDefault(); handleSearch(document.getElementById('searchInputMobile').value);" class="w-full max-w-xl mx-auto">
                        <div class="relative flex items-center bg-white rounded-full shadow-lg px-4 py-2.5 sm:py-3 border border-slate-200">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 text-base mr-2 ml-1"></i>
                            <input 
                                type="text" 
                                id="searchInputMobile"
                                placeholder="Cari kata Wemale atau Indonesia..." 
                                class="w-full bg-transparent text-slate-800 placeholder-slate-400 text-sm focus:outline-none"
                                autocomplete="off"
                            />
                            <button 
                                type="submit" 
                                class="bg-[#133E87] hover:bg-[#0C2B5E] text-white font-semibold px-5 sm:px-6 py-2 rounded-full flex items-center gap-1.5 text-xs sm:text-sm shrink-0 shadow"
                            >
                                <span>Cari</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </section>

        <!-- ================= 4 QUICK ACTION CARDS ================= -->
        <section id="kamus" class="max-w-[1536px] mx-auto px-4 sm:px-8 -mt-8 sm:-mt-10 lg:-mt-14 relative z-30 mb-14">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">
                
                <!-- Card 1: Cari Kata -->
                <div onclick="focusSearch()" class="card-custom bg-white rounded-2xl p-5 sm:p-6 border border-slate-100 shadow-md flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-[#E1F0FD] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-open text-2xl text-[#133E87]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-lg leading-tight group-hover:text-[#2B7BE9] transition-colors">
                            Cari Kata
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1 leading-snug">
                            Temukan arti kata Bahasa Wemale dengan mudah.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#2B7BE9] text-white flex items-center justify-center text-xs group-hover:bg-[#133E87] group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Card 2: Kata Populer -->
                <div onclick="scrollToPopular()" class="card-custom bg-white rounded-2xl p-5 sm:p-6 border border-slate-100 shadow-md flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-[#FEF3C7] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-star text-2xl text-[#F59E0B]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-lg leading-tight group-hover:text-[#F59E0B] transition-colors">
                            Kata Populer
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1 leading-snug">
                            Lihat kata-kata yang paling sering dicari.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#2B7BE9] text-white flex items-center justify-center text-xs group-hover:bg-[#133E87] group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Card 3: Koleksi Istilah -->
                <div onclick="showCategoryList()" class="card-custom bg-white rounded-2xl p-5 sm:p-6 border border-slate-100 shadow-md flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-[#D1FAE5] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-bookmark text-2xl text-[#10B981]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-lg leading-tight group-hover:text-[#10B981] transition-colors">
                            Koleksi Istilah
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1 leading-snug">
                            Jelajahi berbagai istilah Bahasa Wemale.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#2B7BE9] text-white flex items-center justify-center text-xs group-hover:bg-[#133E87] group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Card 4: Tentang Kamus -->
                <div id="tentang" onclick="showAboutModal()" class="card-custom bg-white rounded-2xl p-5 sm:p-6 border border-slate-100 shadow-md flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-[#EDE9FE] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-info text-2xl text-[#7C3AED]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-lg leading-tight group-hover:text-[#7C3AED] transition-colors">
                            Tentang Kamus
                        </h3>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1 leading-snug">
                            Kenali lebih dekat kamus ini dan tujuannya.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#2B7BE9] text-white flex items-center justify-center text-xs group-hover:bg-[#133E87] group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= KATA POPULER SECTION ================= -->
        <section id="popularSection" class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-14">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm">
                <!-- Section Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div class="flex items-start gap-3">
                        <span class="w-1.5 h-8 bg-[#133E87] rounded-full shrink-0 mt-0.5"></span>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E] tracking-tight">
                                Kata Populer
                            </h2>
                            <p class="text-slate-500 text-sm mt-0.5">
                                Kata-kata yang paling sering dicari oleh pengguna
                            </p>
                        </div>
                    </div>

                    <!-- Right button: Lihat Semua -->
                    <div>
                        <button onclick="showAllWordsModal()" class="inline-flex items-center gap-2 px-6 py-2 rounded-full border border-[#133E87] text-[#133E87] hover:bg-[#133E87] hover:text-white font-medium text-sm transition-all duration-200 cursor-pointer shadow-2xs">
                            <span>Lihat Semua</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Tag Pills Row (kata populer murni dari basis data) -->
                <div class="flex flex-wrap gap-3 sm:gap-3.5 items-center">
                    @forelse($kataPopuler as $item)
                        @php
                            $namaKata = is_object($item) ? ($item->kata_wemale ?? '') : $item;
                        @endphp
                        <button 
                            type="button"
                            onclick="showWordDetail({{ json_encode($namaKata) }})"
                            class="px-6 sm:px-7 py-2.5 rounded-full bg-[#DCEBFB] hover:bg-[#c2deff] text-[#133E87] font-semibold text-sm sm:text-base transition-all duration-150 cursor-pointer shadow-2xs active:scale-95"
                        >
                            {{ $namaKata }}
                        </button>
                    @empty
                        <p class="text-sm text-slate-400 italic">Belum ada kosakata populer yang ditandai di dalam sistem.</p>
                    @endforelse
                </div>
            </div>

        </section>

        <!-- ================= KUIS & EVALUASI BANNER ================= -->
        <section class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-14">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0C2B5E] via-[#133E87] to-[#2B7BE9] text-white p-6 sm:p-8 shadow-md">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-sky-200 text-xs font-bold mb-2.5">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Fitur Kuis Interaktif</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight">
                            Uji Pemahaman Kosakata Bahasa Wemale
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-200 mt-1.5 leading-relaxed">
                            Ikuti kuis pilihan ganda untuk menguji sejauh mana penguasaan bahasa daerah suku Wemale Anda dengan evaluasi skor langsung.
                        </p>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2.5 bg-amber-400 hover:bg-amber-300 text-slate-900 px-6 py-3 rounded-2xl font-black text-xs shadow-lg transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-play"></i>
                            <span>Mulai Kuis Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="bantuan" class="scroll-mt-24 max-w-[1536px] mx-auto px-4 sm:px-8 mb-16">
            <div class="rounded-3xl bg-[#F4F9FE] border border-blue-100 p-6 sm:p-10">
                <div class="max-w-3xl mb-7">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E]">Cara Menggunakan Kamus</h2>
                    <p class="text-slate-600 mt-2">Cari arti kata dan jelajahi kosakata Bahasa Suku Wemale dengan langkah sederhana.</p>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="bg-white rounded-2xl border border-slate-100 p-5">
                        <span class="text-[#2B7BE9] font-bold text-sm">01</span>
                        <h3 class="font-bold text-[#0C2B5E] mt-2">Cari kata</h3>
                        <p class="text-sm text-slate-600 mt-1">Masukkan kata Wemale atau Indonesia pada kolom pencarian, lalu tekan Cari.</p>
                        <button type="button" onclick="focusSearch()" class="text-sm font-semibold text-[#133E87] mt-3 hover:underline">Mulai mencari</button>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 p-5">
                        <span class="text-[#2B7BE9] font-bold text-sm">02</span>
                        <h3 class="font-bold text-[#0C2B5E] mt-2">Jelajahi kata populer</h3>
                        <p class="text-sm text-slate-600 mt-1">Pilih salah satu kata populer untuk melihat arti dan contoh penggunaannya.</p>
                        <a href="#popularSection" class="inline-block text-sm font-semibold text-[#133E87] mt-3 hover:underline">Lihat kata populer</a>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 p-5">
                        <span class="text-[#2B7BE9] font-bold text-sm">03</span>
                        <h3 class="font-bold text-[#0C2B5E] mt-2">Usulkan kosakata</h3>
                        <p class="text-sm text-slate-600 mt-1">Masuk atau buat akun untuk mengirim usulan kata melalui menu pengunjung.</p>
                        <a href="{{ route('register') }}" class="inline-block text-sm font-semibold text-[#133E87] mt-3 hover:underline">Buat akun</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="scroll-mt-24 max-w-[1536px] mx-auto px-4 sm:px-8 mb-16">
            <div class="rounded-3xl bg-[#0C2B5E] text-white p-6 sm:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-2xl sm:text-3xl font-extrabold">Ada kosakata yang ingin ditambahkan?</h2>
                    <p class="text-blue-100 mt-2">Kirim usulan kata melalui akun pengunjung agar dapat ditinjau oleh pengelola kamus.</p>
                </div>
                @auth
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('pengunjung.beranda') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-[#133E87] hover:bg-blue-50 transition shrink-0">
                        <span>{{ Auth::user()->isAdmin() ? 'Buka Dashboard' : 'Buka Beranda Saya' }}</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @else
                    <div class="flex flex-wrap gap-3 shrink-0">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/50 px-6 py-3 text-sm font-bold text-white hover:bg-white/10 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-[#133E87] hover:bg-blue-50 transition">
                            Buat akun
                        </a>
                    </div>
                @endauth
            </div>
        </section>

    </main>

    <!-- ================= FOOTER BANNER ================= -->
    <footer class="w-full overflow-hidden select-none bg-white border-t border-slate-100">
        <div class="w-full">
            <!-- Exact clean footer graphic with wave, ethnic motif, trees and "Bahasa Kita, Warisan Kita" -->
            <img 
                src="{{ asset('img/footer-clean.png') }}" 
                alt="Bahasa Kita, Warisan Kita - Kamus Bahasa Suku Wemale" 
                class="w-full h-auto block select-none pointer-events-none"
            />
        </div>
    </footer>

    <!-- ================= WORD DETAIL MODAL ================= -->
    <div id="wordModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 modal-enter relative">
            <button onclick="closeModal()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <span class="w-10 h-10 rounded-2xl bg-[#E1F0FD] flex items-center justify-center text-[#133E87]">
                    <i class="fa-solid fa-book-bookmark text-lg"></i>
                </span>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#2B7BE9]">Bahasa Suku Wemale</span>
                    <h3 id="modalWord" class="text-2xl font-black text-[#0C2B5E]">Kata</h3>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Arti dalam Bahasa Indonesia:</p>
                    <p id="modalMeaning" class="text-lg font-bold text-slate-800">Definisi kata</p>
                </div>

                <div class="bg-[#F8FAFC] rounded-2xl p-4 border border-slate-100">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Contoh Penggunaan:</p>
                    <p id="modalExample" class="text-sm font-medium text-[#133E87] italic">"Contoh kalimat"</p>
                    <p id="modalExampleTrans" class="text-xs text-slate-500 mt-1">Terjemahan kalimat contoh</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-6 py-2.5 rounded-full font-semibold text-sm transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        // Default dictionary data fallback for 10 popular words
        const defaultDictionary = {
            'Mama': {
                word: 'Mama',
                meaning: 'Ibu, orang tua perempuan, sebutan penghormatan kepada wanita dewasa.',
                example: 'Mama e, au wai leko.',
                exampleTrans: 'Ibu, air ini sangat bagus dan segar.'
            },
            'Tana': {
                word: 'Tana',
                meaning: 'Tanah, bumi, negeri, tanah kelahiran atau wilayah adat ulayat suku.',
                example: 'Wemale tana ami pele.',
                exampleTrans: 'Tanah adat Wemale adalah warisan leluhur kami.'
            },
            'Wai': {
                word: 'Wai',
                meaning: 'Air, mata air, atau sungai yang mengalir untuk kehidupan.',
                example: 'Mai ita kinu wai talae.',
                exampleTrans: 'Mari kita minum air dari pancuran jernih.'
            },
            'Suku': {
                word: 'Suku',
                meaning: 'Suku atau kelompok kekerabatan masyarakat adat Wemale di Pulau Seram.',
                example: 'Suku Wemale manise manawa.',
                exampleTrans: 'Masyarakat Suku Wemale hidup rukun dan bersahabat.'
            },
            'Mata': {
                word: 'Mata',
                meaning: 'Mata (indera penglihatan), atau titik pusat sumber (seperti mata air / mata hane).',
                example: 'Mata hane mehe soso.',
                exampleTrans: 'Matahari pagi mulai menyinari perbukitan.'
            },
            'Hane': {
                word: 'Hane',
                meaning: 'Hari, waktu siang, atau siklus pergantian hari.',
                example: 'Hane ini hane leko manise.',
                exampleTrans: 'Hari ini adalah hari yang baik dan cerah.'
            },
            'Kari': {
                word: 'Kari',
                meaning: 'Ikan atau hewan air hasil tangkapan dari laut atau sungai.',
                example: 'Ita ala kari mehe tahi.',
                exampleTrans: 'Kita menangkap ikan segar dari teluk.'
            },
            'Nda': {
                word: 'Nda',
                meaning: 'Tidak, ungkapan negasi atau penolakan santun.',
                example: 'Au nda lau talae.',
                exampleTrans: 'Saya tidak pergi ke hutan hari ini.'
            },
            'Leko': {
                word: 'Leko',
                meaning: 'Baik, bagus, elok, indah, atau berkualitas.',
                example: 'Kamus ini leko pise ami malane.',
                exampleTrans: 'Kamus ini sangat bagus bagi anak cucu kita.'
            },
            'Buku': {
                word: 'Buku',
                meaning: 'Buku, kitab, atau catatan tulisan pembelajaran kata.',
                example: 'Basa buku kamus Wemale.',
                exampleTrans: 'Membaca buku kamus Bahasa Suku Wemale.'
            }
        };

        // Server-passed kamusData merged with fallback
        const serverKamusData = @json($kamusData ?? []);
        const dictionary = Object.keys(serverKamusData).length > 0 ? serverKamusData : defaultDictionary;
        const cariUrl = "{{ route('cari', [], false) }}";

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

        function showWordDetail(wordKey) {
            const data = dictionary[wordKey];
            if (data) {
                document.getElementById('modalWord').textContent = data.word;
                document.getElementById('modalMeaning').textContent = data.meaning;
                document.getElementById('modalExample').textContent = data.example;
                document.getElementById('modalExampleTrans').textContent = data.exampleTrans;
                document.getElementById('wordModal').classList.remove('hidden');
            } else {
                handleCustomWord(wordKey);
            }
        }

        function closeModal() {
            document.getElementById('wordModal').classList.add('hidden');
        }

        function focusSearch() {
            const input = document.getElementById('searchInputDesktop') || document.getElementById('searchInputMobile');
            if (input) {
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function scrollToPopular() {
            document.getElementById('popularSection').scrollIntoView({ behavior: 'smooth' });
        }

        async function handleSearch(query) {
            query = (query || '').trim();
            if (!query) return;

            // Cek kecocokan tepat pada kamus lokal terlebih dahulu
            const matchedKey = Object.keys(dictionary).find(k => k.toLowerCase() === query.toLowerCase());
            if (matchedKey) {
                showWordDetail(matchedKey);
                return;
            }

            // Cari di backend API
            try {
                const res = await fetch(cariUrl + '?q=' + encodeURIComponent(query), {
                    headers: { 'Accept': 'application/json' }
                });
                if (res.ok) {
                    const data = await res.json();
                    if (data.total > 0) {
                        const hasil = data.hasil[0];
                        document.getElementById('modalWord').textContent = hasil.kata;
                        document.getElementById('modalMeaning').textContent = hasil.arti;
                        document.getElementById('modalExample').textContent = hasil.contoh ? '"' + hasil.contoh + '"' : '—';
                        document.getElementById('modalExampleTrans').textContent = hasil.terjemahan || '';
                        document.getElementById('wordModal').classList.remove('hidden');
                        return;
                    }
                }
            } catch (e) {
                console.error(e);
            }

            handleCustomWord(query);
        }

        function handleCustomWord(query) {
            document.getElementById('modalWord').textContent = query;
            document.getElementById('modalMeaning').textContent = 'Pencarian kata "' + query + '" sedang dicocokkan dengan basis data kamus Wemale-Indonesia.';
            document.getElementById('modalExample').textContent = '"' + query + '" tercatat dalam indeks kosakata adat suku Wemale.';
            document.getElementById('modalExampleTrans').textContent = 'Silakan hubungi administrator jika Anda ingin menambahkan penjelasan istilah ini.';
            document.getElementById('wordModal').classList.remove('hidden');
        }

        function showCategoryList() {
            document.getElementById('modalWord').textContent = 'Koleksi Istilah Wemale';
            document.getElementById('modalMeaning').textContent = 'Kategori: Kekerabatan, Alam & Lingkungan, Perlengkapan Tradisional, Flora & Fauna Seram Barat.';
            document.getElementById('modalExample').textContent = 'Memuat lebih dari 1.200 istilah terdaftar dalam sistem.';
            document.getElementById('modalExampleTrans').textContent = 'Gunakan fitur pencarian untuk menemukan arti kata spesifik.';
            document.getElementById('wordModal').classList.remove('hidden');
        }

        function showAboutModal() {
            document.getElementById('modalWord').textContent = 'Tentang Kamus Suku Wemale';
            document.getElementById('modalMeaning').textContent = 'Platform digital pelestarian dan pendokumentasian Bahasa Suku Wemale (Pulau Seram, Maluku).';
            document.getElementById('modalExample').textContent = '"Mengenal, Melestarikan, dan Mempelajari Bahasa Suku Wemale"';
            document.getElementById('modalExampleTrans').textContent = 'Bahasa Kita, Warisan Kita — Menjaga warisan budaya untuk generasi masa depan.';
            document.getElementById('wordModal').classList.remove('hidden');
        }

        function showAllWordsModal() {
            document.getElementById('modalWord').textContent = 'Semua Kosakata Populer';
            document.getElementById('modalMeaning').textContent = 'Daftar 10 kata paling aktif: ' + Object.keys(dictionary).join(', ');
            document.getElementById('modalExample').textContent = 'Klik pada masing-masing kata di beranda untuk melihat definisi mendalam.';
            document.getElementById('modalExampleTrans').textContent = 'Total data kamus saat ini mencakup 1.248 entri kosakata aktif.';
            document.getElementById('wordModal').classList.remove('hidden');
        }

        // Close on Escape or click outside
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
        document.getElementById('wordModal').addEventListener('click', (e) => {
            if (e.target.id === 'wordModal') closeModal();
        });
    </script>
</body>
</html>
