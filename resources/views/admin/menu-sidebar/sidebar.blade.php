<!-- ================= REUSABLE ADMIN SIDEBAR ================= -->
<aside class="w-64 bg-[#0A2D63] text-white flex flex-col justify-between shrink-0 h-screen sticky top-0 shadow-xl z-20 overflow-y-auto select-none border-r border-white/5">
    <div>
        <!-- Sidebar Header / Logo -->
        <div class="px-5 py-5 flex flex-col items-center border-b border-white/10 bg-[#08244F]/50">
            <a href="{{ url('/') }}" class="text-center group block">
                <img src="{{ asset('img/sidebar-logo.png') }}" alt="Kamus Bahasa Suku Wemale" class="h-16 w-auto object-contain mx-auto transition-transform duration-200 group-hover:scale-105">
            </a>
        </div>

        <!-- Admin Profile Card -->
        <div class="px-6 py-4 flex flex-col items-center text-center border-b border-white/10 bg-[#092857]/30">
            <div class="relative mb-2">
                <img src="{{ asset('img/admin-avatar.png') }}" alt="Admin Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-white/30 shadow-md">
                <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-[#0A2D63] rounded-full"></span>
            </div>
            <h4 class="font-bold text-sm text-white tracking-wide leading-tight">{{ Auth::user()?->name ?? 'Administrator' }}</h4>
            <p class="text-[11px] text-slate-300 font-medium mt-0.5">{{ Auth::user()?->role?->label() ?? 'Administrator' }}</p>
            <div class="flex items-center gap-1.5 mt-1 text-[11px] text-emerald-400 font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block animate-pulse"></span>
                <span>Online</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="p-3.5 space-y-1">
            <!-- 1. Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-house w-4 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Dashboard</span>
                </div>
            </a>

            <!-- 2. Kelola Kamus -->
            <a href="{{ route('admin.kelola-kamus') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kelola-kamus') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-book-bookmark w-4 text-center {{ request()->routeIs('admin.kelola-kamus') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Kelola Kamus</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('admin.kelola-kamus') ? 'text-white' : 'text-slate-400' }}"></i>
            </a>

            <!-- 3. Kelola Kategori -->
            <a href="{{ route('admin.kelola-kategori') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kelola-kategori') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-table-cells-large w-4 text-center {{ request()->routeIs('admin.kelola-kategori') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Kelola Kategori</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('admin.kelola-kategori') ? 'text-white' : 'text-slate-400' }}"></i>
            </a>

            <!-- 4. Kelola Pengguna -->
            <a href="{{ route('admin.kelola-pengguna') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kelola-pengguna') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users w-4 text-center {{ request()->routeIs('admin.kelola-pengguna') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Kelola Pengguna</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('admin.kelola-pengguna') ? 'text-white' : 'text-slate-400' }}"></i>
            </a>

            <!-- 5. Informasi Website -->
            <a href="{{ route('admin.informasi-website') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.informasi-website') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info w-4 text-center {{ request()->routeIs('admin.informasi-website') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Informasi Website</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('admin.informasi-website') ? 'text-white' : 'text-slate-400' }}"></i>
            </a>

            <!-- 6. Laporan -->
            <a href="{{ route('admin.laporan') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.laporan') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-chart-column w-4 text-center {{ request()->routeIs('admin.laporan') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Laporan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('admin.laporan') ? 'text-white' : 'text-slate-400' }}"></i>
            </a>

            <!-- 7. Pengaturan -->
            <a href="{{ route('admin.pengaturan') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.pengaturan') ? 'bg-[#174A8B] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-gear w-4 text-center {{ request()->routeIs('admin.pengaturan') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Pengaturan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('admin.pengaturan') ? 'text-white' : 'text-slate-400' }}"></i>
            </a>
        </nav>
    </div>

    <!-- Logout Button -->
    <div class="p-3.5 border-t border-white/10 bg-[#08244F]/40">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-rose-400 hover:bg-white/5 font-semibold text-sm transition">
                <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
