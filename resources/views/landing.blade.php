<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBASN - Inspektorat Puncak Jaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Elegant Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #030712; /* Tailwind gray-950 fallback */
            background-image: linear-gradient(rgba(3, 7, 18, 0.85), rgba(3, 7, 18, 0.95)), url('{{ asset("bg-mulia.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #f9fafb; 
        }
        h1, h2, h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.02em;
        }
        .hero-glow {
            background: radial-gradient(circle at 50% 0%, rgba(56, 189, 248, 0.15), transparent 60%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #e0f2fe 0%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass-btn {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative selection:bg-sky-900 selection:text-sky-100">

    <!-- Subtle Background Glow -->
    <div class="absolute inset-0 hero-glow pointer-events-none z-0"></div>

    <!-- Minimalist Navbar -->
    <nav class="relative z-10 w-full py-6">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo_puncak_jaya.png') }}" alt="Logo Puncak Jaya" class="w-12 h-12 object-contain drop-shadow-md">
                    <img src="{{ asset('logo-inspektorat.png') }}" alt="Logo Inspektorat" class="w-12 h-12 object-contain drop-shadow-md">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg leading-none tracking-wide text-gray-100 uppercase">Inspektorat</span>
                    <span class="text-[10px] tracking-widest text-sky-400 font-semibold uppercase">Puncak Jaya</span>
                </div>
            </div>
            
            <div>
                <a href="{{ route('login') }}" class="glass-btn px-6 py-2.5 rounded-full text-sm font-medium tracking-wide transition-all duration-300 flex items-center gap-2 text-gray-200">
                    Masuk <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Hero Content -->
    <main class="flex-grow flex items-center relative z-10 -mt-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full text-center">
            
            <div class="mb-8 inline-flex items-center justify-center">
                <span class="px-4 py-1.5 rounded-full border border-sky-900/50 bg-sky-950/30 text-sky-300 text-xs font-medium tracking-widest uppercase shadow-inner">
                    Sistem Basis Data ASN
                </span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight leading-tight max-w-4xl mx-auto">
                Kelola Profil Kepegawaian <br class="hidden md:block"/>
                Secara <span class="text-gradient italic">Eksklusif & Aman</span>.
            </h1>
            
            <p class="text-gray-400 text-lg md:text-xl font-light mb-12 max-w-2xl mx-auto leading-relaxed">
                Platform tertutup khusus Inspektorat Kabupaten Puncak Jaya untuk manajemen demografi, pengarsipan digital, dan analitik Aparatur Sipil Negara secara komprehensif.
            </p>
            
            <div class="flex items-center justify-center">
                <a href="{{ route('login') }}" class="bg-gray-100 hover:bg-white text-gray-950 px-8 py-3.5 rounded-full text-base font-medium transition-all duration-300 transform hover:scale-105 shadow-[0_0_30px_rgba(255,255,255,0.1)] flex items-center gap-2">
                    Akses Dashboard <span class="material-symbols-outlined">lock_open</span>
                </a>
            </div>

            <!-- Minimalist Stats/Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24 max-w-4xl mx-auto border-t border-white/5 pt-12">
                <div class="flex flex-col items-center">
                    <span class="material-symbols-outlined text-sky-400 text-3xl mb-3">shield_lock</span>
                    <h3 class="font-bold text-lg text-gray-200 mb-1">Keamanan Ketat</h3>
                    <p class="text-xs text-gray-500 font-light text-center">Akses eksklusif, terenkripsi, dan dibatasi hanya untuk internal Inspektorat.</p>
                </div>
                <div class="flex flex-col items-center">
                    <span class="material-symbols-outlined text-sky-400 text-3xl mb-3">folder_open</span>
                    <h3 class="font-bold text-lg text-gray-200 mb-1">Arsip Digital</h3>
                    <p class="text-xs text-gray-500 font-light text-center">Penyimpanan dokumen pegawai tanpa kertas yang terorganisir dengan rapi.</p>
                </div>
                <div class="flex flex-col items-center">
                    <span class="material-symbols-outlined text-sky-400 text-3xl mb-3">insights</span>
                    <h3 class="font-bold text-lg text-gray-200 mb-1">Analitik Visual</h3>
                    <p class="text-xs text-gray-500 font-light text-center">Pemetaan dan statistik data ASN real-time untuk pengambilan keputusan.</p>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full py-8 text-center text-gray-600 text-xs font-light">
        <p>&copy; {{ date('Y') }} Inspektorat Kabupaten Puncak Jaya. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
