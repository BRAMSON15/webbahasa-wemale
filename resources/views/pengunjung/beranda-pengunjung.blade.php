<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Beranda Pengunjung | Kamus Bahasa Suku Wemale</title>
    
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

        /* Toast notification */
        #toastNotification {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] antialiased min-h-screen flex flex-col justify-between">

    <!-- Toast Notification -->
    <div id="toastNotification" class="fixed top-24 right-5 z-50 transform translate-y-[-100px] opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white border border-slate-100 shadow-xl rounded-2xl px-5 py-3.5 flex items-center gap-3">
            <span id="toastIcon" class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">
                <i class="fa-solid fa-check"></i>
            </span>
            <div>
                <h5 id="toastTitle" class="font-bold text-xs text-[#0C2B5E]">Pemberitahuan</h5>
                <p id="toastMessage" class="text-xs text-slate-500 font-medium">Operasi berhasil dilakukan.</p>
            </div>
        </div>
    </div>

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            
            <!-- Left: Logo & Title -->
            <div class="flex items-center gap-4">
                <a href="{{ route('pengunjung.beranda') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('img/logo-extracted.png') }}" alt="Kamus Bahasa Suku Wemale" class="h-11 sm:h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-102">
                </a>
                <div class="hidden sm:block h-8 w-px bg-slate-200"></div>
            </div>

            <!-- Center: Navigation Links (Desktop) -->
            <nav class="hidden lg:flex items-center gap-1.5">
                <a href="{{ route('pengunjung.beranda') }}" class="bg-[#133E87] text-white px-4 py-2 rounded-full font-semibold flex items-center gap-2 text-sm shadow-sm transition hover:bg-[#0C2B5E]">
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Beranda</span>
                </a>
                
                <a href="#kamusSection" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100/80 rounded-full">
                    <i class="fa-solid fa-book-open text-slate-400"></i>
                    <span>Kamus</span>
                </a>

                <a href="#kategoriSection" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100/80 rounded-full">
                    <i class="fa-solid fa-table-cells-large text-slate-400"></i>
                    <span>Kategori</span>
                </a>

                <a href="{{ route('pengunjung.kuis') }}" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100/80 rounded-full">
                    <i class="fa-solid fa-graduation-cap text-[#133E87]"></i>
                    <span>Kuis Bahasa</span>
                </a>

                <button onclick="openFavoritesModal()" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100/80 rounded-full">
                    <i class="fa-solid fa-star text-amber-500"></i>
                    <span>Favorit Saya</span>
                    <span id="navFavBadge" class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-full">0</span>
                </button>

                <button onclick="openContributionModal()" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100/80 rounded-full">
                    <i class="fa-solid fa-pen-nib text-slate-400"></i>
                    <span>Usulkan Kata</span>
                </button>
            </nav>

            <!-- Right: User Profile & Dropdown (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-[#0C2B5E] px-3.5 py-2 rounded-full font-bold text-xs flex items-center gap-2 transition">
                        <i class="fa-solid fa-shield-halved text-[#133E87]"></i>
                        <span>Panel Admin</span>
                    </a>
                @endif

                <!-- User Profile Pill with Dropdown -->
                <div class="relative" id="userMenuDropdownContainer">
                    <button onclick="toggleUserDropdown()" class="flex items-center gap-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 py-1.5 pl-2 pr-3.5 rounded-full transition focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-[#133E87] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-bold text-[#0C2B5E] leading-tight line-clamp-1 max-w-[120px]">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 font-medium">{{ Auth::user()->role?->label() ?? 'Pengunjung' }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <!-- Dropdown Content -->
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-100">
                        <div class="px-4 py-3">
                            <p class="text-xs text-slate-400 font-medium">Masuk sebagai</p>
                            <p class="text-sm font-extrabold text-[#0C2B5E] truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#E1F0FD] text-[#133E87] mt-2">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-[8px]"></i>
                                {{ Auth::user()->role?->label() ?? 'Pengguna Terdaftar' }}
                            </span>
                        </div>

                        <div class="py-1 text-xs text-slate-700">
                            <a href="{{ route('pengunjung.kuis') }}" class="w-full text-left px-4 py-2 hover:bg-slate-50 flex items-center gap-2.5">
                                <i class="fa-solid fa-graduation-cap text-[#133E87] w-4 text-center"></i>
                                <span>Kuis Kosakata Wemale</span>
                            </a>
                            <button onclick="openFavoritesModal(); toggleUserDropdown();" class="w-full text-left px-4 py-2 hover:bg-slate-50 flex items-center gap-2.5">
                                <i class="fa-solid fa-star text-amber-500 w-4 text-center"></i>
                                <span>Kata Favorit Saya</span>
                            </button>
                            <button onclick="openContributionModal(); toggleUserDropdown();" class="w-full text-left px-4 py-2 hover:bg-slate-50 flex items-center gap-2.5">
                                <i class="fa-solid fa-pen-nib text-[#133E87] w-4 text-center"></i>
                                <span>Usulkan Kosakata Baru</span>
                            </button>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 hover:bg-slate-50 flex items-center gap-2.5 font-bold text-[#133E87]">
                                    <i class="fa-solid fa-gauge-high text-[#133E87] w-4 text-center"></i>
                                    <span>Dashboard Admin</span>
                                </a>
                            @endif
                        </div>

                        <div class="pt-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 font-semibold transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-2 lg:hidden">
                <button onclick="openFavoritesModal()" class="p-2 text-amber-500 relative">
                    <i class="fa-solid fa-star text-lg"></i>
                    <span id="mobileFavBadge" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-amber-500 text-white text-[9px] font-bold flex items-center justify-center">0</span>
                </button>
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-700 hover:text-[#133E87] text-xl focus:outline-none">
                    <i id="mobileMenuIcon" class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-100 bg-white px-6 py-4 space-y-3">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-10 h-10 rounded-full bg-[#133E87] text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <h5 class="text-sm font-bold text-[#0C2B5E]">{{ Auth::user()->name }}</h5>
                    <p class="text-xs text-slate-500">{{ Auth::user()->role?->label() ?? 'Pengunjung' }}</p>
                </div>
            </div>

            <a href="{{ route('pengunjung.beranda') }}" class="flex items-center gap-3 text-[#133E87] font-bold text-sm py-1.5">
                <i class="fa-solid fa-house w-4"></i>
                <span>Beranda</span>
            </a>
            <a href="#kamusSection" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1.5">
                <i class="fa-solid fa-book-open w-4 text-slate-400"></i>
                <span>Kamus</span>
            </a>
            <a href="#kategoriSection" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1.5">
                <i class="fa-solid fa-table-cells-large w-4 text-slate-400"></i>
                <span>Kategori</span>
            </a>
            <a href="{{ route('pengunjung.kuis') }}" class="flex items-center gap-3 text-slate-700 font-medium text-sm py-1.5">
                <i class="fa-solid fa-graduation-cap w-4 text-[#133E87]"></i>
                <span>Kuis Bahasa</span>
            </a>
            <button onclick="openFavoritesModal(); toggleMobileMenu();" class="w-full text-left flex items-center gap-3 text-slate-700 font-medium text-sm py-1.5">
                <i class="fa-solid fa-star w-4 text-amber-500"></i>
                <span>Favorit Saya</span>
            </button>
            <button onclick="openContributionModal(); toggleMobileMenu();" class="w-full text-left flex items-center gap-3 text-slate-700 font-medium text-sm py-1.5">
                <i class="fa-solid fa-pen-nib w-4 text-[#133E87]"></i>
                <span>Usulkan Kosakata Baru</span>
            </button>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-[#133E87] font-bold text-sm py-1.5">
                    <i class="fa-solid fa-shield-halved w-4"></i>
                    <span>Panel Dashboard Admin</span>
                </a>
            @endif

            <div class="border-t border-slate-100 pt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 text-rose-600 font-bold text-sm py-1">
                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i>
                        <span>Logout dari Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-grow">

        <!-- ================= HERO SECTION FOR REGISTERED VISITORS ================= -->
        <section class="relative bg-gradient-to-b from-[#E9F3FC] via-[#F4F9FE] to-[#F8FAFC] pt-8 sm:pt-12 pb-16 px-4 sm:px-8 border-b border-slate-100 overflow-hidden">
            <!-- Decorative Background Motifs -->
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-[#133E87]/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 top-40 w-80 h-80 bg-blue-400/5 rounded-full blur-2xl pointer-events-none"></div>

            <div class="max-w-[1536px] mx-auto relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Left: Welcome & Search (7 cols) -->
                    <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                        
                        <!-- Welcome Pill Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-slate-200/80 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-[#0C2B5E]">Halo, {{ Auth::user()->name }}!</span>
                            <span class="text-slate-300">|</span>
                            <span class="text-[11px] text-slate-500 font-medium">{{ Auth::user()->role?->label() ?? 'Pengunjung' }}</span>
                        </div>

                        <!-- Hero Main Heading -->
                        <div>
                            <h1 class="text-3xl sm:text-5xl lg:text-5xl font-black text-[#0C2B5E] tracking-tight leading-tight">
                                Kamus Bahasa<br>
                                <span class="text-[#133E87]">Suku Wemale</span>
                            </h1>
                            <p class="text-slate-600 italic text-sm sm:text-base mt-2 font-medium">
                                "Lestarikan Bahasa Daerah, Perkuat Identitas Budaya Seram"
                            </p>
                            <p class="text-slate-500 text-xs sm:text-sm mt-3 leading-relaxed max-w-xl mx-auto lg:mx-0">
                                Jelajahi ribuan kosakata, simpan istilah favorit untuk dipelajari kapan saja, dan berpartisipasi aktif dalam mendokumentasikan warisan tutur lisan leluhur.
                            </p>
                        </div>

                        <!-- Functional Search Form -->
                        <div class="pt-2 max-w-2xl mx-auto lg:mx-0">
                            <form onsubmit="event.preventDefault(); handleSearch(document.getElementById('pengunjungSearchInput').value);" class="relative">
                                <div class="relative flex items-center bg-white rounded-full shadow-lg hover:shadow-xl px-5 py-3 sm:py-3.5 border border-slate-200/80 transition-all focus-within:ring-3 focus-within:ring-[#133E87]/20 focus-within:border-[#133E87]">
                                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-base sm:text-lg mr-3"></i>
                                    <input 
                                        type="text" 
                                        id="pengunjungSearchInput"
                                        placeholder="Ketik kata Bahasa Wemale atau Bahasa Indonesia..." 
                                        class="w-full bg-transparent text-slate-800 placeholder-slate-400 text-xs sm:text-sm focus:outline-none font-normal"
                                        autocomplete="off"
                                        oninput="handleSearchPreview(this.value)"
                                    />
                                    <button 
                                        type="button" 
                                        id="clearSearchBtn" 
                                        onclick="clearSearchInput()" 
                                        class="text-slate-400 hover:text-slate-600 mr-2 text-sm hidden"
                                    >
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <button 
                                        type="submit" 
                                        class="bg-[#133E87] hover:bg-[#0C2B5E] text-white font-bold px-6 sm:px-8 py-2 sm:py-2.5 rounded-full flex items-center gap-2 text-xs sm:text-sm shrink-0 shadow-md transition-all active:scale-95 cursor-pointer"
                                    >
                                        <span>Cari</span>
                                        <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </button>
                                </div>

                                <!-- Instant Search Preview Dropdown -->
                                <div id="searchPreviewDropdown" class="hidden absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 max-h-72 overflow-y-auto z-30 p-2 divide-y divide-slate-100">
                                </div>
                            </form>
                        </div>

                        <!-- Quick suggestion tags -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 pt-1 text-xs text-slate-500">
                            <span class="font-semibold text-slate-400">Pencarian sering:</span>
                            @foreach($kataPopuler->take(4) as $kp)
                                <button onclick="showWordDetail({{ json_encode($kp->kata_wemale) }})" class="px-3 py-1 bg-white hover:bg-[#DCEBFB] text-[#133E87] font-semibold rounded-full border border-slate-200 transition">
                                    {{ $kp->kata_wemale }}
                                </button>
                            @endforeach
                        </div>

                    </div>

                    <!-- Right: Word of the Day & Seram Scenery Card (5 cols) -->
                    <div class="lg:col-span-5 space-y-4">
                        
                        <!-- Word of the Day Feature Card -->
                        @if($kataHariIni)
                            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-md relative overflow-hidden group">
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#E1F0FD] rounded-full blur-xl group-hover:scale-110 transition-transform"></div>
                                
                                <div class="flex items-center justify-between pb-3 border-b border-slate-100 relative z-10">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-sm">
                                            <i class="fa-solid fa-sun"></i>
                                        </span>
                                        <span class="text-xs font-black uppercase tracking-wider text-amber-600">Kata Hari Ini</span>
                                    </div>
                                    <button 
                                        type="button" 
                                        onclick="toggleFavorite({{ json_encode($kataHariIni->kata_wemale) }}, this)"
                                        class="favorite-btn w-8 h-8 rounded-full bg-slate-50 hover:bg-amber-50 text-slate-400 hover:text-amber-500 flex items-center justify-center text-sm transition"
                                        title="Simpan ke Favorit"
                                        data-word="{{ $kataHariIni->kata_wemale }}"
                                    >
                                        <i class="fa-regular fa-star"></i>
                                    </button>
                                </div>

                                <div class="py-4 relative z-10">
                                    <div class="flex items-baseline gap-3">
                                        <h3 class="text-2xl sm:text-3xl font-black text-[#0C2B5E] tracking-tight">
                                            {{ $kataHariIni->kata_wemale }}
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#E1F0FD] text-[#133E87]">
                                            {{ $kataHariIni->kategori?->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-600 mt-1">
                                        Artinya: <span class="text-[#133E87] font-bold">"{{ $kataHariIni->arti_indonesia }}"</span>
                                    </p>

                                    @if($kataHariIni->contoh)
                                        <div class="mt-3.5 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                                            <p class="text-slate-500 font-medium">Contoh Kalimat:</p>
                                            <p class="italic text-slate-700 font-semibold mt-0.5">"{{ $kataHariIni->contoh }}"</p>
                                            @if($kataHariIni->terjemahan_contoh)
                                                <p class="text-slate-400 text-[11px] mt-0.5">({{ $kataHariIni->terjemahan_contoh }})</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between relative z-10">
                                    <button 
                                        onclick="speakWord({{ json_encode($kataHariIni->kata_wemale) }})"
                                        class="inline-flex items-center gap-1.5 text-xs text-[#133E87] font-bold hover:underline"
                                    >
                                        <i class="fa-solid fa-volume-high"></i>
                                        <span>Dengarkan Pelafalan</span>
                                    </button>
                                    <button 
                                        onclick="showWordDetail({{ json_encode($kataHariIni->kata_wemale) }})"
                                        class="text-xs font-bold text-slate-500 hover:text-[#0C2B5E] flex items-center gap-1"
                                    >
                                        <span>Rincian Lengkap</span>
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </section>

        <!-- ================= USER QUICK KPI STATS ROW ================= -->
        <section class="max-w-[1536px] mx-auto px-4 sm:px-8 -mt-8 relative z-20 mb-12">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4 card-custom">
                    <div class="w-12 h-12 rounded-2xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                    <div>
                        <h4 class="text-xl sm:text-2xl font-black text-[#0C2B5E]">{{ number_format($totalKata, 0, ',', '.') }}</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Kosakata Tersedia</p>
                    </div>
                </div>

                <div onclick="openFavoritesModal()" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4 card-custom cursor-pointer">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <h4 id="statFavCount" class="text-xl sm:text-2xl font-black text-[#0C2B5E]">0</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Kata Favorit Saya</p>
                    </div>
                </div>

                <div onclick="document.getElementById('kategoriSection').scrollIntoView({behavior: 'smooth'})" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4 card-custom cursor-pointer">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-table-cells-large"></i>
                    </div>
                    <div>
                        <h4 class="text-xl sm:text-2xl font-black text-[#0C2B5E]">{{ $totalKategori }}</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Kategori Kosakata</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4 card-custom">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-black text-[#0C2B5E] line-clamp-1">{{ Auth::user()->role?->label() ?? 'Anggota' }}</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500 font-medium">Status Akun Aktif</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= 4 QUICK ACTION CARDS ================= -->
        <section id="kamusSection" class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Card 1: Cari Kata -->
                <div onclick="document.getElementById('pengunjungSearchInput').focus()" class="card-custom bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-[#E1F0FD] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-open text-2xl text-[#133E87]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-base leading-tight group-hover:text-[#2B7BE9] transition-colors">
                            Cari Kata
                        </h3>
                        <p class="text-slate-500 text-xs mt-1 leading-snug">
                            Cari terjemahan Wemale - Indonesia instan.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#133E87] text-white flex items-center justify-center text-xs group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Card 2: Favorit Saya -->
                <div onclick="openFavoritesModal()" class="card-custom bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-[#FEF3C7] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-star text-2xl text-[#F59E0B]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-base leading-tight group-hover:text-[#F59E0B] transition-colors">
                            Kata Favorit
                        </h3>
                        <p class="text-slate-500 text-xs mt-1 leading-snug">
                            Koleksi kosakata yang Anda simpan.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#F59E0B] text-white flex items-center justify-center text-xs group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Card 3: Jelajahi Kategori -->
                <div onclick="document.getElementById('kategoriSection').scrollIntoView({behavior: 'smooth'})" class="card-custom bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-[#D1FAE5] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-bookmark text-2xl text-[#10B981]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-base leading-tight group-hover:text-[#10B981] transition-colors">
                            Koleksi Istilah
                        </h3>
                        <p class="text-slate-500 text-xs mt-1 leading-snug">
                            Jelajahi kata menurut rumpun makna & adat.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#10B981] text-white flex items-center justify-center text-xs group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Card 4: Usulkan Kata -->
                <div onclick="openContributionModal()" class="card-custom bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 relative group cursor-pointer">
                    <div class="w-14 h-14 rounded-2xl bg-[#EDE9FE] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-pen-to-square text-2xl text-[#7C3AED]"></i>
                    </div>
                    <div class="pr-6">
                        <h3 class="text-[#0C2B5E] font-bold text-base leading-tight group-hover:text-[#7C3AED] transition-colors">
                            Usulkan Kata
                        </h3>
                        <p class="text-slate-500 text-xs mt-1 leading-snug">
                            Kontribusikan kosakata baru untuk kamus.
                        </p>
                    </div>
                    <div class="absolute bottom-4 right-4 w-7 h-7 rounded-full bg-[#7C3AED] text-white flex items-center justify-center text-xs group-hover:translate-x-0.5 transition-all shadow-xs">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= KUIS & EVALUASI BANNER ================= -->
        <section class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-16">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0C2B5E] via-[#133E87] to-[#2B7BE9] text-white p-6 sm:p-8 shadow-md">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-sky-200 text-xs font-bold mb-2.5">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Fitur Evaluasi Belajar</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white leading-tight">
                            Uji Kemampuan Kosakata Bahasa Wemale Anda
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-200 mt-1.5 leading-relaxed">
                            Ikuti kuis interaktif pilihan ganda, dapatkan skor langsung dan pembahasan lengkap untuk setiap kosakata.
                        </p>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('pengunjung.kuis') }}" class="inline-flex items-center gap-2.5 bg-amber-400 hover:bg-amber-300 text-slate-900 px-6 py-3 rounded-2xl font-black text-xs shadow-lg transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-play"></i>
                            <span>Mulai Kuis Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= KATA POPULER SECTION ================= -->
        <section class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-16">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-start gap-3">
                    <span class="w-1.5 h-8 bg-[#133E87] rounded-full shrink-0 mt-0.5"></span>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E] tracking-tight">
                            Kata Populer
                        </h2>
                        <p class="text-slate-500 text-sm mt-0.5">
                            Kosakata yang paling sering dipelajari oleh anggota komunitas
                        </p>
                    </div>
                </div>

                <div>
                    <button onclick="showAllWordsModal()" class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-[#133E87] text-[#133E87] hover:bg-[#133E87] hover:text-white font-bold text-xs transition shadow-2xs">
                        <span>Lihat Semua Kosakata</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Tag Pills Row -->
            <div class="flex flex-wrap gap-3 items-center">
                @forelse($kataPopuler as $kp)
                    <div class="inline-flex items-center bg-[#DCEBFB] hover:bg-[#c2deff] rounded-full transition shadow-2xs group">
                        <button 
                            type="button"
                            onclick="showWordDetail({{ json_encode($kp->kata_wemale) }})"
                            class="pl-5 pr-2 py-2.5 text-[#133E87] font-bold text-sm sm:text-base cursor-pointer"
                        >
                            {{ $kp->kata_wemale }}
                        </button>
                        <button 
                            type="button" 
                            onclick="toggleFavorite({{ json_encode($kp->kata_wemale) }}, this)"
                            class="favorite-btn pr-4 pl-1 text-slate-400 hover:text-amber-500 text-xs transition"
                            title="Simpan ke Favorit"
                            data-word="{{ $kp->kata_wemale }}"
                        >
                            <i class="fa-regular fa-star"></i>
                        </button>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada kata populer tercatat.</p>
                @endforelse
            </div>

        </section>

        <!-- ================= KATEGORI KOSAKATA SECTION ================= -->
        <section id="kategoriSection" class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-16">
            
            <div class="flex items-start gap-3 mb-6">
                <span class="w-1.5 h-8 bg-emerald-600 rounded-full shrink-0 mt-0.5"></span>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E] tracking-tight">
                        Kategori Kosakata
                    </h2>
                    <p class="text-slate-500 text-sm mt-0.5">
                        Jelajahi istilah berdasarkan rumpun makna, tata bahasa, dan tradisi lokal
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($kategoriList as $kategori)
                    <div onclick="filterByCategory({{ json_encode($kategori->nama_kategori) }})" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs card-custom cursor-pointer flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-base mb-3 group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <h4 class="font-extrabold text-base text-[#0C2B5E] group-hover:text-[#133E87] transition-colors">
                                {{ $kategori->nama_kategori }}
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                {{ $kategori->deskripsi ?? 'Rumpun kosakata dalam bahasa Wemale.' }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-[#133E87]">{{ $kategori->katas_count }} Kata</span>
                            <span class="text-slate-400 group-hover:text-[#133E87] transition-colors flex items-center gap-1 font-semibold">
                                <span>Buka</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada kategori yang terdaftar.</p>
                @endforelse
            </div>

        </section>

    </main>

    <!-- ================= FOOTER BANNER ================= -->
    <footer class="w-full overflow-hidden select-none bg-white border-t border-slate-100">
        <div class="w-full max-w-[1536px] mx-auto">
            <img 
                src="{{ asset('img/footer-clean.png') }}" 
                alt="Bahasa Kita, Warisan Kita - Kamus Bahasa Suku Wemale" 
                class="w-full h-auto block select-none pointer-events-none"
            />
        </div>
    </footer>

    <!-- ================= MODALS ================= -->

    <!-- 1. Modal Detail Kata -->
    <div id="wordDetailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative modal-enter">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <span id="modalWordCategory" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#E1F0FD] text-[#133E87]">
                    Kategori
                </span>
                <div class="flex items-center gap-2">
                    <button id="modalFavBtn" onclick="toggleModalFavorite()" class="w-9 h-9 rounded-full bg-slate-50 hover:bg-amber-50 text-slate-400 hover:text-amber-500 flex items-center justify-center text-sm transition" title="Simpan Kata">
                        <i class="fa-regular fa-star"></i>
                    </button>
                    <button onclick="closeWordModal()" class="w-9 h-9 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 id="modalWordTitle" class="text-3xl font-black text-[#0C2B5E] tracking-tight">Kata</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Bahasa Suku Wemale</p>
                    </div>
                    <button id="modalSpeakBtn" onclick="speakCurrentModalWord()" class="w-11 h-11 rounded-2xl bg-[#E1F0FD] text-[#133E87] hover:bg-[#133E87] hover:text-white flex items-center justify-center text-lg transition shadow-xs" title="Dengarkan Pelafalan">
                        <i class="fa-solid fa-volume-high"></i>
                    </button>
                </div>

                <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <p class="text-xs text-slate-400 font-medium">Arti Bahasa Indonesia:</p>
                    <p id="modalWordMeaning" class="text-lg font-bold text-[#0C2B5E] mt-0.5">-</p>
                </div>

                <div id="modalExampleBox" class="mt-4 p-4 rounded-2xl bg-[#F8FAFC] border border-slate-100 text-xs">
                    <p class="text-slate-500 font-semibold mb-1">Contoh Penggunaan Kalimat:</p>
                    <p id="modalWordExample" class="italic font-bold text-[#0C2B5E] text-sm">"-"</p>
                    <p id="modalWordExampleTrans" class="text-slate-500 text-xs mt-1">(-)</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400 italic">Kamus Bahasa Suku Wemale</span>
                <button onclick="closeWordModal()" class="px-5 py-2 rounded-xl bg-[#133E87] text-white font-bold hover:bg-[#0C2B5E] transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Modal Kata Favorit Saya -->
    <div id="favoritesModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative modal-enter max-h-[85vh] flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-star"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-extrabold text-[#0C2B5E]">Kata Favorit Saya</h3>
                        <p class="text-xs text-slate-500">Kosakata yang Anda simpan untuk dipelajari</p>
                    </div>
                </div>
                <button onclick="closeFavoritesModal()" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-500 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- List of favorites -->
            <div id="favoritesListContainer" class="py-4 space-y-2.5 overflow-y-auto flex-1">
                <!-- Rendered by JS -->
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <button onclick="clearAllFavorites()" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1.5">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Kosongkan Favorit</span>
                </button>
                <button onclick="closeFavoritesModal()" class="px-5 py-2 rounded-xl bg-[#133E87] text-white font-bold hover:bg-[#0C2B5E] transition">
                    Selesai
                </button>
            </div>
        </div>
    </div>

    <!-- 3. Modal Usulkan Kosakata Baru (Kontribusi) -->
    <div id="contributionModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative modal-enter max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-[#EDE9FE] text-[#7C3AED] flex items-center justify-center text-sm">
                        <i class="fa-solid fa-pen-nib"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-extrabold text-[#0C2B5E]">Usulkan Kosakata Baru</h3>
                        <p class="text-xs text-slate-500">Bantu lestarikan dan lengkapi kamus bahasa Wemale</p>
                    </div>
                </div>
                <button onclick="closeContributionModal()" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-500 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="formUsulKata" onsubmit="submitWordContribution(event)" class="py-4 space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kata Bahasa Wemale <span class="text-rose-500">*</span></label>
                    <input type="text" id="usulKataWemale" required placeholder="Contoh: Aman, Sou, Lumata" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Arti Bahasa Indonesia <span class="text-rose-500">*</span></label>
                    <input type="text" id="usulArtiIndonesia" required placeholder="Contoh: Negeri, Bicara, Rumah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Rumpun Kata</label>
                    <select id="usulKategori" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        <option value="">-- Pilih Kategori (Opsional) --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Contoh Kalimat Wemale (Opsional)</label>
                    <input type="text" id="usulContoh" placeholder="Contoh kalimat dalam Bahasa Wemale..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Terjemahan Contoh Kalimat (Opsional)</label>
                    <input type="text" id="usulTerjemahanContoh" placeholder="Terjemahan contoh kalimat ke Bahasa Indonesia..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                </div>

                <div class="pt-2">
                    <button type="submit" id="btnSubmitUsul" class="w-full bg-[#133E87] hover:bg-[#0C2B5E] text-white py-3 rounded-xl font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Usulan Kosakata</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. Modal Semua Kosakata -->
    <div id="allWordsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative modal-enter max-h-[85vh] flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-extrabold text-[#0C2B5E]">Daftar Seluruh Kosakata</h3>
                    <p class="text-xs text-slate-500">Koleksi kosakata kamus digital Bahasa Suku Wemale</p>
                </div>
                <button onclick="document.getElementById('allWordsModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-500 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="py-3">
                <input 
                    type="text" 
                    id="filterAllWordsInput" 
                    placeholder="Saring kata..." 
                    oninput="filterAllWordsTable(this.value)" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"
                >
            </div>

            <div class="overflow-y-auto flex-1 divide-y divide-slate-100 text-xs" id="allWordsList">
                @foreach($kamusData as $wordKey => $item)
                    <div class="py-3 px-2 flex items-center justify-between hover:bg-slate-50 rounded-xl transition cursor-pointer word-item-row" data-word="{{ strtolower($wordKey) }}" data-meaning="{{ strtolower($item['meaning']) }}" onclick="showWordDetail({{ json_encode($wordKey) }})">
                        <div>
                            <span class="font-bold text-sm text-[#0C2B5E]">{{ $wordKey }}</span>
                            <span class="text-slate-400 mx-2">→</span>
                            <span class="text-slate-700 font-medium">{{ $item['meaning'] }}</span>
                        </div>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-[#E1F0FD] text-[#133E87]">
                            {{ $item['category'] ?? 'Umum' }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button onclick="document.getElementById('allWordsModal').classList.add('hidden')" class="px-5 py-2 rounded-xl bg-[#133E87] text-white font-bold text-xs hover:bg-[#0C2B5E] transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ================= JAVASCRIPT LOGIC ================= -->
    <script>
        // Data Kamus diteruskan dari Laravel Controller
        const kamusData = @json($kamusData);
        let currentModalWordKey = null;

        // Inisialisasi daftar favorit dari LocalStorage
        function getFavorites() {
            try {
                return JSON.parse(localStorage.getItem('wemale_favorites') || '[]');
            } catch (e) {
                return [];
            }
        }

        function saveFavorites(favs) {
            localStorage.setItem('wemale_favorites', JSON.stringify(favs));
            updateFavoriteBadges();
        }

        function updateFavoriteBadges() {
            const favs = getFavorites();
            const count = favs.length;
            
            const navFavBadge = document.getElementById('navFavBadge');
            const mobileFavBadge = document.getElementById('mobileFavBadge');
            const statFavCount = document.getElementById('statFavCount');

            if (navFavBadge) navFavBadge.innerText = count;
            if (mobileFavBadge) mobileFavBadge.innerText = count;
            if (statFavCount) statFavCount.innerText = count;

            // Perbarui tombol bintang di halaman
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                const word = btn.getAttribute('data-word');
                if (favs.includes(word)) {
                    btn.classList.add('text-amber-500');
                    btn.classList.remove('text-slate-400');
                    btn.innerHTML = '<i class="fa-solid fa-star"></i>';
                } else {
                    btn.classList.remove('text-amber-500');
                    btn.classList.add('text-slate-400');
                    btn.innerHTML = '<i class="fa-regular fa-star"></i>';
                }
            });
        }

        // Toggle favorite untuk kata tertentu
        function toggleFavorite(word, element) {
            let favs = getFavorites();
            const index = favs.indexOf(word);
            let added = false;

            if (index > -1) {
                favs.splice(index, 1);
            } else {
                favs.push(word);
                added = true;
            }

            saveFavorites(favs);
            showToast(added ? 'Ditambahkan ke Favorit' : 'Dihapus dari Favorit', `Kata "${word}" ${added ? 'berhasil disimpan.' : 'telah dihapus dari daftar favorit.'}`);
        }

        // Toggle favorite dari dalam modal detail
        function toggleModalFavorite() {
            if (!currentModalWordKey) return;
            let favs = getFavorites();
            const index = favs.indexOf(currentModalWordKey);
            let added = false;

            if (index > -1) {
                favs.splice(index, 1);
            } else {
                favs.push(currentModalWordKey);
                added = true;
            }

            saveFavorites(favs);
            updateModalFavBtnState(added);
            showToast(added ? 'Ditambahkan ke Favorit' : 'Dihapus dari Favorit', `Kata "${currentModalWordKey}" ${added ? 'berhasil disimpan.' : 'telah dihapus dari daftar favorit.'}`);
        }

        function updateModalFavBtnState(isFav) {
            const btn = document.getElementById('modalFavBtn');
            if (!btn) return;
            if (isFav) {
                btn.className = 'w-9 h-9 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-sm transition';
                btn.innerHTML = '<i class="fa-solid fa-star"></i>';
            } else {
                btn.className = 'w-9 h-9 rounded-full bg-slate-50 hover:bg-amber-50 text-slate-400 hover:text-amber-500 flex items-center justify-center text-sm transition';
                btn.innerHTML = '<i class="fa-regular fa-star"></i>';
            }
        }

        // Tampilkan Detail Kata
        function showWordDetail(wordKey) {
            currentModalWordKey = wordKey;
            const data = kamusData[wordKey] || {
                word: wordKey,
                meaning: 'Arti kata belum tersedia.',
                category: 'Umum',
                example: '',
                exampleTrans: ''
            };

            document.getElementById('modalWordTitle').innerText = data.word || wordKey;
            document.getElementById('modalWordMeaning').innerText = data.meaning || '-';
            document.getElementById('modalWordCategory').innerText = data.category || 'Umum';

            const exampleBox = document.getElementById('modalExampleBox');
            if (data.example) {
                exampleBox.classList.remove('hidden');
                document.getElementById('modalWordExample').innerText = `"${data.example}"`;
                document.getElementById('modalWordExampleTrans').innerText = data.exampleTrans ? `(${data.exampleTrans})` : '';
            } else {
                exampleBox.classList.add('hidden');
            }

            const favs = getFavorites();
            updateModalFavBtnState(favs.includes(wordKey));

            document.getElementById('wordDetailModal').classList.remove('hidden');
        }

        function closeWordModal() {
            document.getElementById('wordDetailModal').classList.add('hidden');
            currentModalWordKey = null;
        }

        // Buka Modal Favorit
        function openFavoritesModal() {
            const favs = getFavorites();
            const container = document.getElementById('favoritesListContainer');
            container.innerHTML = '';

            if (favs.length === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-slate-400">
                        <i class="fa-regular fa-star text-4xl mb-3 text-slate-300"></i>
                        <p class="font-bold text-sm text-slate-600">Belum ada kata favorit</p>
                        <p class="text-xs text-slate-400 mt-1">Klik ikon bintang pada kata apa pun untuk menyimpannya di sini.</p>
                    </div>
                `;
            } else {
                favs.forEach(word => {
                    const data = kamusData[word] || { meaning: 'Kosakata Wemale' };
                    const div = document.createElement('div');
                    div.className = 'p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between hover:bg-slate-100/70 transition';
                    div.innerHTML = `
                        <div class="cursor-pointer flex-1" onclick="closeFavoritesModal(); showWordDetail('${word}')">
                            <h5 class="font-extrabold text-[#0C2B5E] text-sm">${word}</h5>
                            <p class="text-xs text-slate-600 font-medium">${data.meaning}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="speakWord('${word}')" class="p-2 text-[#133E87] hover:bg-white rounded-lg transition" title="Dengarkan">
                                <i class="fa-solid fa-volume-high text-xs"></i>
                            </button>
                            <button onclick="removeFavorite('${word}')" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    `;
                    container.appendChild(div);
                });
            }

            document.getElementById('favoritesModal').classList.remove('hidden');
        }

        function closeFavoritesModal() {
            document.getElementById('favoritesModal').classList.add('hidden');
        }

        function removeFavorite(word) {
            let favs = getFavorites();
            favs = favs.filter(w => w !== word);
            saveFavorites(favs);
            openFavoritesModal();
        }

        function clearAllFavorites() {
            if (confirm('Apakah Anda yakin ingin mengosongkan seluruh kata favorit?')) {
                saveFavorites([]);
                openFavoritesModal();
            }
        }

        // Buka Modal Kontribusi Kata
        function openContributionModal() {
            document.getElementById('contributionModal').classList.remove('hidden');
        }

        function closeContributionModal() {
            document.getElementById('contributionModal').classList.add('hidden');
        }

        // Kirim Usulan Kata via AJAX
        async function submitWordContribution(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitUsul');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';

            const payload = {
                kata_wemale: document.getElementById('usulKataWemale').value,
                arti_indonesia: document.getElementById('usulArtiIndonesia').value,
                kategori_id: document.getElementById('usulKategori').value || null,
                contoh: document.getElementById('usulContoh').value || null,
                terjemahan_contoh: document.getElementById('usulTerjemahanContoh').value || null,
            };

            try {
                const response = await fetch("{{ route('pengunjung.usulkan-kata') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    showToast('Usulan Terkirim!', data.message);
                    document.getElementById('formUsulKata').reset();
                    closeContributionModal();
                } else {
                    alert(data.message || 'Gagal mengirim usulan kata.');
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan saat mengirim usulan.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }

        // Tampilkan Modal Semua Kata
        function showAllWordsModal() {
            document.getElementById('allWordsModal').classList.remove('hidden');
        }

        function filterAllWordsTable(q) {
            const query = q.toLowerCase();
            document.querySelectorAll('.word-item-row').forEach(row => {
                const word = row.getAttribute('data-word');
                const meaning = row.getAttribute('data-meaning');
                if (word.includes(query) || meaning.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        // Pencarian Realtime & Autocomplete
        function handleSearchPreview(query) {
            const clearBtn = document.getElementById('clearSearchBtn');
            const dropdown = document.getElementById('searchPreviewDropdown');
            const q = query.trim().toLowerCase();

            if (q.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
                dropdown.classList.add('hidden');
                return;
            }

            const matches = Object.keys(kamusData).filter(word => {
                const meaning = (kamusData[word].meaning || '').toLowerCase();
                return word.toLowerCase().includes(q) || meaning.includes(q);
            });

            if (matches.length === 0) {
                dropdown.innerHTML = `
                    <div class="p-3 text-center text-xs text-slate-400">
                        Tidak ada kata cocok dengan "<strong>${query}</strong>"
                    </div>
                `;
            } else {
                dropdown.innerHTML = matches.slice(0, 6).map(word => {
                    const item = kamusData[word];
                    return `
                        <div onclick="showWordDetail('${word}')" class="p-2.5 hover:bg-slate-50 rounded-xl cursor-pointer flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-[#0C2B5E]">${word}</span>
                                <span class="text-slate-400 mx-1.5">→</span>
                                <span class="text-slate-600">${item.meaning}</span>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#E1F0FD] text-[#133E87]">${item.category}</span>
                        </div>
                    `;
                }).join('');
            }

            dropdown.classList.remove('hidden');
        }

        function clearSearchInput() {
            const input = document.getElementById('pengunjungSearchInput');
            input.value = '';
            document.getElementById('clearSearchBtn').classList.add('hidden');
            document.getElementById('searchPreviewDropdown').classList.add('hidden');
            input.focus();
        }

        function handleSearch(query) {
            const q = query.trim();
            if (!q) return;

            document.getElementById('searchPreviewDropdown').classList.add('hidden');
            
            // Periksa kecocokan kata persis
            const exactKey = Object.keys(kamusData).find(w => w.toLowerCase() === q.toLowerCase());
            if (exactKey) {
                showWordDetail(exactKey);
                return;
            }

            // Jika tidak ada kata persis, buka modal filter kata
            showAllWordsModal();
            const filterInput = document.getElementById('filterAllWordsInput');
            filterInput.value = q;
            filterAllWordsTable(q);
        }

        function filterByCategory(categoryName) {
            showAllWordsModal();
            const filterInput = document.getElementById('filterAllWordsInput');
            filterInput.value = '';
            
            document.querySelectorAll('.word-item-row').forEach(row => {
                const badge = row.querySelector('span:last-child');
                if (badge && badge.innerText.trim().toLowerCase() === categoryName.trim().toLowerCase()) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        // Web Speech API untuk pelafalan kata
        function speakWord(text) {
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                window.speechSynthesis.speak(utterance);
            } else {
                alert(`Pelafalan: ${text}`);
            }
        }

        function speakCurrentModalWord() {
            if (currentModalWordKey) {
                speakWord(currentModalWordKey);
            }
        }

        // Tampilkan Toast
        function showToast(title, message) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastTitle').innerText = title;
            document.getElementById('toastMessage').innerText = message;
            
            toast.classList.remove('translate-y-[-100px]', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.add('translate-y-[-100px]', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }

        // Dropdown toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Tutup dropdown saat klik di luar
        window.addEventListener('click', function(e) {
            const container = document.getElementById('userMenuDropdownContainer');
            if (container && !container.contains(e.target)) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
            const searchContainer = document.getElementById('pengunjungSearchInput')?.closest('form');
            if (searchContainer && !searchContainer.contains(e.target)) {
                document.getElementById('searchPreviewDropdown')?.classList.add('hidden');
            }
        });

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateFavoriteBadges();
        });
    </script>
</body>
</html>
