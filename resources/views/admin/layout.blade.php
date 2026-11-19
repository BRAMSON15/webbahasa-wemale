<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') | Kamus Bahasa Suku Wemale</title>
    
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
                        sidebar: '#0A2D63',
                        sidebarActive: '#174A8B',
                        primary: '#133E87',
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
            background-color: #EEF2F6;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex text-slate-800 antialiased bg-[#EEF2F6]">

    <!-- ================= SIDEBAR ================= -->
    @include('admin.menu-sidebar.sidebar')

    <!-- ================= MAIN CONTENT AREA ================= -->
    <div class="flex-1 flex flex-col min-w-0 bg-[#EEF2F6]">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-10 shadow-2xs">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-slate-600 hover:text-slate-900 text-xl transition">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-xl font-extrabold text-[#0C2B5E] leading-tight">@yield('page_title', 'Dashboard Admin')</h1>
                    <p class="text-xs text-slate-500 font-medium">@yield('page_subtitle', 'Kamus Bahasa Suku Wemale')</p>
                </div>
            </div>

            <div class="flex items-center gap-4 sm:gap-6">
                <!-- Date -->
                <div class="hidden sm:flex items-center gap-2 text-sm text-slate-600 font-medium">
                    <i class="fa-regular fa-calendar text-[#133E87]"></i>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="hidden sm:block h-6 w-px bg-slate-200"></div>

                <!-- Notifications -->
                <div class="relative cursor-pointer">
                    <span class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 transition">
                        <i class="fa-regular fa-bell"></i>
                    </span>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center">
                        2
                    </span>
                </div>

                <!-- Quick Profile dropdown pill -->
                <div class="flex items-center gap-2.5 pl-2">
                    <img src="{{ asset('img/admin-avatar.png') }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                    <span class="hidden md:block text-xs font-bold text-slate-700">{{ Auth::user()?->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        <!-- Dynamic Body Content -->
        <main class="p-6 md:p-8 space-y-6 flex-1">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <div>
                            <h5 class="font-extrabold text-sm text-emerald-900">Berhasil!</h5>
                            <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </span>
                        <div>
                            <h5 class="font-extrabold text-sm text-rose-900">Terjadi Kesalahan</h5>
                            <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl text-xs shadow-2xs">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>
                        <div>
                            <h5 class="font-extrabold text-sm text-amber-900">Periksa Input Formulir:</h5>
                            <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs text-amber-800">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Dashboard Footer -->
        <footer class="h-14 bg-white border-t border-slate-200/80 px-8 flex items-center justify-between text-xs text-slate-500">
            <p>© 2025 Kamus Bahasa Suku Wemale. Semua hak dilindungi.</p>
            <p class="italic text-[#133E87] font-semibold">Melestarikan Bahasa, Menjaga Budaya</p>
        </footer>

    </div>

    @stack('scripts')
</body>
</html>
