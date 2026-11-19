<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Kamus Bahasa Suku Wemale</title>
    
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
                        wemale: {
                            navy: '#0C2B5E',
                            blue: '#133E87',
                            sky: '#2B7BE9',
                        }
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
        }
    </style>
</head>
<body class="bg-[#EEF2F6] min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 antialiased">

    <!-- Card Wrapper matching 1536x1024 mockup layout -->
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 border border-slate-100 relative items-stretch">
        
        <!-- Left Side: Scenery, Brand & Welcome -->
        <div class="lg:col-span-7 relative bg-[#073271] overflow-hidden min-h-[400px] lg:min-h-[540px] flex flex-col justify-between select-none">
            <!-- Scenery image cropped cleanly without baked cut-off text -->
            <img 
                src="{{ asset('img/login-left-clean.png') }}" 
                alt="Kamus Bahasa Suku Wemale Login Banner" 
                class="absolute inset-0 w-full h-full object-cover object-top select-none pointer-events-none"
            />

            <!-- Bottom Welcome Text (Always visible, responsive, never cut off) -->
            <div class="relative z-10 p-7 sm:p-9 text-white mt-auto">
                <div class="w-14 h-1 bg-white/70 rounded-full mb-3"></div>
                <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-white mb-1.5 drop-shadow">Selamat Datang di Panel Admin</h3>
                <p class="text-xs sm:text-sm text-blue-100/90 font-normal leading-relaxed max-w-md drop-shadow">
                    Kelola data kamus Bahasa Suku Wemale dengan mudah dan fitur-fitur pengelolaan data.
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-8 md:p-10 flex flex-col justify-center relative">
            
            <div class="w-full max-w-sm mx-auto">
                <!-- Icon Badge -->
                <div class="flex justify-center mb-5">
                    <div class="w-20 h-20 rounded-full bg-[#E1F0FD] flex items-center justify-center shadow-xs">
                        <div class="w-14 h-14 rounded-full bg-[#133E87] flex items-center justify-center text-white text-xl relative shadow-md">
                            <i class="fa-solid fa-user"></i>
                            <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-white flex items-center justify-center text-[10px] text-[#133E87] shadow-xs">
                                <i class="fa-solid fa-gear"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Header -->
                <div class="text-center mb-5">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0C2B5E] tracking-tight">Login Admin</h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Masuk untuk mengakses panel pengelolaan data</p>
                </div>

                <!-- Session / Validation Alerts -->
                @if (session('error'))
                    <div class="mb-4 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <!-- Username -->
                    <div>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-slate-400 text-sm">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                name="username" 
                                value="{{ old('username') }}"
                                placeholder="Username" 
                                required
                                class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#133E87] focus:bg-white rounded-xl py-2.5 sm:py-3 pl-11 pr-4 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                            />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-slate-400 text-sm">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                id="passwordInput"
                                name="password" 
                                placeholder="Password" 
                                required
                                class="w-full bg-[#F8FAFC] border border-slate-200 focus:border-[#133E87] focus:bg-white rounded-xl py-2.5 sm:py-3 pl-11 pr-11 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-[#133E87]/15 transition"
                            />
                            <button 
                                type="button" 
                                onclick="togglePassword()" 
                                class="absolute right-4 text-slate-400 hover:text-slate-600 transition"
                            >
                                <i id="passwordIcon" class="fa-regular fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-1.5">
                        <button 
                            type="submit" 
                            class="w-full bg-[#133E87] hover:bg-[#0C2B5E] text-white font-semibold py-3 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer text-sm sm:text-base active:scale-[0.99]"
                        >
                            <i class="fa-solid fa-arrow-right-to-bracket text-sm"></i>
                            <span>Login</span>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative flex items-center justify-center my-4">
                    <div class="border-t border-slate-200 w-full"></div>
                    <span class="bg-white px-3 text-xs text-slate-400 font-medium">atau</span>
                    <div class="border-t border-slate-200 w-full"></div>
                </div>

                <!-- Register & Homepage Links -->
                <div class="text-center space-y-2.5">
                    <p class="text-xs sm:text-sm text-slate-600">
                        Belum punya akun? 
                        <a href="{{ url('/register') }}" class="font-bold text-[#133E87] hover:underline underline-offset-4">
                            Daftar di sini
                        </a>
                    </p>
                    <div>
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-[#133E87] transition">
                            <i class="fa-solid fa-house text-[11px]"></i>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('passwordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>
