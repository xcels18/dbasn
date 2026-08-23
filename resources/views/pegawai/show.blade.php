<x-layout title="Detail Profil - {{ $pegawai->getNama() }}">
    <!-- Hero Profile Section -->
    <section class="bg-surface-card border border-border-subtle rounded-xl p-6 flex flex-col md:flex-row items-start md:items-center gap-6 shadow-sm">
        <div class="w-32 h-32 rounded-lg overflow-hidden border border-outline-variant shrink-0 bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-headline-xl">
            {{ substr($pegawai->getNama(), 0, 2) }}
        </div>
        <div class="flex-1 space-y-2">
            <div class="flex items-center gap-3">
                <h1 class="text-headline-lg font-headline-lg text-primary">{{ $pegawai->getNama() }}</h1>
                <span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-label-sm font-label-sm rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                    {{ $pegawai->getStatus() }}
                </span>
            </div>
            <p class="text-body-lg font-body-lg text-on-surface-variant">NIP: {{ $pegawai->getNip() }}</p>
            <div class="flex flex-wrap gap-4 pt-2">
                <div class="flex flex-col">
                    <span class="text-label-sm font-label-sm text-outline">Jabatan</span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-body-sm font-body-sm text-on-surface font-medium">{{ $pegawai->getJabatan() }}</span>
                        @if($pegawai->getStatusJabatan() === 'Pelaksana Tugas (Plt)')
                            <span class="px-1.5 py-0.5 bg-amber-500/10 text-amber-600 text-[9px] rounded font-bold uppercase tracking-wider">PLT</span>
                        @else
                            <span class="px-1.5 py-0.5 bg-primary/10 text-primary text-[9px] rounded font-bold uppercase tracking-wider">Definitif</span>
                        @endif
                        @if($pegawai->isOutOfAnjab())
                            <span class="px-1.5 py-0.5 bg-red-500/10 text-red-600 text-[9px] rounded font-bold uppercase tracking-wider">Bukan ANJAB</span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col border-l border-outline-variant pl-4">
                    <span class="text-label-sm font-label-sm text-outline">Pangkat/Gol</span>
                    <span class="text-body-sm font-body-sm text-on-surface font-medium">
                        {{ $pegawai->getPangkatGolongan() }}
                    </span>
                </div>
                <div class="flex flex-col border-l border-outline-variant pl-4">
                    <span class="text-label-sm font-label-sm text-outline">Unit Kerja</span>
                    <span class="text-body-sm font-body-sm text-on-surface font-medium">{{ $pegawai->getUnitKerja() }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabbed Navigation -->
    <nav class="flex border-b border-border-subtle overflow-x-auto hide-scrollbar mb-6">
        <button id="tab-btn-pribadi" class="tab-trigger px-6 py-3 text-label-md font-label-md text-primary border-b-2 border-primary" data-target="tab-data-pribadi">Data Pribadi</button>
        <button id="tab-btn-pangkat" class="tab-trigger px-6 py-3 text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors border-b-2 border-transparent" data-target="tab-riwayat-pangkat">Riwayat Pangkat</button>
        <button id="tab-btn-arsip" class="tab-trigger px-6 py-3 text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors border-b-2 border-transparent" data-target="tab-e-arsip">E-Arsip Dokumen</button>
    </nav>

    <!-- TAB CONTENTS CONTAINER -->
    <div id="tab-contents" class="space-y-stack-lg">

        <!-- 1. DATA PRIBADI TAB -->
        <div id="tab-data-pribadi" class="tab-content space-y-6">
            
            <div class="bg-surface-card border border-border-subtle rounded-xl shadow-sm p-6 lg:p-10">
                
                <!-- SECTION 1: Identitas & Master Data -->
                <div class="mb-6 pb-2 border-b border-border-subtle">
                    <h3 class="text-title-md font-title-md text-blue-600 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined">person</span> Identitas &amp; Master Data
                    </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8 mb-10">
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Nomor Induk Pegawai (NIP)</span>
                        <span class="text-on-surface font-bold text-title-md text-primary">{{ $pegawai->getNip() }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Nama Lengkap & Gelar</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getNama() }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Tempat / Tanggal Lahir</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getTempatLahir() }}, {{ date('d F Y', strtotime($pegawai->getTanggalLahir())) }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Nomor Induk Kependudukan (NIK)</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getNik() }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Nomor Kartu Keluarga (KK)</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getKk() }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <span class="text-label-sm font-label-sm text-outline mb-1">Jenis Kelamin</span>
                            <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getJenisKelamin() }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-label-sm font-label-sm text-outline mb-1">Agama</span>
                            <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getAgama() }}</span>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Pangkat & Jabatan -->
                <div class="mb-6 pb-2 border-b border-border-subtle">
                    <h3 class="text-title-md font-title-md text-teal-600 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined">badge</span> Pangkat &amp; Jabatan
                    </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8 mb-10">
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Nama Jabatan (Formasi Terdaftar)</span>
                        <div class="flex items-center gap-2">
                            <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getJabatan() }}</span>
                            @if($pegawai->isOutOfAnjab())
                                <span class="inline-flex items-center px-2 py-0.5 bg-red-500/10 text-red-600 text-[10px] rounded font-bold uppercase tracking-wider">Bukan ANJAB</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Unit Kerja / Penempatan</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getUnitKerja() }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Pangkat & Golongan Ruang</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getPangkatGolongan() }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Kedudukan Hukum (Status)</span>
                        <div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-label-sm font-medium {{ $pegawai->getStatus() === 'Cuti' ? 'bg-tertiary-container/30 text-tertiary-container' : 'bg-secondary-container text-on-secondary-container' }}">
                                {{ $pegawai->getStatus() }} - PNS
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Status Jabatan</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getStatusJabatan() }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Masa Kerja</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getMasaKerja() }}</span>
                    </div>
                </div>

                <!-- SECTION 3: Pendidikan & Kinerja -->
                <div class="mb-6 pb-2 border-b border-border-subtle">
                    <h3 class="text-title-md font-title-md text-violet-600 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined">school</span> Pendidikan &amp; Kinerja
                    </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8 mb-10">
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Pendidikan Formal Terakhir</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getPendidikanTerakhir() }}</span>
                    </div>
                </div>

                <!-- SECTION 4: Kontak & Alamat -->
                <div class="mb-6 pb-2 border-b border-border-subtle">
                    <h3 class="text-title-md font-title-md text-orange-600 font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined">contacts</span> Kontak &amp; Alamat
                    </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8 mb-4">
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Nomor HP / WA</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getNoHp() ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Email</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getEmail() ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col lg:col-span-3">
                        <span class="text-label-sm font-label-sm text-outline mb-1">Alamat Domisili</span>
                        <span class="text-on-surface font-medium text-body-md">{{ $pegawai->getAlamat() ?? '-' }}</span>
                    </div>
                </div>

                <!-- PETA LOKASI -->
                @if($pegawai->getLatitude() && $pegawai->getLongitude())
                <div class="mt-8 pt-8 border-t border-border-subtle">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-red-500 text-[24px]">location_on</span>
                        <h4 class="text-title-sm font-title-sm text-on-surface font-bold">Peta Lokasi Domisili ASN</h4>
                    </div>
                    <div id="map-show" class="w-full h-72 md:h-96 rounded-xl border-2 border-outline-variant shadow-sm z-10" style="position: relative;" data-lat="{{ $pegawai->getLatitude() }}" data-lng="{{ $pegawai->getLongitude() }}"></div>
                </div>
                @endif
                
            </div>
        </div>

        <!-- 2. RIWAYAT PANGKAT TAB (Vertical Timeline) -->
        <div id="tab-riwayat-pangkat" class="tab-content hidden bg-surface-card border border-border-subtle rounded-lg p-6 shadow-sm">
            <h3 class="text-label-lg font-label-lg text-primary mb-10 text-center flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">workspace_premium</span> Riwayat Kenaikan Pangkat & Golongan
            </h3>
            
            <!-- Timeline Container -->
            <div id="riwayat-pangkat-timeline" class="relative w-full max-w-3xl mx-auto pb-4">
                <!-- Timeline items will be injected here by JS -->
            </div>
        </div>

        <!-- 3. E-ARSIP DOKUMEN TAB -->
        <div id="tab-e-arsip" class="tab-content hidden space-y-6">
            <!-- Summary Bar -->
            <div class="flex items-center justify-between bg-surface-container-low border border-border-subtle rounded-lg p-4">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed">
                            <span class="material-symbols-outlined">folder_special</span>
                        </div>
                        <div>
                            <div class="text-headline-md font-headline-md leading-none" id="profile-total-docs-count">10</div>
                            <div class="text-label-sm font-label-sm text-on-surface-variant">Total Dokumen</div>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-outline-variant"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                            <span class="material-symbols-outlined">verified</span>
                        </div>
                        <div>
                            <div class="text-headline-md font-headline-md leading-none text-secondary" id="profile-valid-docs-count">10</div>
                            <div class="text-label-sm font-label-sm text-on-surface-variant">Terverifikasi</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breadcrumbs inside Profile tab -->
            <div class="flex items-center text-label-sm font-label-sm text-on-surface-variant gap-2 py-1">
                <a href="javascript:void(0)" id="profile-breadcrumb-root" class="hover:underline text-primary font-semibold">Semua Dokumen</a>
                <span id="profile-breadcrumb-separator" class="material-symbols-outlined text-[16px] text-outline hidden">chevron_right</span>
                <span id="profile-breadcrumb-folder" class="text-outline font-medium hidden">Nama Folder</span>
            </div>

            <!-- 1. Folder Grid View for Profile -->
            <div id="profile-folder-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Folder 1: Dokumen Identitas -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-amber-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Dokumen Identitas">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">badge</span>
                        </div>
                        <span class="px-2 py-0.5 bg-amber-500/10 text-[9px] rounded font-semibold text-amber-700">KTP, KK, Akta</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Dokumen Identitas</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-identitas">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-identitas">0</span>
                    </div>
                </div>

                <!-- Folder 2: Dokumen Perpajakan -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-rose-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Dokumen Perpajakan">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-rose-500/10 text-rose-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">receipt_long</span>
                        </div>
                        <span class="px-2 py-0.5 bg-rose-500/10 text-[9px] rounded font-semibold text-rose-700">NPWP, dll</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Dokumen Perpajakan</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-perpajakan">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-perpajakan">0</span>
                    </div>
                </div>

                <!-- Folder 3: Dokumen Pendidikan -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-cyan-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Dokumen Pendidikan">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-cyan-500/10 text-cyan-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">school</span>
                        </div>
                        <span class="px-2 py-0.5 bg-cyan-500/10 text-[9px] rounded font-semibold text-cyan-700">Ijazah</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Dokumen Pendidikan</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-pendidikan">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-pendidikan">0</span>
                    </div>
                </div>

                <!-- Folder 4: Dokumen SK CPNS, PNS, Mutasi -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-blue-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Dokumen SK CPNS, PNS, Mutasi">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">assignment_ind</span>
                        </div>
                        <span class="px-2 py-0.5 bg-blue-500/10 text-[9px] rounded font-semibold text-blue-700">Status Pegawai</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">SK CPNS, PNS, Mutasi</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-sk-status">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-sk-status">0</span>
                    </div>
                </div>

                <!-- Folder 5: Dokumen SK Pangkat -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-green-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Dokumen SK Pangkat">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-green-500/10 text-green-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">military_tech</span>
                        </div>
                        <span class="px-2 py-0.5 bg-green-500/10 text-[9px] rounded font-semibold text-green-700">Golongan</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Dokumen SK Pangkat</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-sk-pangkat">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-sk-pangkat">0</span>
                    </div>
                </div>

                <!-- Folder 6: Angka Kredit -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-purple-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Angka Kredit">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-purple-500/10 text-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">stars</span>
                        </div>
                        <span class="px-2 py-0.5 bg-purple-500/10 text-[9px] rounded font-semibold text-purple-700">Dupak/PAK</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Angka Kredit</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-angka-kredit">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-angka-kredit">0</span>
                    </div>
                </div>

                <!-- Folder 7: SKP -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-violet-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="SKP">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-violet-500/10 text-violet-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">fact_check</span>
                        </div>
                        <span class="px-2 py-0.5 bg-violet-500/10 text-[9px] rounded font-semibold text-violet-700">Kinerja</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">SKP</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-skp">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-skp">0</span>
                    </div>
                </div>
                <!-- Folder 8: Sertifikat Diklat -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-teal-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Sertifikat Diklat">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-teal-500/10 text-teal-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">workspace_premium</span>
                        </div>
                        <span class="px-2 py-0.5 bg-teal-500/10 text-[9px] rounded font-semibold text-teal-700">Diklat</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Sertifikat Diklat</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-sertifikat-diklat">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-sertifikat-diklat">0</span>
                    </div>
                </div>

                <!-- Folder 9: Dokumen Lain-Lain -->
                <div class="profile-folder-card bg-surface-card border border-border-subtle hover:border-slate-500 rounded-xl p-6 shadow-sm cursor-pointer hover:shadow-md transition-all flex flex-col justify-between group" data-category="Dokumen Lain-Lain">
                    <div class="flex justify-between items-start">
                        <div class="w-14 h-14 rounded-lg bg-slate-500/10 text-slate-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1">folder_special</span>
                        </div>
                        <span class="px-2 py-0.5 bg-slate-500/10 text-[9px] rounded font-semibold text-slate-700">Lainnya</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-on-surface text-body-md group-hover:text-primary transition-colors leading-tight">Dokumen Lain-Lain</h3>
                        <p class="text-xs text-outline mt-1 font-medium" id="pcount-lain-lain">0 Berkas</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-border-subtle flex items-center gap-2 text-[11px] text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        <span>Jumlah Dokumen:</span>
                        <span class="font-bold text-primary ml-auto" id="ptotal-lain-lain">0</span>
                    </div>
                </div>
            </div>

            <!-- 2. Folder Content View (Table of files) -->
            <div id="profile-folder-content" class="hidden flex flex-col gap-3">
                <div class="flex items-center justify-between bg-surface-card border border-border-subtle rounded-lg p-4 shadow-sm shrink-0">
                    <button id="profile-back-to-folders-btn" class="flex items-center gap-2 text-primary font-semibold text-label-md hover:bg-surface-container-low px-4 py-2 rounded transition-colors focus:outline-none border border-border-subtle">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        Kembali ke Folder
                    </button>
                    <span id="profile-current-folder-title" class="font-bold text-headline-sm text-primary">Nama Folder</span>
                    <button id="trigger-upload-btn" class="bg-primary text-on-primary h-10 px-4 rounded flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-sm focus:outline-none">
                        <span class="material-symbols-outlined text-[20px]">upload_file</span>
                        <span class="text-label-md font-label-md hidden sm:inline">Unggah Berkas Baru</span>
                    </button>
                </div>

                <div class="border border-border-subtle rounded overflow-hidden">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="text-label-sm font-label-sm text-on-surface-variant bg-surface-container-low">
                                <th class="py-2.5 px-4 text-left border-b border-border-subtle">Nama Berkas</th>
                                <th class="py-2.5 px-4 text-left border-b border-border-subtle">Tanggal Unggah</th>
                                <th class="w-32 py-2.5 px-4 text-left border-b border-border-subtle">Status</th>
                                <th class="w-24 text-center py-2.5 border-b border-border-subtle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="profile-doc-table-body" class="text-body-sm font-body-sm text-on-surface divide-y divide-border-subtle">
                            <!-- Populated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


                </div>
            </div>
        </div>

    </div>

    <!-- 3. Verification Document Modal Overlay -->
    <div id="verification-modal" class="hidden fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 flex items-center justify-center p-8">
        <!-- Modal Container -->
        <div class="bg-surface-card w-full max-w-[1200px] h-[85vh] rounded-xl shadow-[0px_4px_20px_rgba(15,41,66,0.15)] flex flex-col overflow-hidden border border-border-subtle transition-all duration-200">
            <!-- Modal Header -->
            <div class="h-16 border-b border-border-subtle bg-surface-container-lowest flex items-center justify-between px-6 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-primary/5 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">plagiarism</span>
                    </div>
                    <div>
                        <h2 class="text-headline-md font-headline-md text-on-surface leading-tight" id="modal-title-doc">Verifikasi Dokumen: SK Kenaikan Pangkat.pdf</h2>
                        <p class="text-label-sm font-label-sm text-on-surface-variant mt-0.5">{{ $pegawai->getNama() }} - NIP. {{ $pegawai->getNip() }}</p>
                    </div>
                </div>
                <button class="close-modal-btn w-8 h-8 flex items-center justify-center rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors" title="Tutup">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Modal Body (Split View) -->
            <div class="flex-1 flex overflow-hidden">
                <!-- Document Viewer -->
                <div class="w-full flex flex-col bg-surface-container relative">
                    <div class="h-12 bg-surface-container-lowest border-b border-border-subtle flex items-center justify-center gap-2 px-4 shrink-0 shadow-sm z-10">
                        <div class="flex items-center bg-surface-container rounded border border-border-subtle p-1">
                            <button class="w-8 h-8 rounded hover:bg-surface-container-highest flex items-center justify-center text-on-surface-variant" title="Zoom Out">
                                <span class="material-symbols-outlined text-[20px]">remove</span>
                            </button>
                            <span class="text-label-sm font-label-sm w-12 text-center text-on-surface">100%</span>
                            <button class="w-8 h-8 rounded hover:bg-surface-container-highest flex items-center justify-center text-on-surface-variant" title="Zoom In">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Document Canvas -->
                    <div class="flex-1 overflow-y-auto p-8 flex justify-center bg-surface-variant/30 custom-scrollbar">
                        <div id="simulated-doc-view" class="w-full max-w-[800px] h-fit min-h-[1000px] bg-white shadow-sm border border-border-subtle relative p-12 text-on-surface">
                            <div class="border-b-2 border-black pb-4 mb-8 text-center flex flex-col items-center">
                                <div class="w-16 h-16 bg-surface-container-high rounded-full flex items-center justify-center text-primary mb-2">
                                    <span class="material-symbols-outlined text-[36px]">shield</span>
                                </div>
                                <h1 class="text-headline-md font-bold uppercase tracking-wide">Pemerintah Kabupaten Puncak Jaya</h1>
                            </div>
                            <h2 class="text-center font-bold underline mb-4 text-headline-sm" id="simulated-doc-title">SURAT KEPUTUSAN BUPATI</h2>
                            <p class="text-center mb-8 text-body-sm" id="simulated-doc-number">Nomor: 821.2/123/BUP/2023</p>
                            <div class="space-y-4 text-body-sm text-justify leading-relaxed">
                                <p><strong>MENETAPKAN DOKUMEN:</strong></p>
                                <div class="grid grid-cols-[140px_10px_1fr] gap-2 ml-4 mb-4 text-body-sm">
                                    <div>Nama Pegawai</div><div>:</div><div><strong>{{ $pegawai->getNama() }}</strong></div>
                                    <div>NIP</div><div>:</div><div>{{ $pegawai->getNip() }}</div>
                                    <div>Tipe Dokumen</div><div>:</div><div id="simulated-doc-type">KTP (Kartu Tanda Penduduk)</div>
                                </div>
                                <p>Demikian surat keterangan pemeriksaan ini dibuat untuk dipergunakan sebagai mana mestinya dalam arsip digital kepegawaian Kabupaten Puncak Jaya.</p>
                            </div>
                        </div>
                        <div id="actual-file-view" class="hidden w-full max-w-[1000px] h-full flex justify-center items-start">
                            <!-- Actual file content will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Upload Document Modal Overlay -->
    <div id="upload-modal" class="hidden fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 flex items-center justify-center p-8">
        <!-- Modal Container -->
        <div class="bg-surface-card w-full max-w-[600px] rounded-xl shadow-lg flex flex-col overflow-hidden border border-border-subtle p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-[28px]">upload_file</span>
                    <h2 class="text-headline-md font-headline-md text-on-surface">Unggah Berkas E-Arsip</h2>
                </div>
                <button id="close-upload-btn" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-surface-container-high text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="upload-form" class="space-y-4">
                <!-- Selected Category Info Display -->
                <div class="p-3.5 bg-surface-container rounded-lg border border-border-subtle flex flex-col gap-0.5 shadow-sm">
                    <span class="text-label-xs font-label-xs text-outline font-semibold uppercase">Kategori Folder Tujuan</span>
                    <span class="text-body-md font-bold text-primary" id="upload-cat-display">Nama Kategori</span>
                </div>
                <!-- Hidden Select for Category -->
                <select id="upload-doc-type" class="hidden" required>
                    <option value="Dokumen Identitas">Dokumen Identitas (KTP, KK, Akta)</option>
                    <option value="Dokumen Perpajakan">Dokumen Perpajakan (NPWP, dll)</option>
                    <option value="Dokumen Pendidikan">Dokumen Pendidikan (Ijazah)</option>
                    <option value="Dokumen SK CPNS, PNS, Mutasi">Dokumen SK CPNS, PNS, Mutasi</option>
                    <option value="Dokumen SK Pangkat">Dokumen SK Pangkat</option>
                    <option value="Angka Kredit">Angka Kredit</option>
                    <option value="SKP">SKP</option>
                    <option value="Sertifikat Diklat">Sertifikat Diklat</option>
                    <option value="Dokumen Lain-Lain">Dokumen Lain-Lain</option>
                </select>
                <!-- Document Title Input -->
                <div class="flex flex-col gap-1">
                    <label for="upload-doc-title" id="upload-doc-title-label" class="text-label-sm font-label-sm text-primary font-semibold">Judul Berkas / Arsip</label>
                    <input type="text" id="upload-doc-title" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Contoh: SK Pangkat Terakhir" required/>
                </div>
                <!-- Tanggal SK Field -->
                <div id="sk-date-field" class="flex flex-col gap-1 hidden">
                    <label for="upload-sk-date" class="text-label-sm font-label-sm text-primary font-semibold">Tanggal SK</label>
                    <input type="date" id="upload-sk-date" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent"/>
                </div>
                <!-- Nomor SK Field -->
                <div id="sk-nomor-field" class="flex flex-col gap-1 hidden">
                    <label for="upload-sk-nomor" class="text-label-sm font-label-sm text-primary font-semibold">Nomor SK</label>
                    <input type="text" id="upload-sk-nomor" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Contoh: 821.2/123/BUP/2023"/>
                </div>
                <!-- Tanggal TMT Field -->
                <div id="sk-tmt-field" class="flex flex-col gap-1 hidden">
                    <label for="upload-sk-tmt" class="text-label-sm font-label-sm text-primary font-semibold">Tanggal TMT</label>
                    <input type="date" id="upload-sk-tmt" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent"/>
                </div>
                <!-- Jenis Diklat Field -->
                <div id="diklat-jenis-field" class="flex flex-col gap-1 hidden">
                    <label for="upload-diklat-jenis" class="text-label-sm font-label-sm text-primary font-semibold">Jenis Diklat</label>
                    <select id="upload-diklat-jenis" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-surface">
                        <option value="Pelatihan Dasar (Latsar) CPNS">Pelatihan Dasar (Latsar) CPNS</option>
                        <option value="Pelatihan Manajerial / Kepemimpinan">Pelatihan Manajerial / Kepemimpinan</option>
                        <option value="Pelatihan Fungsional">Pelatihan Fungsional</option>
                        <option value="Pelatihan Teknis">Pelatihan Teknis</option>
                        <option value="Pelatihan Sosialisasi / Seminar / Webinar">Pelatihan Sosialisasi / Seminar / Webinar</option>
                    </select>
                </div>
                <!-- Tahun Diklat Field -->
                <div id="diklat-tahun-field" class="flex flex-col gap-1 hidden">
                    <label for="upload-diklat-tahun" class="text-label-sm font-label-sm text-primary font-semibold">Tahun</label>
                    <input type="number" id="upload-diklat-tahun" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Contoh: 2023" min="1950" max="2100"/>
                </div>
                <div id="drop-zone" class="border-2 border-dashed border-outline-variant hover:border-primary rounded-lg p-8 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all bg-surface-container-lowest mt-4">
                    <span class="material-symbols-outlined text-[48px] text-outline">cloud_upload</span>
                    <span class="text-body-sm font-medium text-on-surface">Pilih File atau seret ke sini</span>
                    <span class="text-[11px] text-outline">Format PDF, JPG, PNG (Maks 10MB)</span>
                    <input type="file" id="file-input" class="hidden" accept=".pdf,.jpg,.jpeg,.png"/>
                </div>
                <div id="progress-container" class="hidden space-y-2">
                    <div class="flex justify-between text-label-sm font-label-sm text-on-surface">
                        <span id="uploading-file-name">Nama_File.pdf</span>
                        <span id="progress-text">0%</span>
                    </div>
                    <div class="w-full h-2 bg-surface-container rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-primary" style="width: 0%"></div>
                    </div>
                </div>
                <button type="submit" class="w-full h-12 bg-primary text-on-primary rounded font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors shadow-sm">
                    Mulai Unggah
                </button>
            </form>
        </div>
    </div>

    <!-- Client-side Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ================= INDEXED DB SETUP =================
            const DB_NAME = 'e_arsip_db';
            const DB_VERSION = 1;
            const STORE_NAME = 'documents';

            function getDB() {
                return new Promise((resolve, reject) => {
                    const request = indexedDB.open(DB_NAME, DB_VERSION);
                    request.onupgradeneeded = function(e) {
                        const db = e.target.result;
                        if (!db.objectStoreNames.contains(STORE_NAME)) {
                            db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
                        }
                    };
                    request.onsuccess = function(e) {
                        resolve(e.target.result);
                    };
                    request.onerror = function(e) {
                        reject(e.target.error);
                    };
                });
            }

            async function saveDocumentToDB(doc) {
                const db = await getDB();
                return new Promise((resolve, reject) => {
                    const tx = db.transaction(STORE_NAME, 'readwrite');
                    const store = tx.objectStore(STORE_NAME);
                    const request = store.add(doc);
                    request.onsuccess = () => resolve(request.result);
                    request.onerror = () => reject(request.error);
                });
            }

            async function getDocumentsFromDB() {
                const db = await getDB();
                return new Promise((resolve, reject) => {
                    const tx = db.transaction(STORE_NAME, 'readonly');
                    const store = tx.objectStore(STORE_NAME);
                    const request = store.getAll();
                    request.onsuccess = () => resolve(request.result);
                    request.onerror = () => reject(request.error);
                });
            }

            async function getDocumentFileBlob(fileName) {
                const db = await getDB();
                return new Promise((resolve, reject) => {
                    const tx = db.transaction(STORE_NAME, 'readonly');
                    const store = tx.objectStore(STORE_NAME);
                    const request = store.openCursor();
                    request.onsuccess = function(e) {
                        const cursor = e.target.result;
                        if (cursor) {
                            if (cursor.value.fileName === fileName) {
                                resolve(cursor.value.fileBlob);
                                return;
                            }
                            cursor.continue();
                        } else {
                            resolve(null);
                        }
                    };
                    request.onerror = () => reject(request.error);
                });
            }

            const currentNip = '{{ $pegawai->getNip() }}';
            const currentNama = '{{ $pegawai->getNama() }}';
            // ====================================================

            // TABS LOGIC
            const tabTriggers = document.querySelectorAll('.tab-trigger');
            const tabContents = document.querySelectorAll('.tab-content');

            tabTriggers.forEach(trigger => {
                trigger.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');

                    tabTriggers.forEach(t => {
                        t.classList.remove('text-primary', 'border-primary', 'border-b-2');
                        t.classList.add('text-on-surface-variant', 'border-transparent');
                    });

                    this.classList.remove('text-on-surface-variant', 'border-transparent');
                    this.classList.add('text-primary', 'border-primary', 'border-b-2');

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        if(content.id === 'tab-e-arsip') {
                            content.style.display = 'none';
                        }
                    });

                    const targetContent = document.getElementById(targetId);
                    if(targetId === 'tab-e-arsip') {
                        targetContent.style.display = 'block';
                    }
                    targetContent.classList.remove('hidden');
                    
                    if(targetId === 'tab-data-pribadi' && window.showMapInstance) {
                        setTimeout(() => window.showMapInstance.invalidateSize(), 50);
                    }
                });
            });


            // PROFILE FILE MANAGER NAVIGATION LOGIC
            let activeProfileFolder = null;
            const profileFolders = [
                'Dokumen Identitas',
                'Dokumen Perpajakan',
                'Dokumen Pendidikan',
                'Dokumen SK CPNS, PNS, Mutasi',
                'Dokumen SK Pangkat',
                'Angka Kredit',
                'SKP',
                'Sertifikat Diklat',
                'Dokumen Lain-Lain'
            ];

            const profileFolderDomIds = {
                'Dokumen Identitas': 'pcount-identitas',
                'Dokumen Perpajakan': 'pcount-perpajakan',
                'Dokumen Pendidikan': 'pcount-pendidikan',
                'Dokumen SK CPNS, PNS, Mutasi': 'pcount-sk-status',
                'Dokumen SK Pangkat': 'pcount-sk-pangkat',
                'Angka Kredit': 'pcount-angka-kredit',
                'SKP': 'pcount-skp',
                'Sertifikat Diklat': 'pcount-sertifikat-diklat',
                'Dokumen Lain-Lain': 'pcount-lain-lain'
            };

            function calculateProfileFolderMetrics() {
                const totalRows = document.querySelectorAll('.profile-doc-row');
                let counts = {};
                profileFolders.forEach(cat => counts[cat] = 0);

                totalRows.forEach(row => {
                    const cat = row.getAttribute('data-category');
                    if (counts[cat] !== undefined) counts[cat]++;
                });

                document.getElementById('profile-total-docs-count').innerText = totalRows.length;
                document.getElementById('profile-valid-docs-count').innerText = totalRows.length;

                profileFolders.forEach(cat => {
                    const elId = profileFolderDomIds[cat];
                    const el = document.getElementById(elId);
                    if (el) el.innerText = counts[cat] + ' Berkas';
                    
                    // Update total at the bottom of the card
                    const totalId = elId.replace('pcount-', 'ptotal-');
                    const totalEl = document.getElementById(totalId);
                    if (totalEl) totalEl.innerText = counts[cat];
                });
            }

            const pFolderGrid = document.getElementById('profile-folder-grid');
            const pFolderContent = document.getElementById('profile-folder-content');
            const pCurrentFolderTitle = document.getElementById('profile-current-folder-title');
            const pBreadcrumbSeparator = document.getElementById('profile-breadcrumb-separator');
            const pBreadcrumbFolder = document.getElementById('profile-breadcrumb-folder');

            function viewProfileRoot() {
                activeProfileFolder = null;
                pFolderGrid.classList.remove('hidden');
                pFolderContent.classList.add('hidden');
                pBreadcrumbSeparator.classList.add('hidden');
                pBreadcrumbFolder.classList.add('hidden');
            }

            function viewProfileFolder(category) {
                activeProfileFolder = category;
                pFolderGrid.classList.add('hidden');
                pFolderContent.classList.remove('hidden');
                pCurrentFolderTitle.innerText = category;
                pBreadcrumbSeparator.classList.remove('hidden');
                pBreadcrumbFolder.innerText = category;
                pBreadcrumbFolder.classList.remove('hidden');

                // Filter rows
                document.querySelectorAll('.profile-doc-row').forEach(row => {
                    if (row.getAttribute('data-category') === category) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            // Click events
            document.getElementById('profile-folder-grid').addEventListener('click', function(e) {
                const card = e.target.closest('.profile-folder-card');
                if (card) {
                    const cat = card.getAttribute('data-category');
                    viewProfileFolder(cat);
                }
            });

            document.getElementById('profile-back-to-folders-btn').addEventListener('click', viewProfileRoot);
            document.getElementById('profile-breadcrumb-root').addEventListener('click', viewProfileRoot);

            // Load Docs from DB
            async function loadProfileDocs() {
                const allDocs = await getDocumentsFromDB();
                // Filter docs specific to this Pegawai
                const myDocs = allDocs.filter(d => d.pegNip === currentNip);

                const tbody = document.getElementById('profile-doc-table-body');
                tbody.innerHTML = '';

                // Load riwayat pangkat timeline based on uploaded SK
                loadRiwayatPangkatTimeline(myDocs);

                myDocs.forEach(doc => {
                    const newRow = document.createElement('tr');
                    newRow.className = 'profile-doc-row hover:bg-surface-container-lowest';
                    newRow.setAttribute('data-category', doc.category);
                    newRow.setAttribute('data-status', doc.status);
                    
                    newRow.innerHTML = `
                        <td class="py-2.5 px-4 font-semibold text-primary">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                <div class="flex flex-col">
                                    <span class="text-body-sm">${doc.title}</span>
                                    <span class="text-[10px] text-outline font-medium">${doc.fileName}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-2.5 px-4 text-on-surface-variant font-medium text-xs">${doc.uploadDate || 'Hari Ini'}</td>
                        <td class="py-2.5 px-4">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold ${doc.status === 'Valid' ? 'text-status-success' : 'text-amber-500'}">
                                <span class="material-symbols-outlined text-[12px] font-bold">${doc.status === 'Valid' ? 'check_circle' : 'pending_actions'}</span> ${doc.status}
                            </span>
                        </td>
                        <td class="text-center py-2.5">
                            <div class="flex justify-center gap-1">
                                <button class="preview-btn w-7 h-7 flex items-center justify-center rounded text-on-surface-variant hover:bg-surface-container-high hover:text-primary" title="Preview" data-doc-name="${doc.fileName}" data-doc-type="${doc.category}">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                </button>
                                <button class="download-btn w-7 h-7 flex items-center justify-center rounded text-on-surface-variant hover:bg-surface-container-high hover:text-primary" title="Download" data-doc-name="${doc.fileName}">
                                    <span class="material-symbols-outlined text-[16px]">download</span>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(newRow);
                });

                calculateProfileFolderMetrics();
                if(activeProfileFolder) {
                    viewProfileFolder(activeProfileFolder);
                }
            }

            function loadRiwayatPangkatTimeline(myDocs) {
                const timelineContainer = document.getElementById('riwayat-pangkat-timeline');
                if (!timelineContainer) return;
                timelineContainer.innerHTML = '';

                // Filter for SK folders
                const skDocs = myDocs.filter(d => d.category.includes('SK Pangkat') || d.category.includes('SK CPNS'));

                if (skDocs.length === 0) {
                    // Fallback to current pangkat
                    timelineContainer.innerHTML = `
                        <!-- Desktop Center Line -->
                        <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-emerald-500/20 -translate-x-1/2 hidden md:block"></div>
                        
                        <div class="relative flex flex-col md:flex-row items-center justify-center w-full">
                            <!-- Timeline Dot (Desktop only for empty state) -->
                            <div class="absolute md:left-1/2 top-0 md:-translate-x-1/2 bg-emerald-500 w-5 h-5 rounded-full ring-4 ring-surface flex items-center justify-center z-10 hidden md:flex">
                                <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                            </div>
                            
                            <!-- Content -->
                            <div class="w-full text-center">
                                <h4 class="text-label-lg font-bold text-emerald-700 tracking-tight">{{ $pegawai->getPangkatGolongan() }}</h4>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] rounded font-medium inline-block mt-1 border border-slate-200">Sistem</span>
                                <div class="text-body-sm text-outline mt-2">Data default dari master pegawai</div>
                                <p class="text-[12px] text-on-surface-variant mt-1">Belum ada dokumen SK Pangkat atau CPNS yang diunggah ke dalam E-Arsip untuk pegawai ini.</p>
                            </div>
                        </div>
                    `;
                    return;
                }

                // Sort docs by Date descending if available in title (Tanggal: YYYY-MM-DD), otherwise just reverse insertion order
                let sortedDocs = [...skDocs].reverse();

                let html = '<div class="absolute left-[28px] md:left-1/2 top-0 bottom-0 w-0.5 bg-emerald-500/20 md:-translate-x-1/2"></div>';

                // Render docs
                sortedDocs.forEach((doc, index) => {
                    const isLatest = index === 0;
                    const isLeft = index % 2 === 0;
                    
                    let judulSk = doc.title;
                    let tanggalSk = "-";
                    let nomorSk = "-";
                    let tanggalTmt = "-";

                    const tmtMatch = doc.title.match(/\[TMT:\s*(.*?)\]/);
                    if (tmtMatch) {
                        tanggalTmt = tmtMatch[1];
                        judulSk = judulSk.replace(tmtMatch[0], '').trim();
                    }

                    const nomorMatch = doc.title.match(/\[Nomor:\s*(.*?)\]/);
                    if (nomorMatch) {
                        nomorSk = nomorMatch[1];
                        judulSk = judulSk.replace(nomorMatch[0], '').trim();
                    }

                    const dateMatch = doc.title.match(/\(Tanggal:\s*(.*?)\)/);
                    if (dateMatch) {
                        tanggalSk = dateMatch[1];
                        judulSk = judulSk.replace(dateMatch[0], '').trim();
                    }

                    // Fallback if TMT is still "-" but we have Tanggal SK
                    if (tanggalTmt === "-" && tanggalSk !== "-") {
                        tanggalTmt = tanggalSk;
                    }

                    const dotBg = isLatest ? 'bg-emerald-500 ring-emerald-500/20' : 'bg-slate-300 ring-surface';
                    const textCol = isLatest ? 'text-emerald-700' : 'text-slate-700';
                    const badge = isLatest ? '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] rounded font-bold tracking-wider inline-block border border-emerald-200">TERBARU</span>' : '';

                    const metadataJustify = isLeft ? 'md:justify-end' : 'md:justify-start';

                    const contentBody = `
                        ${badge ? `<div class="mb-1">${badge}</div>` : ''}
                        <h4 class="text-label-lg font-bold ${textCol} tracking-tight leading-tight mb-1">${judulSk}</h4>
                        <div class="text-body-sm font-semibold text-slate-600 mb-2">TMT: ${tanggalTmt}</div>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-[11px] text-slate-500 font-medium ${metadataJustify}">
                            <div class="flex items-center gap-1" title="Nomor SK">
                                <span class="material-symbols-outlined text-[14px] opacity-70">tag</span><span>${nomorSk}</span>
                            </div>
                            <div class="flex items-center gap-1" title="Tanggal SK">
                                <span class="material-symbols-outlined text-[14px] opacity-70">calendar_today</span><span>${tanggalSk}</span>
                            </div>
                            <div class="flex items-center gap-1 truncate max-w-[200px]" title="Nama File Arsip: ${doc.fileName}">
                                <span class="material-symbols-outlined text-[14px] opacity-70">description</span><span class="truncate">${doc.fileName}</span>
                            </div>
                        </div>
                    `;

                    html += `
                        <div class="relative flex flex-col md:flex-row items-start mb-12 w-full group">
                            <!-- Timeline Dot -->
                            <div class="absolute left-[19px] md:left-1/2 top-1.5 md:-translate-x-1/2 ${dotBg} w-5 h-5 rounded-full ring-4 z-10 flex items-center justify-center">
                                <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                            </div>
                            
                            ${isLeft ? `
                                <!-- Left Content -->
                                <div class="w-full md:w-1/2 pl-14 md:pl-0 md:pr-12 md:text-right">
                                    ${contentBody}
                                </div>
                                <!-- Right Spacer -->
                                <div class="hidden md:block w-1/2"></div>
                            ` : `
                                <!-- Left Spacer -->
                                <div class="hidden md:block w-1/2"></div>
                                <!-- Right Content -->
                                <div class="w-full md:w-1/2 pl-14 md:pl-12 md:text-left">
                                    ${contentBody}
                                </div>
                            `}
                        </div>
                    `;
                });
                
                timelineContainer.innerHTML = html;
            }

            // Initialize
            loadProfileDocs().then(() => {
                viewProfileRoot();
            });

            // VERIFICATION MODAL LOGIC
            const modal = document.getElementById('verification-modal');
            const previewBtns = document.querySelectorAll('.preview-btn');
            const closeBtns = document.querySelectorAll('.close-modal-btn');

            const docDetails = {
                KTP: {
                    title: 'DOKUMEN IDENTITAS: KARTU TANDA PENDUDUK',
                    number: 'NIK: {{ $pegawai->getNik() }}',
                    type: 'KTP (Kartu Tanda Penduduk)',
                    size: '1.2 MB (PDF)'
                },
                KK: {
                    title: 'DOKUMEN IDENTITAS: KARTU KELUARGA',
                    number: 'No. KK: {{ $pegawai->getKk() }}',
                    type: 'Kartu Keluarga (KK)',
                    size: '2.4 MB (PDF)'
                },
                Default: {
                    title: 'DOKUMEN KEPEGAWAIAN RESMI',
                    number: 'NIP: {{ $pegawai->getNip() }}',
                    type: 'Dokumen Kepegawaian',
                    size: '2.0 MB (PDF)'
                }
            };

            let currentActiveObjectUrl = null;

            // Use event delegation for preview clicks to support accordion elements
            document.getElementById('tab-e-arsip').addEventListener('click', async function (e) {
                const previewBtn = e.target.closest('.preview-btn');
                if (previewBtn) {
                    const docName = previewBtn.getAttribute('data-doc-name');
                    const docType = previewBtn.getAttribute('data-doc-type');
                    let docKey = 'Default';
                    const upperDocName = docName.toUpperCase();
                    if (upperDocName.startsWith('KTP')) docKey = 'KTP';
                    else if (upperDocName.startsWith('KK')) docKey = 'KK';

                    const details = docDetails[docKey] || docDetails['Default'];

                    document.getElementById('modal-title-doc').innerText = 'Pratinjau Dokumen: ' + docName;
                    document.getElementById('simulated-doc-title').innerText = docType;
                    document.getElementById('simulated-doc-number').innerText = docName;
                    document.getElementById('simulated-doc-type').innerText = docType;

                    const simView = document.getElementById('simulated-doc-view');
                    const actView = document.getElementById('actual-file-view');

                    // Try to get actual file blob from IndexedDB
                    const fileBlob = await getDocumentFileBlob(docName);
                    if (fileBlob && simView && actView) {
                        simView.classList.add('hidden');
                        actView.classList.remove('hidden');

                        if (currentActiveObjectUrl) {
                            URL.revokeObjectURL(currentActiveObjectUrl);
                        }
                        currentActiveObjectUrl = URL.createObjectURL(fileBlob);

                        if (fileBlob.type.startsWith('image/')) {
                            actView.innerHTML = `<img src="${currentActiveObjectUrl}" class="max-w-full max-h-[85vh] object-contain rounded-md" />`;
                        } else if (fileBlob.type === 'application/pdf') {
                            actView.innerHTML = `<iframe src="${currentActiveObjectUrl}" class="w-full h-[85vh] border-0 rounded-md"></iframe>`;
                        } else {
                            actView.innerHTML = `
                                <div class="flex flex-col items-center justify-center p-12 text-center w-full bg-white rounded shadow border border-border-subtle h-64">
                                    <span class="material-symbols-outlined text-[64px] text-primary mb-4">draft</span>
                                    <h3 class="text-body-lg font-bold">${docName}</h3>
                                    <p class="text-body-sm text-outline mt-1 mb-6">Format file tidak dapat dipratinjau secara langsung.</p>
                                    <a href="${currentActiveObjectUrl}" download="${docName}" class="bg-primary text-on-primary h-10 px-6 rounded flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-sm focus:outline-none">
                                        <span class="material-symbols-outlined">download</span>
                                        Download File
                                    </a>
                                </div>
                            `;
                        }
                    } else {
                        if (simView && actView) {
                            simView.classList.remove('hidden');
                            actView.classList.add('hidden');
                        }
                    }

                    modal.classList.remove('hidden');
                }

                const dlBtn = e.target.closest('.download-btn');
                if (dlBtn) {
                    try {
                        const docName = dlBtn.getAttribute('data-doc-name') || 'dokumen.pdf';
                        const fileBlob = await getDocumentFileBlob(docName);

                        let url;
                        if (fileBlob) {
                            url = URL.createObjectURL(fileBlob);
                        } else {
                            const dummyContent = "%PDF-1.4\n%âãÏÓ\n1 0 obj\n<<\n/Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n2 0 obj\n<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n3 0 obj\n<<\n/Type /Page\n/Parent 2 0 R\n/Resources << >>\n/MediaBox [0 0 595.275 841.89]\n>>\nendobj\nxref\n0 4\n0000000000 65535 f\n0000000015 00000 n\n0000000068 00000 n\n0000000120 00000 n\ntrailer\n<<\n/Size 4\n/Root 1 0 R\n>>\nstartxref\n201\n%%EOF";
                            const blob = new Blob([dummyContent], { type: 'application/pdf' });
                            url = URL.createObjectURL(blob);
                        }

                        const a = document.createElement('a');
                        a.href = url;
                        a.download = docName;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    } catch (err) {
                        console.error('Error downloading document:', err);
                    }
                }
            });

            closeBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    modal.classList.add('hidden');
                });
            });

            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });


            // UPLOAD MODAL LOGIC
            const uploadModal = document.getElementById('upload-modal');
            const triggerUploadBtn = document.getElementById('trigger-upload-btn');
            const closeUploadBtn = document.getElementById('close-upload-btn');
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');
            const uploadForm = document.getElementById('upload-form');
            const progressContainer = document.getElementById('progress-container');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const uploadingFileName = document.getElementById('uploading-file-name');
            const uploadDocTitle = document.getElementById('upload-doc-title');
            const skDateField = document.getElementById('sk-date-field');
            const skNomorField = document.getElementById('sk-nomor-field');
            const skTmtField = document.getElementById('sk-tmt-field');
            const uploadSkDate = document.getElementById('upload-sk-date');
            const uploadSkNomor = document.getElementById('upload-sk-nomor');
            const uploadSkTmt = document.getElementById('upload-sk-tmt');
            const uploadDocType = document.getElementById('upload-doc-type');
            const uploadCatDisplay = document.getElementById('upload-cat-display');

            const diklatJenisField = document.getElementById('diklat-jenis-field');
            const diklatTahunField = document.getElementById('diklat-tahun-field');
            const uploadDiklatJenis = document.getElementById('upload-diklat-jenis');
            const uploadDiklatTahun = document.getElementById('upload-diklat-tahun');

            uploadDocType.addEventListener('change', function() {
                if (this.value.includes('SK Pangkat') || this.value.includes('SK CPNS')) {
                    skDateField.classList.remove('hidden');
                    skNomorField.classList.remove('hidden');
                    skTmtField.classList.remove('hidden');
                    uploadSkDate.required = true;
                    uploadSkNomor.required = true;
                    uploadSkTmt.required = true;
                } else {
                    skDateField.classList.add('hidden');
                    skNomorField.classList.add('hidden');
                    skTmtField.classList.add('hidden');
                    uploadSkDate.required = false;
                    uploadSkNomor.required = false;
                    uploadSkTmt.required = false;
                }
                
                if (this.value === 'Sertifikat Diklat') {
                    diklatJenisField.classList.remove('hidden');
                    diklatTahunField.classList.remove('hidden');
                    uploadDiklatTahun.required = true;
                } else {
                    diklatJenisField.classList.add('hidden');
                    diklatTahunField.classList.add('hidden');
                    uploadDiklatTahun.required = false;
                }
            });

            triggerUploadBtn.addEventListener('click', () => {
                progressContainer.classList.add('hidden');
                progressBar.style.width = '0%';
                progressText.innerText = '0%';
                
                // Pre-select category based on currently viewed folder
                if (activeProfileFolder) {
                    uploadDocType.value = activeProfileFolder;
                    uploadCatDisplay.innerText = activeProfileFolder;
                    uploadDocType.dispatchEvent(new Event('change'));
                }
                
                uploadModal.classList.remove('hidden');
            });

            closeUploadBtn.addEventListener('click', () => {
                uploadModal.classList.add('hidden');
            });

            dropZone.addEventListener('click', () => {
                fileInput.click();
            });

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-primary', 'bg-primary/5');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-primary', 'bg-primary/5');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary', 'bg-primary/5');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileInfo();
                }
            });

            fileInput.addEventListener('change', updateFileInfo);

            function updateFileInfo() {
                if (fileInput.files.length) {
                    const file = fileInput.files[0];
                    uploadingFileName.innerText = file.name;
                    
                    if (!uploadDocTitle.value) {
                        const nameWithoutExt = file.name.replace(/\.[^/.]+$/, "");
                        uploadDocTitle.value = nameWithoutExt;
                    }
                }
            }

            uploadForm.addEventListener('submit', (e) => {
                e.preventDefault();
                if (!fileInput.files.length) {
                    alert('Silakan pilih berkas terlebih dahulu!');
                    return;
                }

                progressContainer.classList.remove('hidden');
                
                let fileName = uploadDocTitle.value;
                const docCategory = uploadDocType.value;
                
                if (docCategory.includes('SK Pangkat') || docCategory.includes('SK CPNS')) {
                    if (uploadSkNomor.value) {
                        fileName += ` [Nomor: ${uploadSkNomor.value}]`;
                    }
                    if (uploadSkTmt.value) {
                        fileName += ` [TMT: ${uploadSkTmt.value}]`;
                    }
                    if (uploadSkDate.value) {
                        fileName += ` (Tanggal: ${uploadSkDate.value})`;
                    }
                } else if (docCategory === 'Sertifikat Diklat') {
                    if (uploadDiklatJenis.value) {
                        fileName += ` [Jenis: ${uploadDiklatJenis.value}]`;
                    }
                    if (uploadDiklatTahun.value) {
                        fileName += ` [Tahun: ${uploadDiklatTahun.value}]`;
                    }
                }
                
                const actualFileName = fileInput.files[0].name;

                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    progressBar.style.width = progress + '%';
                    progressText.innerText = progress + '%';

                    if (progress >= 100) {
                        clearInterval(interval);
                        
                        // Save to IndexedDB
                        saveDocumentToDB({
                            title: fileName,
                            fileName: actualFileName,
                            pegName: currentNama,
                            pegNip: currentNip,
                            category: docCategory,
                            status: 'Valid',
                            uploadDate: 'Hari Ini',
                            fileSize: fileInput.files[0].size,
                            fileType: fileInput.files[0].type
                        }).then(() => {
                            alert('Berkas E-Arsip berhasil diunggah!');
                            uploadModal.classList.add('hidden');
                            
                            // Clear form
                            uploadForm.reset();
                            uploadingFileName.innerText = 'Tidak ada file yang dipilih';
                            fileInput.value = '';
                            uploadDocType.dispatchEvent(new Event('change'));
                            
                            // Reload docs to refresh UI
                            loadProfileDocs().then(() => {
                                viewProfileFolder(docCategory);
                            });
                        });
                    }
                }, 150);
            });

            uploadModal.addEventListener('click', function (e) {
                if (e.target === uploadModal) {
                    uploadModal.classList.add('hidden');
                }
            });
        });
    </script>
</x-layout>

@if($pegawai->getLatitude() && $pegawai->getLongitude())
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var mapEl = document.getElementById('map-show');
        if (mapEl) {
            var lat = parseFloat(mapEl.getAttribute('data-lat'));
            var lng = parseFloat(mapEl.getAttribute('data-lng'));
            
            var map = L.map('map-show').setView([lat, lng], 15);
            window.showMapInstance = map;
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map).bindPopup('{{ addslashes($pegawai->getNama()) }}').openPopup();
        }
    });
</script>
@endif
