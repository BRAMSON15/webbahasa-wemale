<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kuis & Latihan Kosakata | Kamus Bahasa Suku Wemale</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        wemale: {
                            navy: '#0C2B5E',
                            blue: '#133E87',
                            sky: '#2B7BE9',
                            light: '#DCEBFB',
                            accent: '#F59E0B',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            overflow-x: hidden;
        }

        .card-custom {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(19, 62, 135, 0.1);
        }

        .option-label:hover {
            border-color: #133E87;
            background-color: #F0F6FF;
        }

        .option-selected {
            border-color: #133E87 !important;
            background-color: #EBF3FE !important;
        }

        .option-selected .option-indicator {
            background-color: #133E87 !important;
            color: white !important;
            border-color: #133E87 !important;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] antialiased min-h-screen flex flex-col justify-between">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            
            <!-- Left: Logo & Title -->
            <a href="{{ route('pengunjung.beranda') }}" class="flex items-center gap-3.5 group">
                <img src="{{ asset('img/nav-logo.png') }}" alt="Logo Kamus Suku Wemale" class="h-11 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                <div>
                    <h1 class="text-base sm:text-lg font-extrabold text-[#0C2B5E] tracking-tight leading-tight group-hover:text-[#2B7BE9] transition-colors">
                        Kamus Bahasa Suku Wemale
                    </h1>
                    <p class="text-[11px] text-slate-500 font-medium tracking-wide">
                        Portal Pembelajaran & Uji Pemahaman Kosakata
                    </p>
                </div>
            </a>

            <!-- Center: Navigation Links (Desktop) -->
            <nav class="hidden lg:flex items-center gap-1.5 bg-slate-50 p-1.5 rounded-full border border-slate-200/80">
                <a href="{{ route('pengunjung.beranda') }}" class="text-slate-700 hover:text-[#133E87] px-4 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100 rounded-full">
                    <i class="fa-solid fa-house text-slate-400"></i>
                    <span>Beranda</span>
                </a>
                
                <a href="{{ route('pengunjung.beranda') }}#kamusSection" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100 rounded-full">
                    <i class="fa-solid fa-book-open text-slate-400"></i>
                    <span>Kamus</span>
                </a>

                <a href="{{ route('pengunjung.beranda') }}#kategoriSection" class="text-slate-700 hover:text-[#133E87] px-3.5 py-2 font-medium flex items-center gap-2 text-sm transition hover:bg-slate-100 rounded-full">
                    <i class="fa-solid fa-table-cells-large text-slate-400"></i>
                    <span>Kategori</span>
                </a>

                <a href="{{ route('pengunjung.kuis') }}" class="bg-[#133E87] text-white px-4 py-2 rounded-full font-semibold flex items-center gap-2 text-sm shadow-sm transition hover:bg-[#0C2B5E]">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                    <span>Kuis Bahasa</span>
                </a>
            </nav>

            <!-- Right: User Profile & Actions -->
            <div class="hidden md:flex items-center gap-3">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-[#0C2B5E] px-3.5 py-2 rounded-full font-bold text-xs flex items-center gap-2 transition">
                        <i class="fa-solid fa-shield-halved text-[#133E87]"></i>
                        <span>Panel Admin</span>
                    </a>
                @endif

                <div class="flex items-center gap-2.5 bg-slate-50 border border-slate-200 py-1.5 pl-2 pr-3.5 rounded-full">
                    <div class="w-8 h-8 rounded-full bg-[#133E87] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-bold text-[#0C2B5E] leading-tight line-clamp-1 max-w-[120px]">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-500 font-medium">{{ Auth::user()->role?->label() ?? 'Pengunjung' }}</p>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition" title="Logout">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-2 lg:hidden">
                <a href="{{ route('pengunjung.beranda') }}" class="text-xs font-bold text-[#133E87] px-3 py-1.5 bg-slate-100 rounded-full">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Beranda
                </a>
            </div>

        </div>
    </header>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-grow">
        
        <!-- ================= HERO SECTION ================= -->
        <section class="relative bg-gradient-to-r from-[#08244F] via-[#0C2B5E] to-[#133E87] text-white overflow-hidden py-10 sm:py-14">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>

            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 relative z-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-sky-200 text-xs font-semibold mb-3">
                            <i class="fa-solid fa-brain"></i>
                            <span>Uji Pemahaman Bahasa Wemale</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight">
                            Asah Penguasaan Bahasa Daerah Suku Wemale
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 font-normal mt-2 leading-relaxed">
                            Jawab pertanyaan kosakata pilihan ganda di bawah ini untuk mengevaluasi pemahaman kosakata, makna istilah adat, dan terjemahan bahasa sehari-hari.
                        </p>
                    </div>

                    <!-- User Quiz Stats -->
                    <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                        <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-4 text-center min-w-[110px]">
                            <p class="text-[11px] text-sky-200 font-medium">Skor Tertinggi</p>
                            <h4 class="text-2xl font-black text-white mt-0.5">{{ $skorTertinggi }}<span class="text-xs font-normal text-sky-200">/100</span></h4>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-4 text-center min-w-[110px]">
                            <p class="text-[11px] text-sky-200 font-medium">Kuis Dikerjakan</p>
                            <h4 class="text-2xl font-black text-white mt-0.5">{{ $totalKuisDikerjakan }} <span class="text-xs font-normal text-sky-200">kali</span></h4>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-4 text-center min-w-[110px]">
                            <p class="text-[11px] text-sky-200 font-medium">Soal Sesi Ini</p>
                            <h4 class="text-2xl font-black text-white mt-0.5">{{ count($soalKuis) }} <span class="text-xs font-normal text-sky-200">soal</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= QUIZ QUESTIONS SECTION ================= -->
        <section class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
            @if(count($soalKuis) === 0)
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#0C2B5E]">Belum Ada Soal Kuis</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                        Saat ini administrator belum mempublikasikan soal kuis aktif. Silakan kembali lagi nanti untuk menguji pemahaman Anda.
                    </p>
                    <a href="{{ route('pengunjung.beranda') }}" class="mt-5 inline-flex items-center gap-2 bg-[#133E87] text-white px-5 py-2.5 rounded-full text-xs font-bold transition hover:bg-[#0C2B5E]">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            @else
                <form id="quizForm" onsubmit="submitKuis(event)" class="space-y-6">
                    @csrf

                    @foreach($soalKuis as $index => $soal)
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xs card-custom quiz-card" data-soal-id="{{ $soal->id }}">
                            <!-- Question Header -->
                            <div class="flex items-center justify-between gap-3 pb-4 border-b border-slate-100 mb-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-full bg-[#E1F0FD] text-[#133E87] font-black text-xs flex items-center justify-center">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Soal {{ $index + 1 }} dari {{ count($soalKuis) }}</span>
                                </div>

                                <div>
                                    @if($soal->tingkat_kesulitan === 'mudah')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Mudah</span>
                                    @elseif($soal->tingkat_kesulitan === 'sedang')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Sedang</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Sulit</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Question Text -->
                            <h3 class="text-base sm:text-lg font-bold text-[#0C2B5E] leading-relaxed mb-6">
                                {{ $soal->pertanyaan }}
                            </h3>

                            <!-- Options Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @php
                                    $options = [
                                        'A' => $soal->pilihan_a,
                                        'B' => $soal->pilihan_b,
                                        'C' => $soal->pilihan_c,
                                        'D' => $soal->pilihan_d,
                                    ];
                                @endphp

                                @foreach($options as $key => $label)
                                    <label class="option-label cursor-pointer flex items-center gap-3.5 p-4 rounded-2xl border border-slate-200 bg-white transition select-none">
                                        <input type="radio" 
                                               name="jawaban[{{ $soal->id }}]" 
                                               value="{{ $key }}" 
                                               class="hidden" 
                                               onchange="handleOptionSelect(this, {{ $soal->id }})">
                                        <span class="option-indicator w-8 h-8 rounded-xl border border-slate-300 bg-slate-50 text-slate-700 font-black text-xs flex items-center justify-center shrink-0 transition">
                                            {{ $key }}
                                        </span>
                                        <span class="text-xs sm:text-sm font-semibold text-slate-700 leading-snug">
                                            {{ $label }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Floating Submit Bar -->
                    <div class="sticky bottom-6 z-30 bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#E1F0FD] text-[#133E87] flex items-center justify-center font-bold text-sm shrink-0">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-[#0C2B5E]">Progres Pengerjaan</p>
                                <p class="text-[11px] text-slate-500 font-medium">
                                    <span id="answeredCount" class="font-bold text-[#133E87]">0</span> dari {{ count($soalKuis) }} soal telah dijawab
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('pengunjung.beranda') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition text-center">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-6 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition">
                                <span>Kirim Jawaban Kuis</span>
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <!-- Riwayat Kuis Terakhir Pengguna -->
            @if(count($riwayatKuis) > 0)
                <div class="mt-12 bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xs">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </span>
                            <h4 class="font-extrabold text-[#0C2B5E] text-sm">Riwayat Kuis Anda Sebelumnya</h4>
                        </div>
                        <span class="text-xs text-slate-400 font-medium">{{ count($riwayatKuis) }} pengerjaan terakhir</span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($riwayatKuis as $riwayat)
                            <div class="py-3.5 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-xl {{ $riwayat->skor >= 80 ? 'bg-emerald-100 text-emerald-700' : ($riwayat->skor >= 60 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }} font-black text-xs flex items-center justify-center">
                                        {{ $riwayat->skor }}
                                    </span>
                                    <div>
                                        <p class="font-bold text-[#0C2B5E]">Skor {{ $riwayat->skor }}/100</p>
                                        <p class="text-[11px] text-slate-400">{{ $riwayat->jawaban_benar }} dari {{ $riwayat->total_soal }} pertanyaan benar</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 text-[11px] font-medium">
                                    {{ $riwayat->created_at->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

    </main>

    <!-- ================= MODAL HASIL KUIS ================= -->
    <div id="modalHasilKuis" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all max-h-[92vh] flex flex-col">
            
            <!-- Result Header Banner -->
            <div id="resultHeader" class="p-8 text-center text-white bg-gradient-to-r from-[#0C2B5E] to-[#133E87] relative">
                <div id="resultBadge" class="w-20 h-20 rounded-full mx-auto flex items-center justify-center text-3xl font-black shadow-lg mb-3 bg-white text-[#133E87]">
                    0
                </div>
                <h3 id="resultTitle" class="text-xl font-black text-white">Selamat!</h3>
                <p id="resultSubtitle" class="text-xs text-sky-200 mt-1 max-w-md mx-auto">
                    Kuis telah selesai dievaluasi oleh sistem kamus.
                </p>
            </div>

            <!-- Result Summary Stats -->
            <div class="grid grid-cols-3 gap-2 p-4 bg-slate-50 border-b border-slate-100 text-center">
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase">Total Soal</p>
                    <p id="resTotal" class="text-base font-extrabold text-[#0C2B5E]">0</p>
                </div>
                <div>
                    <p class="text-[10px] text-emerald-600 font-semibold uppercase">Jawaban Benar</p>
                    <p id="resBenar" class="text-base font-extrabold text-emerald-600">0</p>
                </div>
                <div>
                    <p class="text-[10px] text-rose-500 font-semibold uppercase">Jawaban Salah</p>
                    <p id="resSalah" class="text-base font-extrabold text-rose-500">0</p>
                </div>
            </div>

            <!-- Detailed Evaluation Review List -->
            <div class="p-6 overflow-y-auto space-y-4 flex-grow" id="evaluasiListContainer">
                <!-- Injected via JavaScript -->
            </div>

            <!-- Action Buttons -->
            <div class="p-4 sm:p-5 border-t border-slate-100 bg-white flex items-center justify-between gap-3">
                <a href="{{ route('pengunjung.beranda') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                    Kembali ke Beranda
                </a>
                <button onclick="window.location.reload()" class="bg-[#133E87] hover:bg-[#0C2B5E] text-white px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition">
                    <i class="fa-solid fa-rotate-right text-xs"></i>
                    <span>Coba Kuis Lagi</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-xs text-slate-500">
        <div class="max-w-[1536px] mx-auto px-4">
            <p>&copy; {{ date('Y') }} Kamus Bahasa Suku Wemale. Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>

    <script>
        const totalQuestions = {{ count($soalKuis) }};
        const answersState = {};

        function handleOptionSelect(radioInput, soalId) {
            const card = radioInput.closest('.quiz-card');
            if (!card) return;

            // Remove selected state from all labels in this card
            const labels = card.querySelectorAll('.option-label');
            labels.forEach(l => l.classList.remove('option-selected'));

            // Add selected state to chosen label
            const label = radioInput.closest('.option-label');
            if (label) {
                label.classList.add('option-selected');
            }

            answersState[soalId] = radioInput.value;
            updateAnsweredCount();
        }

        function updateAnsweredCount() {
            const count = Object.keys(answersState).length;
            const counterEl = document.getElementById('answeredCount');
            if (counterEl) {
                counterEl.textContent = count;
            }
        }

        async function submitKuis(event) {
            event.preventDefault();

            const count = Object.keys(answersState).length;
            if (count < totalQuestions) {
                if (!confirm(`Anda baru menjawab ${count} dari ${totalQuestions} soal. Apakah Anda yakin ingin mengirim sekarang?`)) {
                    return;
                }
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Mengevaluasi...</span>`;

            try {
                const response = await fetch("{{ route('pengunjung.kuis.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        jawaban: answersState
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showResultModal(data);
                } else {
                    alert('Terjadi kesalahan saat memproses jawaban kuis.');
                }
            } catch (err) {
                console.error(err);
                alert('Gagal menghubungi server. Periksa koneksi internet Anda.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        }

        function showResultModal(data) {
            document.getElementById('resultBadge').textContent = data.skor;
            document.getElementById('resTotal').textContent = data.total_soal;
            document.getElementById('resBenar').textContent = data.jawaban_benar;
            document.getElementById('resSalah').textContent = data.total_soal - data.jawaban_benar;

            const titleEl = document.getElementById('resultTitle');
            const subtitleEl = document.getElementById('resultSubtitle');

            if (data.skor >= 85) {
                titleEl.textContent = 'Luar Biasa! Sempurna';
                subtitleEl.textContent = 'Anda memiliki penguasaan kosakata bahasa Wemale yang sangat matang.';
            } else if (data.skor >= 65) {
                titleEl.textContent = 'Kerja Bagus!';
                subtitleEl.textContent = 'Pemahaman kosakata Anda cukup baik, terus tingkatkan dengan rajin membaca kamus.';
            } else {
                titleEl.textContent = 'Tetap Semangat Belajar!';
                subtitleEl.textContent = 'Jangan berkecil hati, jelajahi kosakata di kamus dan coba kuis kembali.';
            }

            // Populate evaluasi
            const container = document.getElementById('evaluasiListContainer');
            container.innerHTML = '';

            data.evaluasi.forEach((item, idx) => {
                const isCorrect = item.is_benar;
                const div = document.createElement('div');
                div.className = `p-4 rounded-2xl border text-xs ${isCorrect ? 'bg-emerald-50/60 border-emerald-200' : 'bg-rose-50/60 border-rose-200'}`;
                
                div.innerHTML = `
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5 ${isCorrect ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white'}">
                                ${idx + 1}
                            </span>
                            <p class="font-extrabold text-[#0C2B5E] text-xs leading-snug">${item.pertanyaan}</p>
                        </div>
                        <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-bold ${isCorrect ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'}">
                            ${isCorrect ? 'Benar' : 'Salah'}
                        </span>
                    </div>

                    <div class="mt-2.5 pt-2 border-t ${isCorrect ? 'border-emerald-100' : 'border-rose-100'} flex flex-wrap gap-4 text-[11px]">
                        <div>
                            <span class="text-slate-400">Jawaban Anda:</span>
                            <span class="font-bold ${isCorrect ? 'text-emerald-700' : 'text-rose-700'}">${item.jawaban_pengguna || 'Tidak dijawab'}</span>
                        </div>
                        <div>
                            <span class="text-slate-400">Kunci Jawaban:</span>
                            <span class="font-bold text-slate-800">${item.kunci_jawaban}</span>
                        </div>
                    </div>

                    ${item.pembahasan ? `
                        <div class="mt-2 p-2 rounded-xl bg-white/80 border border-slate-100 text-[11px] text-slate-600">
                            <i class="fa-regular fa-lightbulb text-amber-500 mr-1"></i>
                            <span class="font-semibold text-[#0C2B5E]">Pembahasan:</span> ${item.pembahasan}
                        </div>
                    ` : ''}
                `;

                container.appendChild(div);
            });

            document.getElementById('modalHasilKuis').classList.remove('hidden');
        }
    </script>
</body>
</html>
