@extends('admin.layout')

@section('title', 'Laporan')
@section('page_title', 'Laporan & Analitik Penggunaan Kamus')
@section('page_subtitle', 'Pantau rekapitulasi pencarian kata, tren akses publik, dan log aktivitas sistem')

@section('content')
    <!-- Filter and Export Bar -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-500">Rentang Waktu:</span>
            <select class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                <option selected>7 Hari Terakhir</option>
                <option>30 Hari Terakhir</option>
                <option>Tahun Ini ({{ date('Y') }})</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" 
                    class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-3.5 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-xs transition cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </div>

    <!-- Summary KPI Cards (Murni dari Database) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Total Pencarian Kata</p>
            <h4 class="text-3xl font-black text-[#0C2B5E] mt-1">{{ number_format($totalAktivitas ?? 0, 0, ',', '.') }}</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600 mt-2">
                <i class="fa-solid fa-database text-[10px] mr-1"></i> Tercatat di audit log
            </span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Kata Sorotan Terpopuler</p>
            <h4 class="text-xl font-black text-[#0C2B5E] mt-1 truncate">
                {{ $kataPopulerTeratas ? '"'.$kataPopulerTeratas->kata_wemale.'"' : '-' }}
            </h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-[#133E87] mt-2 truncate">
                <i class="fa-solid fa-star text-[10px] mr-1 text-amber-500"></i> {{ $kataPopulerTeratas?->arti_indonesia ?? 'Belum ada kata' }}
            </span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Rata-rata Akses Harian</p>
            <h4 class="text-3xl font-black text-[#0C2B5E] mt-1">{{ $rataAksesHarian ?? 0 }}</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600 mt-2">
                <i class="fa-solid fa-chart-line text-[10px] mr-1"></i> Kejadian per hari (30 hr)
            </span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Kosakata Baru Bulan Ini</p>
            <h4 class="text-3xl font-black text-[#0C2B5E] mt-1">+{{ $kataBulanIni ?? 0 }}</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600 mt-2">
                <i class="fa-solid fa-calendar-check text-[10px] mr-1"></i> {{ now()->translatedFormat('F Y') }}
            </span>
        </div>
    </div>

    <!-- Charts & Category Breakdown Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Main Activity Chart (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h4 class="font-extrabold text-sm text-[#0C2B5E]">Tren Aktivitas Sistem (7 Hari Terakhir)</h4>
                <span class="text-xs text-slate-400">Data otomatis teragregasi</span>
            </div>
            
            @php
                $trenList = $statistikTren ?? [];
                $nilaiTren = array_map(fn ($d) => $d['nilai'], $trenList);
                $maxTren = count($nilaiTren) > 0 && max($nilaiTren) > 0 ? max($nilaiTren) : 1;
                $titikLaporan = [];
                foreach ($trenList as $i => $hari) {
                    $titikLaporan[] = [
                        'x' => 40 + ($i * 85),
                        'y' => 170 - ($hari['nilai'] / $maxTren) * 130,
                        'label' => $hari['label'],
                        'nilai' => $hari['nilai'],
                    ];
                }
                $pathLaporan = count($titikLaporan) > 0 
                    ? collect($titikLaporan)->map(fn ($p, $i) => ($i === 0 ? 'M' : 'L').' '.$p['x'].' '.$p['y'])->implode(' ') 
                    : 'M 40 170 L 550 170';
            @endphp

            <div class="h-60 w-full pt-2">
                <svg class="w-full h-full" viewBox="0 0 600 200" fill="none">
                    <line x1="30" y1="40" x2="570" y2="40" stroke="#F1F5F9" stroke-dasharray="3 3"/>
                    <line x1="30" y1="80" x2="570" y2="80" stroke="#F1F5F9" stroke-dasharray="3 3"/>
                    <line x1="30" y1="120" x2="570" y2="120" stroke="#F1F5F9" stroke-dasharray="3 3"/>
                    <line x1="30" y1="170" x2="570" y2="170" stroke="#CBD5E1" stroke-width="1.5"/>

                    <path d="{{ $pathLaporan }}" stroke="#133E87" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    
                    @foreach ($titikLaporan as $pt)
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="4.5" fill="#133E87"/>
                        <text x="{{ $pt['x'] }}" y="190" fill="#64748B" font-size="11" font-weight="600" text-anchor="middle">{{ $pt['label'] }}</text>
                        <text x="{{ $pt['x'] }}" y="{{ max(25, $pt['y'] - 8) }}" fill="#0C2B5E" font-size="10" font-weight="bold" text-anchor="middle">{{ $pt['nilai'] }}</text>
                    @endforeach
                </svg>
            </div>
        </div>

        <!-- Category Distribution (5 cols) - Murni dari Database -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-100 shadow-xs">
            <h4 class="font-extrabold text-sm text-[#0C2B5E] pb-3 border-b border-slate-100 mb-4">
                Distribusi Kategori Kosakata
            </h4>
            <div class="space-y-3.5 text-xs">
                @forelse($kategoriDistribusi ?? [] as $kd)
                    <div>
                        <div class="flex justify-between font-bold text-slate-700 mb-1">
                            <span class="truncate max-w-[200px]">{{ $kd['nama'] }}</span>
                            <span class="text-[#133E87] shrink-0">{{ $kd['persen'] }}% ({{ $kd['jumlah'] }} Kata)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-[#133E87] h-full rounded-full transition-all" style="width: {{ min(100, $kd['persen']) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">Belum ada kategori yang memiliki kosakata.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Activity Log Audit Table (Murni dari Database) -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-extrabold text-sm text-[#0C2B5E]">Catatan Riwayat Audit Sistem Terbaru</h4>
            <span class="text-xs text-slate-400">Total {{ $aktivitasTerbaru->count() }} kejadian</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-100">
                        <th class="py-3 px-6">Waktu Kejadian</th>
                        <th class="py-3 px-6">Pelaksana</th>
                        <th class="py-3 px-6">Tipe Aktivitas</th>
                        <th class="py-3 px-6">Deskripsi Aktivitas</th>
                        <th class="py-3 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($aktivitasTerbaru as $log)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-6 font-mono text-slate-500 text-[11px]">
                                {{ $log->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="font-bold text-[#0C2B5E]">{{ $log->user?->name ?? 'Sistem' }}</span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#E1F0FD] text-[#133E87] uppercase">
                                    {{ $log->tipe }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-600">
                                {{ $log->deskripsi }}
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Sukses
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400 italic">
                                Belum ada riwayat aktivitas yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
