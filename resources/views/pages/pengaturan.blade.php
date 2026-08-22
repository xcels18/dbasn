<x-layout title="Pengaturan - Inspektorat Puncak Jaya">
    <!-- Breadcrumbs & Header -->
    <div class="px-margin-desktop pt-8 pb-6 flex flex-col gap-4">
        <nav class="flex items-center text-on-surface-variant text-label-sm font-label-sm gap-2">
            <span class="material-symbols-outlined text-[16px]">home</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-bold">Pengaturan</span>
        </nav>
        <div>
            <h1 class="text-headline-lg font-headline-lg text-primary">Pengaturan Sistem</h1>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Konfigurasi database, pengaturan integrasi, dan kredensial admin.</p>
        </div>
        
        @if(session('success'))
            <div class="bg-status-success/10 border border-status-success text-status-success px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-status-error/10 border border-status-error text-status-error px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                {{ $errors->first() }}
            </div>
        @endif
    </div>

    <!-- Configuration Options -->
    <div class="px-margin-desktop pb-margin-desktop max-w-[800px] space-y-6">
        <!-- Card 1: General Settings -->
        <div class="bg-surface-card border border-border-subtle rounded-lg p-6 shadow-sm space-y-4">
            <h3 class="text-label-lg font-label-lg text-primary font-bold">Pengaturan Aplikasi</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-border-subtle pb-4">
                    <div>
                        <div class="text-body-sm font-body-sm text-on-surface font-semibold">Nama Sistem Kepegawaian</div>
                        <div class="text-xs text-on-surface-variant">Ubah judul utama portal sistem informasi.</div>
                    </div>
                    <input class="w-64 h-9 px-3 rounded border border-outline-variant text-body-sm bg-transparent focus:ring-primary focus:border-primary focus:outline-none" value="SIM-ASN Inspektorat Puncak Jaya" type="text"/>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-body-sm font-body-sm text-on-surface font-semibold">Batas Ukuran Upload E-Arsip</div>
                        <div class="text-xs text-on-surface-variant">Ukuran berkas PDF maksimal (dalam megabyte).</div>
                    </div>
                    <input class="w-64 h-9 px-3 rounded border border-outline-variant text-body-sm bg-transparent focus:ring-primary focus:border-primary focus:outline-none" value="10 MB" type="text"/>
                </div>
            </div>
        </div>

        <!-- Card 2: Integration Status -->
        <div class="bg-surface-card border border-border-subtle rounded-lg p-6 shadow-sm space-y-4">
            <h3 class="text-label-lg font-label-lg text-primary font-bold">Status Sinkronisasi Satu Data</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-border-subtle pb-4">
                    <div>
                        <div class="text-body-sm font-body-sm text-on-surface font-semibold">SIASN BKN Terhubung</div>
                        <div class="text-xs text-on-surface-variant">Status koneksi Web Service API SIASN Badan Kepegawaian Negara.</div>
                    </div>
                    <span class="inline-flex items-center gap-1 text-label-sm font-label-sm text-status-success font-medium">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span> Terhubung
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-body-sm font-body-sm text-on-surface font-semibold">Database MySQL Lokal</div>
                        <div class="text-xs text-on-surface-variant">Sistem penyimpanan data kepegawaian `sim_asn` lokal.</div>
                    </div>
                    <span class="inline-flex items-center gap-1 text-label-sm font-label-sm text-status-success font-medium">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span> Aktif (Port 3306)
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 3: Admin Credentials -->
        <form action="{{ route('pengaturan.admin') }}" method="POST" class="bg-surface-card border border-border-subtle rounded-lg p-6 shadow-sm space-y-4">
            @csrf
            <h3 class="text-label-lg font-label-lg text-primary font-bold">Kredensial Admin</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-border-subtle pb-4">
                    <div>
                        <div class="text-body-sm font-body-sm text-on-surface font-semibold">Email Admin</div>
                        <div class="text-xs text-on-surface-variant">Email ini digunakan untuk login ke sistem.</div>
                    </div>
                    <input class="w-64 h-9 px-3 rounded border border-outline-variant text-body-sm bg-transparent focus:ring-primary focus:border-primary focus:outline-none" name="email" value="{{ auth()->user()->email }}" type="email" required/>
                </div>
                <div class="flex items-center justify-between border-b border-border-subtle pb-4">
                    <div>
                        <div class="text-body-sm font-body-sm text-on-surface font-semibold">Kata Sandi Baru</div>
                        <div class="text-xs text-on-surface-variant">Kosongkan jika tidak ingin mengubah kata sandi.</div>
                    </div>
                    <input class="w-64 h-9 px-3 rounded border border-outline-variant text-body-sm bg-transparent focus:ring-primary focus:border-primary focus:outline-none" name="password" placeholder="Minimal 6 karakter" type="password"/>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-primary text-on-primary h-9 px-4 rounded text-label-sm font-label-sm hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">save</span> Simpan Kredensial
                    </button>
                </div>
            </div>
        </form>
        <!-- Card 4: API Access -->
        <div class="bg-surface-card border border-border-subtle rounded-lg p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-label-lg font-label-lg text-primary font-bold">Akses API Pihak Ketiga</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Buat token API untuk memberikan akses sistem lain ke data Pegawai (Data Dokumen tetap dirahasiakan).</p>
                </div>
                <form action="{{ route('pengaturan.api.token') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-primary text-on-primary h-9 px-4 rounded text-label-sm font-label-sm hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">key</span> Generate Token Baru
                    </button>
                </form>
            </div>
            
            @if(session('api_token'))
            <div class="bg-status-warning/10 border border-status-warning/30 p-4 rounded-lg mt-4">
                <div class="text-sm font-bold text-status-warning mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">warning</span> Simpan token ini sekarang. Token tidak akan ditampilkan lagi!
                </div>
                <div class="bg-surface rounded border border-border-subtle p-3 flex justify-between items-center">
                    <code class="text-xs text-on-surface break-all">{{ session('api_token') }}</code>
                </div>
            </div>
            @endif

            @if(auth()->user()->tokens->count() > 0)
            <div class="mt-4 border-t border-border-subtle pt-4">
                <div class="text-body-sm font-semibold text-on-surface mb-3">Token Aktif</div>
                <div class="space-y-2">
                    @foreach(auth()->user()->tokens as $token)
                    <div class="flex items-center justify-between bg-surface rounded p-2 border border-border-subtle">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-[18px]">api</span>
                            <div>
                                <div class="text-xs font-semibold text-on-surface">{{ $token->name }}</div>
                                <div class="text-[10px] text-on-surface-variant">Dibuat: {{ $token->created_at->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                        <form action="{{ route('pengaturan.api.token.delete', $token->id) }}" method="POST" onsubmit="return confirm('Cabut token ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-status-error hover:bg-status-error/10 p-1.5 rounded transition-colors" title="Cabut Token">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <!-- Submit Settings -->
        <div class="flex justify-end pt-4">
            <button class="bg-primary text-on-primary h-12 px-6 rounded text-label-md font-label-md hover:bg-primary/90 transition-colors shadow-sm" onclick="alert('Pengaturan berhasil disimpan!')">
                Simpan Konfigurasi
            </button>
        </div>
    </div>
</x-layout>
