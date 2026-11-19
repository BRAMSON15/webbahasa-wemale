@extends('admin.layout')

@section('title', 'Informasi Website')
@section('page_title', 'Informasi & Profil Website')
@section('page_subtitle', 'Identitas Kamus Bahasa Suku Wemale, dokumentasi kearifan lokal, dan kontak pengembang')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Form Editor (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <form action="{{ route('admin.informasi-website.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Identitas Umum -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-xs">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-[#E1F0FD] text-[#133E87] flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-globe"></i>
                        </span>
                        <div>
                            <h3 class="font-extrabold text-base text-[#0C2B5E]">Identitas Utama Website</h3>
                            <p class="text-xs text-slate-500">Nama platform, slogan kebudayaan, dan deskripsi publik</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Nama Platform Kamus <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_platform" required value="Kamus Bahasa Suku Wemale" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Slogan Kebudayaan</label>
                            <input type="text" name="slogan" value="Lestarikan Bahasa Daerah, Perkuat Identitas Budaya" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Deskripsi Singkat Platform</label>
                            <textarea name="deskripsi" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none leading-relaxed">Platform digital interaktif untuk mendokumentasikan, mempelajari, dan melestarikan kosakata, tata bahasa, serta tradisi tutur lisan Bahasa Suku Wemale di Pulau Seram, Provinsi Maluku.</textarea>
                        </div>
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-xs">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-compass"></i>
                        </span>
                        <div>
                            <h3 class="font-extrabold text-base text-[#0C2B5E]">Visi & Misi Pelestarian</h3>
                            <p class="text-xs text-slate-500">Arah strategis digitalisasi bahasa daerah Wemale</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Visi Utama</label>
                            <textarea name="visi" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none">Menjadi pusat dokumentasi digital bahasa dan kearifan lokal Suku Wemale yang terpercaya, mudah diakses generasi muda, dan berkelanjutan.</textarea>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5">Misi Pelestarian</label>
                            <textarea name="misi" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-[#133E87]/20 focus:outline-none leading-relaxed">1. Mendokumentasikan leksikon bahasa Wemale ragam Utara dan Selatan.
2. Menyediakan kamus daring interaktif dengan contoh kalimat dan terjemahan.
3. Melibatkan para tetua adat, penutur asli, dan pemuda dalam pengayaan kosakata.
4. Mencegah kepunahan bahasa daerah melalui kurikulum edukasi berbasis web.</textarea>
                        </div>
                    </div>
                </div>

                <!-- Save Action Button -->
                <div class="flex justify-end gap-3">
                    <button type="submit" 
                            class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-6 py-2.5 rounded-xl font-bold text-xs shadow-md transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span>Simpan Perubahan Informasi</span>
                    </button>
                </div>
            </form>

        </div>

        <!-- Right: Culture Summary Card (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Profil Suku Wemale Card -->
            <div class="bg-gradient-to-br from-[#0A2D63] to-[#133E87] text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-monument text-9xl"></i>
                </div>
                
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold bg-white/20 text-white mb-3">
                    Konteks Budaya
                </span>
                
                <h4 class="text-lg font-black tracking-tight mb-2">Mengenal Suku Wemale</h4>
                <p class="text-xs text-blue-100 leading-relaxed mb-4">
                    Suku Wemale adalah salah satu kelompok masyarakat adat tertua di Pulau Seram bagian barat, Maluku. Bahasa Wemale tergolong dalam rumpun bahasa Austronesia dan kaya akan filosofi hidup rukun bersama alam.
                </p>

                <div class="space-y-2 text-xs border-t border-white/10 pt-3">
                    <div class="flex justify-between py-1">
                        <span class="text-blue-200">Wilayah Sebaran:</span>
                        <span class="font-bold text-white">Kab. Seram Bagian Barat</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-blue-200">Dialek Utama:</span>
                        <span class="font-bold text-white">Wemale Utara & Selatan</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-blue-200">Status Vitalitas:</span>
                        <span class="font-bold text-amber-300">Terancam Punah (Perlu Revitalisasi)</span>
                    </div>
                </div>
            </div>

            <!-- Kontak Pengelola -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-xs text-xs space-y-3">
                <h4 class="font-extrabold text-[#0C2B5E] text-sm pb-2 border-b border-slate-100">
                    Kontak & Sekretariat Redaksi
                </h4>
                <div class="flex items-center gap-3 text-slate-600">
                    <i class="fa-solid fa-location-dot text-[#133E87] w-4 text-center"></i>
                    <span>Pulau Seram, Maluku, Indonesia</span>
                </div>
                <div class="flex items-center gap-3 text-slate-600">
                    <i class="fa-solid fa-envelope text-[#133E87] w-4 text-center"></i>
                    <span>info@kamus-wemale.org</span>
                </div>
                <div class="flex items-center gap-3 text-slate-600">
                    <i class="fa-solid fa-phone text-[#133E87] w-4 text-center"></i>
                    <span>+62 812-3456-7890</span>
                </div>
            </div>

        </div>

    </div>
@endsection
