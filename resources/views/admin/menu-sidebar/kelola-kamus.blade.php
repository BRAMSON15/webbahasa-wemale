@extends('admin.layout')

@section('title', 'Kelola Kamus')
@section('page_title', 'Kelola Kamus Bahasa Suku Wemale')
@section('page_subtitle', 'Manajemen data kosakata, arti, contoh kalimat, dan status populer')

@section('content')
    <!-- Top KPI Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ number_format($totalKata ?? 0, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-500 font-medium">Total Kosakata</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ $totalPopuler ?? 0 }}</h4>
                <p class="text-xs text-slate-500 font-medium">Kata Populer</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-table-cells-large"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ $totalKategori ?? 0 }}</h4>
                <p class="text-xs text-slate-500 font-medium">Kategori Terkait</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">+18</h4>
                <p class="text-xs text-slate-500 font-medium">Penambahan Bulan Ini</p>
            </div>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <!-- Action Header -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold text-[#0C2B5E]">Daftar Kosakata Bahasa Wemale</h3>
                <p class="text-xs text-slate-500">Kelola dan perbarui seluruh entri kosakata kamus daerah</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Search bar -->
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Cari kata atau arti..." 
                           class="bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20 w-48 sm:w-64">
                </div>

                <!-- Add button -->
                <button onclick="document.getElementById('modalTambahKata').classList.remove('hidden')" 
                        class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kata</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">No</th>
                        <th class="py-3.5 px-6">Kata Wemale</th>
                        <th class="py-3.5 px-6">Arti Indonesia</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Contoh & Arti</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                    @forelse($katas as $index => $kata)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6 text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <span class="font-extrabold text-[#0C2B5E] text-sm">{{ $kata->kata_wemale }}</span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">{{ $kata->arti_indonesia }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#E1F0FD] text-[#133E87]">
                                    {{ $kata->kategori?->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 max-w-xs truncate text-slate-500">
                                @if($kata->contoh)
                                    <span class="italic">"{{ $kata->contoh }}"</span>
                                    @if($kata->terjemahan_contoh)
                                        <span class="block text-[10px] text-slate-400">({{ $kata->terjemahan_contoh }})</span>
                                    @endif
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($kata->is_populer)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                        <i class="fa-solid fa-star text-[8px]"></i> Populer
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500">
                                        Standar
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <button class="p-1.5 rounded-lg text-slate-500 hover:text-[#133E87] hover:bg-slate-100 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    <button class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-book-open text-3xl mb-2 text-slate-300"></i>
                                <p class="text-sm font-semibold">Belum ada kosakata yang tercatat.</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Tambah Kata" untuk menambahkan kosakata baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Kata -->
    <div id="modalTambahKata" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <h3 class="text-lg font-bold text-[#0C2B5E]">Tambah Kosakata Baru</h3>
                <button onclick="document.getElementById('modalTambahKata').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kosakata Bahasa Wemale</label>
                    <input type="text" placeholder="Contoh: Male, Sou, dll." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Arti Bahasa Indonesia</label>
                    <input type="text" placeholder="Contoh: Manusia, Bicara, dll." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                        @foreach($kategoris ?? [] as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contoh Kalimat (Wemale)</label>
                    <textarea rows="2" placeholder="Contoh penggunaan kata dalam kalimat..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Terjemahan Contoh (Indonesia)</label>
                    <textarea rows="2" placeholder="Arti dari kalimat contoh..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="populerCheck" class="rounded text-[#133E87] focus:ring-0">
                    <label for="populerCheck" class="text-xs font-semibold text-slate-700 cursor-pointer">Tandai sebagai Kata Populer</label>
                </div>

                <div class="pt-3 flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambahKata').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                    <button type="button" onclick="alert('Kosakata berhasil disimpan'); document.getElementById('modalTambahKata').classList.add('hidden');" class="bg-[#133E87] text-white px-5 py-2 rounded-xl text-xs font-bold shadow-md hover:bg-[#0C2B5E] transition">Simpan Kosakata</button>
                </div>
            </form>
        </div>
    </div>
@endsection
