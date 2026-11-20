@extends('admin.layout')

@section('title', 'Kelola Kuis')
@section('page_title', 'Kelola Kuis Bahasa Wemale')
@section('page_subtitle', 'Kelola bank soal evaluasi pemahaman kosakata dan tata bahasa Wemale untuk pengunjung')

@section('content')
    <!-- KPI Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ number_format($totalSoal, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-500 font-medium">Total Bank Soal</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#D1FAE5] text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ number_format($totalAktif, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-500 font-medium">Soal Kuis Aktif</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#FEF3C7] text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ number_format($totalRiwayat, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-500 font-medium">Kuis Diselesaikan</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-award"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ $rataSkor }}</h4>
                <p class="text-xs text-slate-500 font-medium">Rata-rata Skor (/100)</p>
            </div>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <!-- Action Header -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold text-[#0C2B5E]">Daftar Soal Kuis</h3>
                <p class="text-xs text-slate-500">Pertanyaan pilihan ganda untuk menguji penguasaan kosakata bahasa Wemale</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Kesulitan Filter -->
                <select id="filterKesulitan" onchange="filterSoalTable()" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    <option value="">Semua Tingkat</option>
                    <option value="mudah">Mudah</option>
                    <option value="sedang">Sedang</option>
                    <option value="sulit">Sulit</option>
                </select>

                <!-- Search input -->
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Cari pertanyaan kuis..." oninput="filterSoalTable()"
                           class="bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20 w-44 sm:w-56">
                </div>

                <button onclick="document.getElementById('modalTambahSoal').classList.remove('hidden')" 
                        class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Soal</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="soalTable">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">No</th>
                        <th class="py-3.5 px-6">Pertanyaan & Pembahasan</th>
                        <th class="py-3.5 px-6">Pilihan Jawaban</th>
                        <th class="py-3.5 px-6 text-center">Tingkat</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                    @forelse($soalList as $index => $soal)
                        <tr class="hover:bg-slate-50/60 transition soal-row" 
                            data-pertanyaan="{{ strtolower($soal->pertanyaan) }}" 
                            data-kesulitan="{{ strtolower($soal->tingkat_kesulitan) }}">
                            <td class="py-4 px-6 text-slate-400 font-bold">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 max-w-md">
                                <p class="font-extrabold text-[#0C2B5E] text-sm leading-snug">{{ $soal->pertanyaan }}</p>
                                @if($soal->pembahasan)
                                    <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">
                                        <i class="fa-regular fa-lightbulb text-amber-500 mr-1"></i>{{ $soal->pembahasan }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="grid grid-cols-2 gap-1.5 text-[11px] min-w-[260px]">
                                    <span class="px-2 py-1 rounded {{ $soal->kunci_jawaban === 'A' ? 'bg-emerald-100 text-emerald-800 font-bold border border-emerald-300' : 'bg-slate-100 text-slate-600' }}">
                                        A. {{ $soal->pilihan_a }}
                                    </span>
                                    <span class="px-2 py-1 rounded {{ $soal->kunci_jawaban === 'B' ? 'bg-emerald-100 text-emerald-800 font-bold border border-emerald-300' : 'bg-slate-100 text-slate-600' }}">
                                        B. {{ $soal->pilihan_b }}
                                    </span>
                                    <span class="px-2 py-1 rounded {{ $soal->kunci_jawaban === 'C' ? 'bg-emerald-100 text-emerald-800 font-bold border border-emerald-300' : 'bg-slate-100 text-slate-600' }}">
                                        C. {{ $soal->pilihan_c }}
                                    </span>
                                    <span class="px-2 py-1 rounded {{ $soal->kunci_jawaban === 'D' ? 'bg-emerald-100 text-emerald-800 font-bold border border-emerald-300' : 'bg-slate-100 text-slate-600' }}">
                                        D. {{ $soal->pilihan_d }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($soal->tingkat_kesulitan === 'mudah')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">
                                        Mudah
                                    </span>
                                @elseif($soal->tingkat_kesulitan === 'sedang')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700">
                                        Sedang
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700">
                                        Sulit
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($soal->is_aktif)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600">
                                        <i class="fa-solid fa-circle text-[8px]"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-400">
                                        <i class="fa-regular fa-circle text-[8px]"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" 
                                            onclick="openEditSoalModal({{ json_encode($soal) }})" 
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-[#133E87] hover:bg-slate-100 transition" 
                                            title="Edit Soal Kuis">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.kelola-kuis.destroy', $soal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal kuis ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Soal Kuis">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-circle-question text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada soal kuis yang terdaftar di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Soal Kuis -->
    <div id="modalTambahSoal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-[#0C2B5E]">Tambah Soal Kuis Baru</h3>
                    <p class="text-xs text-slate-500">Masukkan pertanyaan dan empat opsi pilihan jawaban</p>
                </div>
                <button type="button" onclick="document.getElementById('modalTambahSoal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form action="{{ route('admin.kelola-kuis.store') }}" method="POST" class="p-6 space-y-4 overflow-y-auto">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pertanyaan Kuis <span class="text-rose-500">*</span></label>
                    <textarea name="pertanyaan" rows="3" required placeholder="Contoh: Apa arti kata 'Lumau' dalam bahasa Indonesia?" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">{{ old('pertanyaan') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan A <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_a" required placeholder="Pilihan jawaban A" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan B <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_b" required placeholder="Pilihan jawaban B" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan C <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_c" required placeholder="Pilihan jawaban C" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan D <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_d" required placeholder="Pilihan jawaban D" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kunci Jawaban Benar <span class="text-rose-500">*</span></label>
                        <select name="kunci_jawaban" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                            <option value="A">Pilihan A</option>
                            <option value="B">Pilihan B</option>
                            <option value="C">Pilihan C</option>
                            <option value="D">Pilihan D</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat Kesulitan <span class="text-rose-500">*</span></label>
                        <select name="tingkat_kesulitan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                            <option value="mudah">Mudah</option>
                            <option value="sedang" selected>Sedang</option>
                            <option value="sulit">Sulit</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Penjelasan / Pembahasan (Opsional)</label>
                    <textarea name="pembahasan" rows="2" placeholder="Penjelasan asal-usul arti atau konteks budaya jawaban..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_aktif" id="tambah_is_aktif" value="1" checked class="w-4 h-4 rounded text-[#133E87] focus:ring-[#133E87]">
                    <label for="tambah_is_aktif" class="text-xs font-bold text-slate-700">Aktifkan soal ini langsung untuk kuis pengunjung</label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('modalTambahSoal').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                    <button type="submit" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-5 py-2 rounded-xl text-xs font-bold shadow-sm transition">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Soal Kuis -->
    <div id="modalEditSoal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-[#0C2B5E]">Edit Soal Kuis</h3>
                    <p class="text-xs text-slate-500">Perbarui pertanyaan, pilihan opsi, atau kunci jawaban</p>
                </div>
                <button type="button" onclick="document.getElementById('modalEditSoal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form id="formEditSoal" method="POST" class="p-6 space-y-4 overflow-y-auto">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pertanyaan Kuis <span class="text-rose-500">*</span></label>
                    <textarea name="pertanyaan" id="edit_pertanyaan" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan A <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_a" id="edit_pilihan_a" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan B <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_b" id="edit_pilihan_b" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan C <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_c" id="edit_pilihan_c" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilihan D <span class="text-rose-500">*</span></label>
                        <input type="text" name="pilihan_d" id="edit_pilihan_d" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kunci Jawaban Benar <span class="text-rose-500">*</span></label>
                        <select name="kunci_jawaban" id="edit_kunci_jawaban" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                            <option value="A">Pilihan A</option>
                            <option value="B">Pilihan B</option>
                            <option value="C">Pilihan C</option>
                            <option value="D">Pilihan D</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat Kesulitan <span class="text-rose-500">*</span></label>
                        <select name="tingkat_kesulitan" id="edit_tingkat_kesulitan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                            <option value="mudah">Mudah</option>
                            <option value="sedang">Sedang</option>
                            <option value="sulit">Sulit</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Penjelasan / Pembahasan (Opsional)</label>
                    <textarea name="pembahasan" id="edit_pembahasan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#133E87]/20"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_aktif" id="edit_is_aktif" value="1" class="w-4 h-4 rounded text-[#133E87] focus:ring-[#133E87]">
                    <label for="edit_is_aktif" class="text-xs font-bold text-slate-700">Aktifkan soal ini untuk kuis pengunjung</label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('modalEditSoal').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">Batal</button>
                    <button type="submit" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-5 py-2 rounded-xl text-xs font-bold shadow-sm transition">Perbarui Soal</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function filterSoalTable() {
        const query = (document.getElementById('searchInput').value || '').toLowerCase().trim();
        const level = (document.getElementById('filterKesulitan').value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('.soal-row');

        rows.forEach(row => {
            const pertanyaan = row.getAttribute('data-pertanyaan') || '';
            const kesulitan = row.getAttribute('data-kesulitan') || '';

            const matchQuery = !query || pertanyaan.includes(query);
            const matchLevel = !level || kesulitan === level;

            if (matchQuery && matchLevel) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function openEditSoalModal(soal) {
        document.getElementById('formEditSoal').action = `/admin/kelola-kuis/${soal.id}`;
        document.getElementById('edit_pertanyaan').value = soal.pertanyaan;
        document.getElementById('edit_pilihan_a').value = soal.pilihan_a;
        document.getElementById('edit_pilihan_b').value = soal.pilihan_b;
        document.getElementById('edit_pilihan_c').value = soal.pilihan_c;
        document.getElementById('edit_pilihan_d').value = soal.pilihan_d;
        document.getElementById('edit_kunci_jawaban').value = soal.kunci_jawaban;
        document.getElementById('edit_tingkat_kesulitan').value = soal.tingkat_kesulitan;
        document.getElementById('edit_pembahasan').value = soal.pembahasan || '';
        document.getElementById('edit_is_aktif').checked = Boolean(soal.is_aktif);

        document.getElementById('modalEditSoal').classList.remove('hidden');
    }
</script>
@endpush
