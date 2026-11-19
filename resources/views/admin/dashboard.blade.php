<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Kamus Bahasa Suku Wemale</title>
    
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
                        sidebar: '#0B234A',
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
</head>
<body class="min-h-screen flex text-slate-800 antialiased">
@php
    $totalKata = $totalKata ?? 0;
    $totalPengguna = $totalPengguna ?? 0;
    $totalKategori = $totalKategori ?? 0;
    $tingkatAkses = $tingkatAkses ?? 0.0;
    $aktivitasTerbaru = $aktivitasTerbaru ?? collect();
    $statistikHarian = $statistikHarian ?? [];
@endphp

    <!-- ================= SIDEBAR ================= -->
    @include('admin.menu-sidebar.sidebar')

    <!-- ================= MAIN CONTENT AREA ================= -->
    <div class="flex-1 flex flex-col min-w-0 bg-[#EEF2F6]">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-8 flex items-center justify-between sticky top-0 z-10 shadow-2xs">
            <div class="flex items-center gap-4">
                <button class="text-slate-600 hover:text-slate-900 text-xl transition">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-xl font-extrabold text-[#0C2B5E] leading-tight">Dashboard Admin</h1>
                    <p class="text-xs text-slate-500 font-medium">Kamus Bahasa Suku Wemale</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <!-- Date -->
                <div class="flex items-center gap-2 text-sm text-slate-600 font-medium">
                    <i class="fa-regular fa-calendar text-[#133E87]"></i>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="h-6 w-px bg-slate-200"></div>

                <!-- Notifications -->
                <div class="relative cursor-pointer">
                    <span class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 transition">
                        <i class="fa-regular fa-bell"></i>
                    </span>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center">
                        2
                    </span>
                </div>
            </div>
        </header>

        <!-- Dashboard Body -->
        <main class="p-6 md:p-8 space-y-6 flex-1">

            <!-- Panoramic Banner -->
            <div class="w-full rounded-2xl overflow-hidden shadow-sm relative">
                <img src="{{ asset('img/dashboard-banner.png') }}" alt="Selamat Datang, Admin!" class="w-full h-auto block select-none pointer-events-none">
            </div>

            <!-- 4 Statistic Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Stat 1: Total Kata -->
                <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-[#E1F0FD] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-book-open text-2xl text-[#133E87]"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-[#0C2B5E] tracking-tight">{{ number_format($totalKata, 0, ',', '.') }}</h3>
                        <p class="text-slate-500 text-sm font-medium mt-0.5">Total Kata</p>
                        <span class="inline-flex items-center text-xs font-semibold text-emerald-600 mt-1">
                            <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i> +12%
                        </span>
                    </div>
                </div>

                <!-- Stat 2: Total Pengguna -->
                <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-[#D1FAE5] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-2xl text-[#10B981]"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-[#0C2B5E] tracking-tight">{{ $totalPengguna }}</h3>
                        <p class="text-slate-500 text-sm font-medium mt-0.5">Total Pengguna</p>
                        <span class="inline-flex items-center text-xs font-semibold text-emerald-600 mt-1">
                            <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i> +8%
                        </span>
                    </div>
                </div>

                <!-- Stat 3: Kategori Kata -->
                <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-[#FEF3C7] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-file-lines text-2xl text-[#F59E0B]"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-[#0C2B5E] tracking-tight">{{ $totalKategori }}</h3>
                        <p class="text-slate-500 text-sm font-medium mt-0.5">Kategori Kata</p>
                        <span class="inline-flex items-center text-xs font-semibold text-emerald-600 mt-1">
                            <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i> +5%
                        </span>
                    </div>
                </div>

                <!-- Stat 4: Tingkat Akses -->
                <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100 flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-[#EDE9FE] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chart-column text-2xl text-[#7C3AED]"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-[#0C2B5E] tracking-tight">{{ number_format($tingkatAkses, 1, ',', '.') }}%</h3>
                        <p class="text-slate-500 text-sm font-medium mt-0.5">Tingkat Akses</p>
                        <span class="inline-flex items-center text-xs font-semibold text-emerald-600 mt-1">
                            <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i> +2%
                        </span>
                    </div>
                </div>

            </div>

            <!-- Charts & Recent Activity Row -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Left: Usage Chart (7 Cols) -->
                <div class="lg:col-span-7 bg-white rounded-2xl p-6 shadow-xs border border-slate-100 flex flex-col justify-between">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-sm">
                                <i class="fa-solid fa-book-open"></i>
                            </span>
                            <h3 class="font-bold text-base text-[#0C2B5E]">Statistik Penggunaan Kamus</h3>
                        </div>
                        <div class="relative">
                            <select class="bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 px-3 py-1.5 focus:outline-none">
                                <option>7 Hari Terakhir</option>
                                <option>30 Hari Terakhir</option>
                                <option>Tahun Ini</option>
                            </select>
                        </div>
                    </div>

                    <!-- Line Chart SVG (dinamis dari basis data) -->
                    @php
                        $nilai = array_map(fn ($d) => $d['nilai'], $statistikHarian);
                        $maxNilai = max($nilai) > 0 ? max($nilai) : 1;
                        $titik = [];
                        foreach ($statistikHarian as $i => $hari) {
                            $titik[] = [
                                'x' => 60 + ($i * 80),
                                'y' => 200 - ($hari['nilai'] / $maxNilai) * 160,
                                'label' => $hari['label'],
                                'nilai' => $hari['nilai'],
                            ];
                        }
                        $pathGaris = collect($titik)->map(fn ($p, $i) => ($i === 0 ? 'M' : 'L').' '.$p['x'].' '.$p['y'])->implode(' ');
                        $pathIsi = $pathGaris.' L '.$titik[count($titik) - 1]['x'].' 200 L '.$titik[0]['x'].' 200 Z';
                        $last = $titik[count($titik) - 1];
                        $tooltipY = max(22, $last['y'] - 40);
                    @endphp
                    <div class="relative h-64 w-full pt-4">
                        <svg class="w-full h-full" viewBox="0 0 600 220" fill="none" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#2B7BE9" stop-opacity="0.25"/>
                                    <stop offset="100%" stop-color="#2B7BE9" stop-opacity="0.0"/>
                                </linearGradient>
                            </defs>
                            <!-- Grid horizontal lines -->
                            <line x1="40" y1="40" x2="580" y2="40" stroke="#E2E8F0" stroke-dasharray="3 3"/>
                            <text x="30" y="44" fill="#94A3B8" font-size="11" text-anchor="end">{{ round($maxNilai) }}</text>

                            <line x1="40" y1="80" x2="580" y2="80" stroke="#E2E8F0" stroke-dasharray="3 3"/>
                            <text x="30" y="84" fill="#94A3B8" font-size="11" text-anchor="end">{{ round($maxNilai * 0.75) }}</text>

                            <line x1="40" y1="120" x2="580" y2="120" stroke="#E2E8F0" stroke-dasharray="3 3"/>
                            <text x="30" y="124" fill="#94A3B8" font-size="11" text-anchor="end">{{ round($maxNilai * 0.5) }}</text>

                            <line x1="40" y1="160" x2="580" y2="160" stroke="#E2E8F0" stroke-dasharray="3 3"/>
                            <text x="30" y="164" fill="#94A3B8" font-size="11" text-anchor="end">{{ round($maxNilai * 0.25) }}</text>

                            <line x1="40" y1="200" x2="580" y2="200" stroke="#CBD5E1" stroke-width="1.5"/>
                            <text x="30" y="204" fill="#94A3B8" font-size="11" text-anchor="end">0</text>

                            <!-- Gradient fill below curve -->
                            <path d="{{ $pathIsi }}" fill="url(#chartGradient)"/>

                            <!-- Main Data Line -->
                            <path d="{{ $pathGaris }}" stroke="#133E87" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>

                            <!-- Data Points -->
                            @foreach ($titik as $p)
                                <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4.5" fill="#133E87"/>
                            @endforeach

                            <!-- Highlight last point -->
                            <circle cx="{{ $last['x'] }}" cy="{{ $last['y'] }}" r="6" fill="#133E87" stroke="#FFFFFF" stroke-width="2"/>

                            <!-- Active Tooltip Tag on last point -->
                            <rect x="{{ $last['x'] - 47 }}" y="{{ $tooltipY }}" width="95" height="26" rx="6" fill="#0C2B5E"/>
                            <text x="{{ $last['x'] }}" y="{{ $tooltipY + 17 }}" fill="#FFFFFF" font-size="11" font-weight="bold" text-anchor="middle">{{ $last['nilai'] }} Aktivitas</text>

                            <!-- Day Labels -->
                            @foreach ($titik as $p)
                                <text x="{{ $p['x'] }}" y="218" fill="#64748B" font-size="11" font-weight="600" text-anchor="middle">{{ $p['label'] }}</text>
                            @endforeach
                        </svg>
                    </div>
                </div>

                <!-- Right: Recent Activity (5 Cols) -->
                <div class="lg:col-span-5 bg-white rounded-2xl p-6 shadow-xs border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-bolt"></i>
                                </span>
                                <h3 class="font-bold text-base text-[#0C2B5E]">Aktivitas Terbaru</h3>
                            </div>
                            <a href="#" class="text-xs font-semibold text-[#133E87] hover:underline flex items-center gap-1">
                                <span>Lihat Semua</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                        <!-- Activities list -->
                        <div class="space-y-4">
                            @php
                                $ikonAktivitas = [
                                    'tambah' => ['bg' => 'bg-[#133E87]', 'icon' => 'fa-plus'],
                                    'ubah' => ['bg' => 'bg-emerald-500', 'icon' => 'fa-pencil'],
                                    'daftar' => ['bg' => 'bg-[#7C3AED]', 'icon' => 'fa-users'],
                                    'hapus' => ['bg' => 'bg-amber-500', 'icon' => 'fa-trash-can'],
                                    'sistem' => ['bg' => 'bg-[#133E87]', 'icon' => 'fa-gear'],
                                ];
                            @endphp

                            @forelse ($aktivitasTerbaru as $aktivitas)
                                @php
                                    $konfig = $ikonAktivitas[$aktivitas->tipe] ?? $ikonAktivitas['sistem'];
                                @endphp
                                <div class="flex items-start gap-3.5">
                                    <span class="w-9 h-9 rounded-full {{ $konfig['bg'] }} text-white flex items-center justify-center shrink-0 text-sm shadow-xs mt-0.5">
                                        <i class="fa-solid {{ $konfig['icon'] }}"></i>
                                    </span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 leading-snug">
                                            {{ $aktivitas->deskripsi }}
                                        </p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $aktivitas->created_at->translatedFormat('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 italic">Belum ada aktivitas tercatat.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </main>

        <!-- Dashboard Footer -->
        <footer class="h-14 bg-white border-t border-slate-200/80 px-8 flex items-center justify-between text-xs text-slate-500">
            <p>© 2025 Kamus Bahasa Suku Wemale. Semua hak dilindungi.</p>
            <p class="italic text-[#133E87] font-semibold">Melestarikan Bahasa, Menjaga Budaya</p>
        </footer>

    </div>

</body>
</html>
