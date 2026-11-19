@extends('admin.layout')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Kelola Pengguna & Hak Akses')
@section('page_subtitle', 'Manajemen akun pengguna terdaftar, verifikasi peran, dan otorisasi administrator')

@section('content')
    <!-- KPI Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#D1FAE5] text-[#10B981] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ number_format($totalPengguna ?? 0, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-500 font-medium">Total Akun</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ $totalAdmin ?? 1 }}</h4>
                <p class="text-xs text-slate-500 font-medium">Administrator</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">{{ max(0, ($totalPengguna ?? 1) - ($totalAdmin ?? 1)) }}</h4>
                <p class="text-xs text-slate-500 font-medium">Pengguna Umum</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-signal"></i>
            </div>
            <div>
                <h4 class="text-2xl font-black text-[#0C2B5E]">98%</h4>
                <p class="text-xs text-slate-500 font-medium">Tingkat Aktivitas</p>
            </div>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <!-- Action Header -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold text-[#0C2B5E]">Daftar Akun Pengguna</h3>
                <p class="text-xs text-slate-500">Kelola izin peran admin, kontributor, dan pengguna umum</p>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('modalTambahPengguna').classList.remove('hidden')" 
                        class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Tambah Pengguna</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Pengguna</th>
                        <th class="py-3.5 px-6">Username / Email</th>
                        <th class="py-3.5 px-6">Peran Akses</th>
                        <th class="py-3.5 px-6">Terdaftar Sejak</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#E1F0FD] text-[#133E87] font-extrabold flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#0C2B5E] text-sm">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-800">{{ $user->email }}</p>
                                <p class="text-[11px] text-slate-400 font-mono">@<span>{{ $user->username ?? 'user' }}</span></p>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->role?->value === 'admin' || $user->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#133E87] text-white">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i> Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        <i class="fa-solid fa-user text-[9px]"></i> {{ $user->role?->label() ?? 'Pengguna' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $user->created_at?->translatedFormat('d M Y') ?? 'Baru saja' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <button class="p-1.5 rounded-lg text-slate-500 hover:text-[#133E87] hover:bg-slate-100 transition" title="Ubah Peran">
                                        <i class="fa-solid fa-user-pen text-xs"></i>
                                    </button>
                                    <button class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Akun">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-users-slash text-3xl mb-2 text-slate-300"></i>
                                <p class="text-sm font-semibold">Belum ada akun pengguna.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div id="modalTambahPengguna" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <h3 class="text-lg font-bold text-[#0C2B5E]">Tambah Akun Pengguna</h3>
                <button onclick="document.getElementById('modalTambahPengguna').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" placeholder="Nama lengkap..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email</label>
                    <input type="email" placeholder="email@wemale.test" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peran Akun</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                        <option value="pengguna">Pengguna Umum</option>
                        <option value="penutur">Penutur Asli / Kontributor</option>
                        <option value="pelajar">Pelajar / Peneliti</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password Sementara</label>
                    <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#133E87]/20">
                </div>

                <div class="pt-3 flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambahPengguna').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                    <button type="button" onclick="alert('Pengguna baru berhasil ditambahkan'); document.getElementById('modalTambahPengguna').classList.add('hidden');" class="bg-[#133E87] text-white px-5 py-2 rounded-xl text-xs font-bold shadow-md hover:bg-[#0C2B5E] transition">Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
@endsection
