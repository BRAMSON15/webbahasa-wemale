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
                <option>7 Hari Terakhir</option>
                <option selected>30 Hari Terakhir</option>
                <option>Kuartal Ini (Q4 2026)</option>
                <option>Tahun Ini (2026)</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="alert('Mengunduh berkas laporan dalam format Excel (.xlsx)...')" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-xs transition">
                <i class="fa-regular fa-file-excel"></i>
                <span>Export Excel</span>
            </button>
            <button onclick="alert('Mencetak laporan dalam format PDF...')" 
                    class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-3.5 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-xs transition">
                <i class="fa-regular fa-file-pdf"></i>
                <span>Download PDF</span>
            </button>
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Total Pencarian Kata</p>
            <h4 class="text-3xl font-black text-[#0C2B5E] mt-1">4.280</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600 mt-2">
                <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i> +14.2% dari bulan lalu
            </span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Kata Paling Sering Dicari</p>
            <h4 class="text-2xl font-black text-[#0C2B5E] mt-1">"Sou" (Bicara)</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-[#133E87] mt-2">
                <i class="fa-solid fa-magnifying-glass text-[10px] mr-1"></i> 342 kali dicari
            </span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Rata-rata Akses Harian</p>
            <h4 class="text-3xl font-black text-[#0C2B5E] mt-1">142</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600 mt-2">
                <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i> Kunjungan per hari
            </span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs">
            <p class="text-xs font-medium text-slate-400">Kosakata Baru Disetujui</p>
            <h4 class="text-3xl font-black text-[#0C2B5E] mt-1">+24</h4>
            <span class="inline-flex items-center text-[11px] font-semibold text-emerald-600 mt-2">
                <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> Lolos kurasi ahli
            </span>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Main Activity Chart (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-100 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h4 class="font-extrabold text-sm text-[#0C2B5E]">Tren Pencarian Kosakata (30 Hari Terakhir)</h4>
                <span class="text-xs text-slate-400">Data otomatis teragregasi</span>
            </div>
            
            <div class="h-60 w-full pt-2">
                <svg class="w-full h-full" viewBox="0 0 600 200" fill="none">
                    <defs>
                        <linearGradient id="lapGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#133E87" stop-opacity="0.2"/>
                            <stop offset="100%" stop-color="#133E87" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>
                    <line x1="30" y1="30" x2="570" y2="30" stroke="#F1F5F9" stroke-dasharray="3 3"/>
                    <line x1="30" y1="80" x2="570" y2="80" stroke="#F1F5F9" stroke-dasharray="3 3"/>
                    <line x1="30" y1="130" x2="570" y2="130" stroke="#F1F5F9" stroke-dasharray="3 3"/>
                    <line x1="30" y1="180" x2="570" y2="180" stroke="#CBD5E1" stroke-width="1.5"/>

                    <path d="M 40 160 Q 120 130 200 110 T 360 80 T 520 40 L 560 50 L 560 180 L 40 180 Z" fill="url(#lapGradient)"/>
                    <path d="M 40 160 Q 120 130 200 110 T 360 80 T 520 40 L 560 50" stroke="#133E87" stroke-width="3" stroke-linecap="round"/>
                    
                    <circle cx="520" cy="40" r="5" fill="#133E87" stroke="#FFFFFF" stroke-width="2"/>
                    <rect x="475" y="10" width="90" height="22" rx="4" fill="#0C2B5E"/>
                    <text x="520" y="25" fill="#FFFFFF" font-size="10" font-weight="bold" text-anchor="middle">Puncak 420 Hits</text>
                </svg>
            </div>
        </div>

        <!-- Category Distribution (5 cols) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-100 shadow-xs">
            <h4 class="font-extrabold text-sm text-[#0C2B5E] pb-3 border-b border-slate-100 mb-4">
                Distribusi Kategori Terpopuler
            </h4>
            <div class="space-y-3.5 text-xs">
                <div>
                    <div class="flex justify-between font-bold text-slate-700 mb-1">
                        <span>Kata Benda (Nomina)</span>
                        <span class="text-[#133E87]">42%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-[#133E87] h-full rounded-full" style="width: 42%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between font-bold text-slate-700 mb-1">
                        <span>Kata Kerja (Verba)</span>
                        <span class="text-emerald-600">28%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 28%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between font-bold text-slate-700 mb-1">
                        <span>Ungkapan Tradisi & Adat</span>
                        <span class="text-amber-500">18%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full rounded-full" style="width: 18%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between font-bold text-slate-700 mb-1">
                        <span>Flora, Fauna & Lingkungan</span>
                        <span class="text-violet-600">12%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-violet-500 h-full rounded-full" style="width: 12%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Audit Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-extrabold text-sm text-[#0C2B5E]">Catatan Riwayat Audit Sistem Terbaru</h4>
            <span class="text-xs text-slate-400">Total {{ $aktivitasTerbaru->count() }} kejadian</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-100">
                        <th class="py-3 px-6">Waktu</th>
                        <th class="py-3 px-6">Pengguna</th>
                        <th class="py-3 px-6">Jenis Aksi</th>
                        <th class="py-3 px-6">Deskripsi Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($aktivitasTerbaru as $akt)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-6 text-slate-400 font-mono text-[11px]">
                                {{ $akt->created_at?->translatedFormat('d M Y • H:i:s') ?? now()->format('d M Y • H:i:s') }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-[#0C2B5E]">
                                {{ $akt->user?->name ?? 'Admin Sistem' }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#E1F0FD] text-[#133E87]">
                                    {{ strtoupper($akt->tipe ?? 'SISTEM') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-600">
                                {{ $akt->deskripsi }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada riwayat aktivitas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
