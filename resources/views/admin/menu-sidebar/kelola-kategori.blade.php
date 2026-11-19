@extends('admin.layout')

@section('title', 'Kelola Kategori')
@section('page_title', 'Kelola Kategori Kosakata')
@section('page_subtitle', 'Pengelompokan kosakata berdasarkan bidang tata bahasa, konteks adat, dan aktivitas harian')

@section('content')
    <!-- KPI Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#FEF3C7] text-[#F59E0B] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-table-cells-large"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ number_format($totalKategori ?? 0, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-500 font-medium">Total Kategori Terdaftar</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ $kategoriTerbanyak?->nama_kategori ?? '-' }}</h4>
                <p class="text-xs text-slate-500 font-medium">Kategori Terbanyak Kata</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#D1FAE5] text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ $persenTerisi ?? 0 }}%</h4>
                <p class="text-xs text-slate-500 font-medium">Kategori Terisi Kosakata</p>
            </div>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <!-- Action Header -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold text-[#0C2B5E]">Daftar Kategori Kamus</h3>
                <p class="text-xs text-slate-500">Kelompokkan kosakata untuk memudahkan pencarian pengguna dan pelajar</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Search input -->
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" placeholder="Cari kategori..." oninput="filterKategoriTable(this.value)"
                           class="bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20 w-44 sm:w-56">
                </div>

                <button onclick="document.getElementById('modalTambahKategori').classList.remove('hidden')" 
                        class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="kategoriTable">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">No</th>
                        <th class="py-3.5 px-6">Nama Kategori</th>
                        <th class="py-3.5 px-6">Slug Sistem</th>
                        <th class="py-3.5 px-6">Deskripsi Kategori</th>
                        <th class="py-3.5 px-6 text-center">Jumlah Kata</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                    @forelse($kategoris as $index => $kat)
                        <tr class="hover:bg-slate-50/60 transition kategori-row" data-name="{{ strtolower($kat->nama_kategori) }}" data-desc="{{ strtolower($kat->deskripsi ?? '') }}">
                            <td class="py-4 px-6 text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <span class="font-extrabold text-[#0C2B5E] text-sm">{{ $kat->nama_kategori }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <code class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-mono text-[11px]">{{ $kat->slug }}</code>
                            </td>
                            <td class="py-4 px-6 text-slate-500 max-w-sm">
                                {{ $kat->deskripsi ?? 'Kategori umum kamus bahasa Wemale.' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-[#E1F0FD] text-[#133E87]">
                                    {{ $kat->katas_count ?? $kat->katas()->count() }} Kata
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" 
                                            onclick="openEditKategoriModal({{ json_encode($kat) }})" 
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-[#133E87] hover:bg-slate-100 transition" 
                                            title="Edit Kategori">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.kelola-kategori.destroy', $kat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori &quot;{{ $kat->nama_kategori }}&quot;? Kosakata di dalam kategori ini tidak akan terhapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Kategori">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300"></i>
                                <p class="text-sm font-semibold">Belum ada kategori yang dibuat.</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Tambah Kategori" untuk membuat kategori baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="modalTambahKategori" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <h3 class="text-lg font-bold text-[#0C2B5E]">Tambah Kategori Baru</h3>
                <button type="button" onclick="document.getElementById('modalTambahKategori').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.kelola-kategori.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_kategori" required placeholder="Contoh: Kata Benda, Kata Kerja, Istilah Adat" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan jenis kata yang masuk dalam kategori ini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div class="pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalTambahKategori').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                    <button type="submit" class="bg-[#133E87] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:bg-[#0C2B5E] transition flex items-center gap-1.5">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Kategori</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="modalEditKategori" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <h3 class="text-lg font-bold text-[#0C2B5E]">Edit Kategori</h3>
                <button type="button" onclick="document.getElementById('modalEditKategori').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="formEditKategori" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" id="editNamaKategori" name="nama_kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea id="editDeskripsiKategori" name="deskripsi" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div class="pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalEditKategori').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                    <button type="submit" class="bg-[#133E87] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:bg-[#0C2B5E] transition flex items-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditKategoriModal(kat) {
            const form = document.getElementById('formEditKategori');
            form.action = `/admin/kelola-kategori/${kat.id}`;

            document.getElementById('editNamaKategori').value = kat.nama_kategori || '';
            document.getElementById('editDeskripsiKategori').value = kat.deskripsi || '';

            document.getElementById('modalEditKategori').classList.remove('hidden');
        }

        function filterKategoriTable(query) {
            const q = query.toLowerCase();
            document.querySelectorAll('.kategori-row').forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const desc = row.getAttribute('data-desc') || '';
                if (name.includes(q) || desc.includes(q)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }
    </script>
@endsection
