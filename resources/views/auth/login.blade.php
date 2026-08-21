<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - DBASN Puncak Jaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="antialiased bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center hero-gradient relative overflow-hidden selection:bg-sky-500/30 selection:text-sky-200">
    
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-sky-500/20 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-600/20 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="w-full max-w-md px-4 relative z-10">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-16 h-auto drop-shadow-md flex items-center justify-center transition-all duration-300 transform group-hover:scale-105">
                    <img src="{{ asset('logo_puncak_jaya.png') }}" alt="Logo Puncak Jaya" class="w-full h-auto">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-3xl tracking-tight text-white leading-none uppercase">Inspektorat</span>
                    <span class="text-xs tracking-widest text-sky-400 font-semibold uppercase mt-1">Puncak Jaya</span>
                </div>
            </a>
        </div>

        <!-- Login Card -->
        <div class="glass-panel p-8 rounded-3xl shadow-2xl relative overflow-hidden">
            <!-- Shimmer effect -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sky-500 via-indigo-500 to-sky-500"></div>

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Selamat Datang Kembali</h2>
                <p class="text-slate-400 text-sm">Masuk untuk mengelola data kepegawaian rahasia.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl mb-6 text-sm flex gap-3 items-start">
                    <span class="material-symbols-outlined text-[20px] shrink-0">error</span>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-300 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-500 text-[20px]">mail</span>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-all placeholder-slate-500 text-sm"
                            placeholder="admin@dbasn.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-300 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-slate-500 text-[20px]">lock</span>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none transition-all placeholder-slate-500 text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold py-3.5 px-4 rounded-xl shadow-[0_0_20px_rgba(56,189,248,0.3)] transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                        Masuk ke Sistem <span class="material-symbols-outlined text-[20px]">login</span>
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-slate-500 text-xs mt-8 font-medium">
            Sistem tertutup. Dikelola oleh Inspektorat Kabupaten Puncak Jaya.
        </p>
    </div>

</body>
</html>
