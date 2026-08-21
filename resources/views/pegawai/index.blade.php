<x-layout title="Direktori ASN - Inspektorat Puncak Jaya">
    <!-- Breadcrumbs & Header -->
    <div class="px-margin-desktop pt-8 pb-6 flex flex-col gap-4">
        <nav class="flex items-center text-on-surface-variant text-label-sm font-label-sm gap-2">
            <span class="material-symbols-outlined text-[16px]">home</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span>Sumber Daya Manusia</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-bold">Direktori ASN</span>
        </nav>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-headline-lg font-headline-lg text-primary">Direktori &amp; Database ASN</h1>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Kelola data pegawai, jabatan, dan status kepegawaian di lingkungan Inspektorat.</p>
            </div>
            <button id="trigger-add-asn-btn" class="bg-primary text-on-primary h-10 px-4 rounded flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-sm focus:outline-none">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="text-label-md font-label-md">Tambah ASN Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="px-margin-desktop pb-6">
        <form method="GET" action="{{ route('pegawai.index') }}" class="bg-surface-card border border-border-subtle rounded-lg p-4 flex flex-wrap gap-4 items-end shadow-sm">
            <!-- Search -->
            <div class="flex-1 min-w-[240px]">
                <label class="block text-label-sm font-label-sm text-on-surface-variant mb-1">Cari Pegawai</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input name="search" value="{{ request('search') }}" class="w-full h-10 pl-10 pr-4 rounded border border-outline-variant text-body-sm focus:ring-primary focus:border-primary focus:outline-none" placeholder="Nama atau NIP..." type="text"/>
                </div>
            </div>
            <!-- Dropdown: Status -->
            <div class="w-48">
                <label class="block text-label-sm font-label-sm text-on-surface-variant mb-1">Status Kepegawaian</label>
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ request('status') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Non-Aktif" {{ request('status') === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                </div>
            </div>
            <!-- Dropdown: Jabatan -->
            <div class="w-48">
                <label class="block text-label-sm font-label-sm text-on-surface-variant mb-1">Jabatan</label>
                <div class="relative">
                    <select name="jabatan" onchange="this.form.submit()" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none">
                        <option value="">Semua Jabatan</option>
                        <option value="Auditor" {{ request('jabatan') === 'Auditor' ? 'selected' : '' }}>Auditor</option>
                        <option value="Pengawas" {{ request('jabatan') === 'Pengawas' ? 'selected' : '' }}>Pengawas</option>
                        <option value="Analis" {{ request('jabatan') === 'Analis' ? 'selected' : '' }}>Analis</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                </div>
            </div>
            <!-- Clear Filter -->
            <a href="{{ route('pegawai.index') }}" class="h-10 px-4 text-primary text-label-md font-label-md hover:bg-surface-container-low rounded transition-colors flex items-center justify-center gap-2 border border-transparent">
                <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                Reset
            </a>
        </form>
    </div>

    <!-- Data Table Section -->
    <div class="px-margin-desktop flex-1 pb-margin-desktop">
        <div class="border border-border-subtle rounded-lg flex flex-col h-full bg-surface-card overflow-hidden">
            <!-- Table Wrapper for Scroll -->
            <div class="flex-1 overflow-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-label-sm font-label-sm text-on-surface-variant bg-surface-container-low">
                            <th class="w-12 text-center py-3 border-b border-border-subtle"><input type="checkbox"/></th>
                            <th class="w-80 py-3 px-4 border-b border-border-subtle text-left">Pegawai</th>
                            <th class="py-3 px-4 border-b border-border-subtle text-left">Jabatan</th>
                            <th class="py-3 px-4 border-b border-border-subtle text-left">Unit Kerja</th>
                            <th class="py-3 px-4 border-b border-border-subtle text-left">Masa Kerja</th>
                            <th class="w-40 py-3 px-4 border-b border-border-subtle text-left">Status Dokumen</th>
                            <th class="py-3 px-4 border-b border-border-subtle text-left">Status ASN</th>
                            <th class="w-16 text-center py-3 border-b border-border-subtle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-sm font-body-sm text-on-surface divide-y divide-border-subtle">
                        @forelse($pegawaiList ?? [] as $pegawai)
                        <tr class="hover:bg-surface-container-lowest transition-colors group pegawai-row" data-nip="{{ $pegawai->getNip() }}">
                            <td class="text-center py-3"><input type="checkbox"/></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden bg-primary-container text-on-primary-container shrink-0 flex items-center justify-center font-bold text-[12px]">
                                        {{ substr($pegawai->getNama(), 0, 2) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('pegawai.show', $pegawai->getId()) }}" class="font-label-md text-primary hover:underline hover:text-primary/85 font-medium">
                                            {{ $pegawai->getNama() }}
                                        </a>
                                        <div class="text-on-surface-variant text-[11px]">{{ $pegawai->getNip() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-on-surface">{{ $pegawai->getJabatan() }}</div>
                                <div class="flex flex-wrap gap-1 mt-0.5">
                                    @if($pegawai->getStatusJabatan() === 'Pelaksana Tugas (Plt)')
                                        <span class="inline-flex items-center px-1.5 py-0.2 bg-amber-500/10 text-amber-600 text-[9px] rounded font-bold uppercase tracking-wider">PLT</span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.2 bg-primary/10 text-primary text-[9px] rounded font-bold uppercase tracking-wider">Definitif</span>
                                    @endif
                                    @if($pegawai->isOutOfAnjab())
                                        <span class="inline-flex items-center px-1.5 py-0.2 bg-red-500/10 text-red-600 text-[9px] rounded font-bold uppercase tracking-wider">Bukan ANJAB</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">{{ $pegawai->getUnitKerja() }}</td>
                            <td class="py-3 px-4">
                                {{ $pegawai->getMasaKerja() }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                                        <div class="h-full bg-red-500 doc-progress-bar transition-all duration-500" style="width: 0%"></div>
                                    </div>
                                    <span class="text-[11px] text-on-surface-variant font-medium doc-progress-text">0%</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $pegawai->getStatus() === 'Cuti' ? 'bg-tertiary-container/30 text-tertiary-container' : 'bg-secondary-container text-on-secondary-container' }}">
                                    {{ $pegawai->getStatus() }} - PNS
                                </span>
                            </td>
                            <td class="text-center py-3 relative">
                                <div class="inline-block text-left relative dropdown-container">
                                    <button class="dropdown-trigger-btn w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container-high text-on-surface-variant transition-colors focus:outline-none">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div class="dropdown-menu hidden absolute right-0 mt-1 w-36 bg-surface-container-lowest border border-border-subtle rounded shadow-lg z-30 transition-all duration-150">
                                        <div class="py-1">
                                            <button type="button" 
                                                    class="edit-pegawai-btn flex items-center w-full px-3 py-2 text-left text-body-sm hover:bg-surface-container-low text-on-surface transition-colors gap-2"
                                                    data-id="{{ $pegawai->getId() }}"
                                                    data-nip="{{ $pegawai->getNip() }}"
                                                    data-nama="{{ $pegawai->getNama() }}"
                                                    data-nik="{{ $pegawai->getNik() }}"
                                                    data-kk="{{ $pegawai->getKk() }}"
                                                    data-tempat_lahir="{{ $pegawai->getTempatLahir() }}"
                                                    data-tanggal_lahir="{{ $pegawai->getTanggalLahir() }}"
                                                    data-jenis_kelamin="{{ $pegawai->getJenisKelamin() }}"
                                                    data-agama="{{ $pegawai->getAgama() }}"
                                                    data-jabatan="{{ $pegawai->getJabatan() }}"
                                                    data-is_out_of_anjab="{{ $pegawai->isOutOfAnjab() ? 'true' : 'false' }}"
                                                    data-unit_kerja="{{ $pegawai->getUnitKerja() }}"
                                                    data-pangkat_golongan="{{ $pegawai->getPangkatGolongan() }}"
                                                    data-status_jabatan="{{ $pegawai->getStatusJabatan() }}"
                                                    data-pendidikan_terakhir="{{ $pegawai->getPendidikanTerakhir() }}"
                                                    data-no_hp="{{ $pegawai->getNoHp() }}"
                                                    data-email="{{ $pegawai->getEmail() }}"
                                                    data-alamat="{{ $pegawai->getAlamat() }}"
                                                    data-latitude="{{ $pegawai->getLatitude() }}"
                                                    data-longitude="{{ $pegawai->getLongitude() }}">
                                                <span class="material-symbols-outlined text-[16px] text-primary">edit</span>
                                                Edit ASN
                                            </button>
                                            
                                            <form action="{{ route('pegawai.destroy', $pegawai->getId()) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai {{ $pegawai->getNama() }}?')">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-3 py-2 text-left text-body-sm hover:bg-red-50 text-red-600 transition-colors gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                    Hapus ASN
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 px-6 text-center text-on-surface-variant">
                                Belum ada data pegawai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-border-subtle flex justify-between items-center bg-surface-container-lowest">
                <span class="text-body-sm font-body-sm text-on-surface-variant">Menampilkan {{ count($pegawaiList ?? []) }} data</span>
                <div class="flex gap-1">
                    <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-on-surface-variant opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 rounded bg-primary text-on-primary flex items-center justify-center text-label-sm font-label-sm">1</button>
                    <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add ASN Modal -->
    <div id="add-asn-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle shadow-lg w-full max-w-[800px] mx-4 overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-border-subtle bg-surface-container-low flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[24px]">person_add</span>
                    <h3 class="text-headline-sm font-headline-sm text-primary font-bold">Formulir Tambah ASN Baru</h3>
                </div>
                <button id="close-add-asn-modal-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:bg-surface-container-high transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form action="{{ route('pegawai.store') }}" method="POST" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                
                <!-- Section 1: Identitas Pribadi -->
                <div class="space-y-3">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">1. Identitas &amp; Master Data</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="nip" class="text-label-sm font-label-sm text-on-surface-variant font-medium">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" name="nip" id="nip" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="18 Digit Unik" required maxlength="18"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="nama" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nama Lengkap &amp; Gelar</label>
                            <input type="text" name="nama" id="nama" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Budi Santoso, S.Kom., M.Si." required/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="nik" class="text-label-sm font-label-sm text-on-surface-variant font-medium">NIK (KTP)</label>
                            <input type="text" name="nik" id="nik" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="16 Digit NIK KTP" required maxlength="16"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="kk" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="kk" id="kk" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="16 Digit Kartu Keluarga" required maxlength="16"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="tempat_lahir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Mulia" required/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="tanggal_lahir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="jenis_kelamin" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Jenis Kelamin</label>
                            <div class="relative">
                                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="agama" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Agama</label>
                            <input type="text" name="agama" id="agama" list="agama-list" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Pilih atau cari..." required/>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Pangkat & Jabatan -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">2. Kedudukan Hukum, Pangkat &amp; Jabatan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="jabatan" class="text-label-sm font-label-sm text-on-surface-variant font-semibold">Nama Jabatan (Formasi Terdaftar)</label>
                            <div class="relative">
                                <select name="jabatan" id="modal_jabatan" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    @if(count($formasiList) === 0)
                                        <option value="" disabled selected>Belum ada formasi terdaftar. Tambahkan di Manajemen Jabatan dahulu!</option>
                                        <option value="custom">-- Input Manual (Jabatan Lainnya / Tidak Terdaftar) --</option>
                                    @else
                                        <option value="" disabled selected>-- Pilih Formasi Jabatan --</option>
                                        @foreach($formasiList as $f)
                                            <option value="{{ $f->getNamaJabatan() }}">
                                                {{ $f->getNamaJabatan() }} (Kelas {{ $f->getKelasJabatan() }})
                                            </option>
                                        @endforeach
                                        <option value="custom">-- Input Manual (Jabatan Lainnya / Tidak Terdaftar) --</option>
                                    @endif
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                            <div id="custom-jabatan-container" class="hidden mt-2">
                                <label for="custom_jabatan" class="text-label-xs font-label-xs text-amber-700 font-semibold flex items-center gap-1 mb-1">
                                    <span class="material-symbols-outlined text-[14px]">warning</span> JABATAN INI AKAN TER-TAGGING "TIDAK ADA PADA ANJAB"
                                </label>
                                <input type="text" name="custom_jabatan" id="custom_jabatan" class="w-full h-10 px-3 rounded border border-amber-300 text-body-sm focus:ring-1 focus:ring-amber-500 focus:outline-none bg-transparent" placeholder="Ketik nama jabatan manual..."/>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="unit_kerja" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Unit Kerja / Penempatan</label>
                            <div class="relative">
                                <select name="unit_kerja" id="unit_kerja" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Inspektur">Inspektur</option>
                                    <option value="Sekretariat">Sekretariat</option>
                                    <option value="Inspektur Pembantu Wilayah I (Irban I)">Inspektur Pembantu Wilayah I (Irban I)</option>
                                    <option value="Inspektur Pembantu Wilayah II (Irban II)">Inspektur Pembantu Wilayah II (Irban II)</option>
                                    <option value="Inspektur Pembantu Wilayah III (Irban III)">Inspektur Pembantu Wilayah III (Irban III)</option>
                                    <option value="Inspektur Pembantu Khusus (Irbansus)">Inspektur Pembantu Khusus (Irbansus)</option>
                                    <option value="Kelompok Jabatan Fungsional">Kelompok Jabatan Fungsional</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="pangkat_golongan" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pangkat &amp; Golongan Ruang</label>
                            <input type="text" name="pangkat_golongan" id="pangkat_golongan" list="pangkat-list" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Pilih atau cari..." required/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="status" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Kedudukan Hukum (Status)</label>
                            <div class="relative">
                                <select name="status" id="status" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="status_jabatan" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Status Jabatan</label>
                            <div class="relative">
                                <select name="status_jabatan" id="status_jabatan" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Definitif">Definitif</option>
                                    <option value="Pelaksana Tugas (Plt)">Pelaksana Tugas (Plt)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Pendidikan & Kinerja -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">3. Pendidikan &amp; Kinerja</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="pendidikan_terakhir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pendidikan Formal Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="S1 Teknik Informatika" required/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="nilai_skp" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nilai SKP Terakhir</label>
                            <input type="number" step="0.01" name="nilai_skp" id="nilai_skp" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="94.50" required min="0" max="100"/>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Kontak & Alamat -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">4. Kontak &amp; Alamat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="no_hp" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor HP / WA</label>
                            <input type="text" name="no_hp" id="no_hp" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="08xxxxxxxxxx" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="email" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Email</label>
                            <input type="email" name="email" id="email" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="asn@example.com" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="alamat" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="2" class="w-full p-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Jalan ..."></textarea>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pin Lokasi</label>
                        <div id="add-map" class="w-full h-48 rounded border border-outline-variant z-10" style="position: relative;"></div>
                        <div class="grid grid-cols-2 gap-4 mt-1">
                            <div class="flex flex-col gap-1">
                                <label for="latitude" class="text-[10px] text-on-surface-variant">Latitude</label>
                                <input type="text" name="latitude" id="latitude" readonly class="w-full h-8 px-2 rounded border border-outline-variant text-[11px] bg-surface-container-low focus:outline-none" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="longitude" class="text-[10px] text-on-surface-variant">Longitude</label>
                                <input type="text" name="longitude" id="longitude" readonly class="w-full h-8 px-2 rounded border border-outline-variant text-[11px] bg-surface-container-low focus:outline-none" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end pt-4 border-t border-border-subtle">
                    <button type="button" id="cancel-add-asn-modal-btn" class="h-10 px-4 border border-border-subtle rounded text-label-md font-label-md hover:bg-surface-container-low transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="h-10 px-4 bg-primary text-on-primary rounded text-label-md font-label-md hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan ASN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Client-side add asn modal scripts -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        async function updateAddressFromCoords(lat, lng, inputId) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                const data = await response.json();
                if (data && data.display_name) {
                    document.getElementById(inputId).value = data.display_name;
                }
            } catch (error) {
                console.error('Error reverse geocoding:', error);
            }
        }

        // Init add map
        var addMapEl = document.getElementById('add-map');
        if (addMapEl) {
            window.addMapInstance = L.map('add-map').setView([-3.714299, 137.973413], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(window.addMapInstance);
            
            var addMapMarker = L.marker([-3.714299, 137.973413], {draggable: true}).addTo(window.addMapInstance);
            document.getElementById('latitude').value = "-3.714299";
            document.getElementById('longitude').value = "137.973413";
            
            addMapMarker.on('dragend', function (e) {
                var coords = e.target.getLatLng();
                document.getElementById('latitude').value = coords.lat.toFixed(8);
                document.getElementById('longitude').value = coords.lng.toFixed(8);
                updateAddressFromCoords(coords.lat, coords.lng, 'alamat');
            });
            
            window.addMapInstance.on('click', function(e) {
                addMapMarker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat.toFixed(8);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(8);
                updateAddressFromCoords(e.latlng.lat, e.latlng.lng, 'alamat');
            });
        }
        
        // Init edit map
        var editMapEl = document.getElementById('edit-map');
        if (editMapEl) {
            window.editMapInstance = L.map('edit-map').setView([-3.714299, 137.973413], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(window.editMapInstance);
        }

        const addAsnModal = document.getElementById('add-asn-modal');
            const triggerAddAsnBtn = document.getElementById('trigger-add-asn-btn');
            const closeAddAsnModalBtn = document.getElementById('close-add-asn-modal-btn');
            const cancelAddAsnModalBtn = document.getElementById('cancel-add-asn-modal-btn');

            if (triggerAddAsnBtn) {
                triggerAddAsnBtn.addEventListener('click', function () {
                    addAsnModal.classList.remove('hidden');
                    setTimeout(() => {
                        addAsnModal.classList.remove('opacity-0');
                        addAsnModal.querySelector('div').classList.remove('scale-95');
                        if (window.addMapInstance) {
                            window.addMapInstance.invalidateSize();
                        }
                    }, 50);
                });
            }

            function hideAddAsnModal() {
                addAsnModal.classList.add('opacity-0');
                addAsnModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    addAsnModal.classList.add('hidden');
                }, 300);
            }

            if (closeAddAsnModalBtn) closeAddAsnModalBtn.addEventListener('click', hideAddAsnModal);
            if (cancelAddAsnModalBtn) cancelAddAsnModalBtn.addEventListener('click', hideAddAsnModal);
            if (addAsnModal) {
                addAsnModal.addEventListener('click', function (e) {
                    if (e.target === addAsnModal) {
                        hideAddAsnModal();
                    }
                });
                
                const innerBlock = addAsnModal.querySelector('.bg-surface-container-lowest');
                if (innerBlock) {
                    innerBlock.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            }

            const modalJabatan = document.getElementById('modal_jabatan');
            const customJabatanContainer = document.getElementById('custom-jabatan-container');
            const customJabatanInput = document.getElementById('custom_jabatan');

            if (modalJabatan) {
                modalJabatan.addEventListener('change', function () {
                    if (this.value === 'custom') {
                        customJabatanContainer.classList.remove('hidden');
                        customJabatanInput.setAttribute('required', 'required');
                        customJabatanInput.focus();
                    } else {
                        customJabatanContainer.classList.add('hidden');
                        customJabatanInput.removeAttribute('required');
                        customJabatanInput.value = '';
                    }
                });
            }
        });
    </script>

    <!-- Edit ASN Modal -->
    <div id="edit-asn-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle shadow-lg w-full max-w-[800px] mx-4 overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-border-subtle bg-surface-container-low flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[24px]">edit_note</span>
                    <h3 class="text-headline-sm font-headline-sm text-primary font-bold">Edit Data ASN</h3>
                </div>
                <button id="close-edit-asn-modal-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:bg-surface-container-high transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="edit-asn-form" method="POST" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                
                <!-- Section 1: Identitas Pribadi -->
                <div class="space-y-3">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">1. Identitas &amp; Master Data</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_nip" class="text-label-sm font-label-sm text-on-surface-variant font-medium">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" name="nip" id="edit_nip" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required maxlength="18"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_nama" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nama Lengkap &amp; Gelar</label>
                            <input type="text" name="nama" id="edit_nama" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_nik" class="text-label-sm font-label-sm text-on-surface-variant font-medium">NIK (KTP)</label>
                            <input type="text" name="nik" id="edit_nik" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required maxlength="16"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_kk" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="kk" id="edit_kk" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required maxlength="16"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_tempat_lahir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_tanggal_lahir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_jenis_kelamin" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Jenis Kelamin</label>
                            <div class="relative">
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_agama" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Agama</label>
                            <input type="text" name="agama" id="edit_agama" list="agama-list" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Pilih atau cari..." required/>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Pangkat & Jabatan -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">2. Kedudukan Hukum, Pangkat &amp; Jabatan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_jabatan" class="text-label-sm font-label-sm text-on-surface-variant font-semibold">Nama Jabatan (Formasi Terdaftar)</label>
                            <div class="relative">
                                <select name="jabatan" id="edit_jabatan" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    @if(count($formasiList) === 0)
                                        <option value="" disabled selected>Belum ada formasi terdaftar. Tambahkan di Manajemen Jabatan dahulu!</option>
                                        <option value="custom">-- Input Manual (Jabatan Lainnya / Tidak Terdaftar) --</option>
                                    @else
                                        <option value="" disabled selected>-- Pilih Formasi Jabatan --</option>
                                        @foreach($formasiList as $f)
                                            <option value="{{ $f->getNamaJabatan() }}">
                                                {{ $f->getNamaJabatan() }} (Kelas {{ $f->getKelasJabatan() }})
                                            </option>
                                        @endforeach
                                        <option value="custom">-- Input Manual (Jabatan Lainnya / Tidak Terdaftar) --</option>
                                    @endif
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                            <div id="edit-custom-jabatan-container" class="hidden mt-2">
                                <label for="edit_custom_jabatan" class="text-label-xs font-label-xs text-amber-700 font-semibold flex items-center gap-1 mb-1">
                                    <span class="material-symbols-outlined text-[14px]">warning</span> JABATAN INI AKAN TER-TAGGING "TIDAK ADA PADA ANJAB"
                                </label>
                                <input type="text" name="custom_jabatan" id="edit_custom_jabatan" class="w-full h-10 px-3 rounded border border-amber-300 text-body-sm focus:ring-1 focus:ring-amber-500 focus:outline-none bg-transparent" placeholder="Ketik nama jabatan manual..."/>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_unit_kerja" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Unit Kerja / Penempatan</label>
                            <div class="relative">
                                <select name="unit_kerja" id="edit_unit_kerja" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Inspektur">Inspektur</option>
                                    <option value="Sekretariat">Sekretariat</option>
                                    <option value="Inspektur Pembantu Wilayah I (Irban I)">Inspektur Pembantu Wilayah I (Irban I)</option>
                                    <option value="Inspektur Pembantu Wilayah II (Irban II)">Inspektur Pembantu Wilayah II (Irban II)</option>
                                    <option value="Inspektur Pembantu Wilayah III (Irban III)">Inspektur Pembantu Wilayah III (Irban III)</option>
                                    <option value="Inspektur Pembantu Khusus (Irbansus)">Inspektur Pembantu Khusus (Irbansus)</option>
                                    <option value="Kelompok Jabatan Fungsional">Kelompok Jabatan Fungsional</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_pangkat_golongan" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pangkat &amp; Golongan Ruang</label>
                            <input type="text" name="pangkat_golongan" id="edit_pangkat_golongan" list="pangkat-list" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" placeholder="Pilih atau cari..." required/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_status" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Kedudukan Hukum (Status)</label>
                            <div class="relative">
                                <select name="status" id="edit_status" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_status_jabatan" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Status Jabatan</label>
                            <div class="relative">
                                <select name="status_jabatan" id="edit_status_jabatan" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary bg-transparent focus:outline-none" required>
                                    <option value="Definitif">Definitif</option>
                                    <option value="Pelaksana Tugas (Plt)">Pelaksana Tugas (Plt)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Pendidikan & Kinerja -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">3. Pendidikan &amp; Kinerja</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_pendidikan_terakhir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pendidikan Formal Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="edit_pendidikan_terakhir" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" required/>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Kontak & Alamat -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-label-sm font-label-sm text-primary font-bold border-b border-border-subtle pb-1 uppercase tracking-wide">4. Kontak &amp; Alamat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="edit_no_hp" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor HP / WA</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="edit_email" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Email</label>
                            <input type="email" name="email" id="edit_email" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="edit_alamat" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Alamat Lengkap</label>
                        <textarea name="alamat" id="edit_alamat" rows="2" class="w-full p-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:outline-none bg-transparent"></textarea>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pin Lokasi</label>
                        <div id="edit-map" class="w-full h-48 rounded border border-outline-variant z-10" style="position: relative;"></div>
                        <div class="grid grid-cols-2 gap-4 mt-1">
                            <div class="flex flex-col gap-1">
                                <label for="edit_latitude" class="text-[10px] text-on-surface-variant">Latitude</label>
                                <input type="text" name="latitude" id="edit_latitude" readonly class="w-full h-8 px-2 rounded border border-outline-variant text-[11px] bg-surface-container-low focus:outline-none" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="edit_longitude" class="text-[10px] text-on-surface-variant">Longitude</label>
                                <input type="text" name="longitude" id="edit_longitude" readonly class="w-full h-8 px-2 rounded border border-outline-variant text-[11px] bg-surface-container-low focus:outline-none" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end pt-4 border-t border-border-subtle">
                    <button type="button" id="cancel-edit-asn-modal-btn" class="h-10 px-4 border border-border-subtle rounded text-label-md font-label-md hover:bg-surface-container-low transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="h-10 px-4 bg-primary text-on-primary rounded text-label-md font-label-md hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Client-side add/edit asn modal & dropdowns scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ================= INDEXED DB LOGIC FOR STATUS DOKUMEN =================
            const DB_NAME = 'e_arsip_db';
            const DB_VERSION = 1;
            const STORE_NAME = 'documents';

            function getDocumentsFromDB() {
                return new Promise((resolve, reject) => {
                    const request = indexedDB.open(DB_NAME, DB_VERSION);
                    
                    request.onupgradeneeded = function(e) {
                        const db = e.target.result;
                        if (!db.objectStoreNames.contains(STORE_NAME)) {
                            db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
                        }
                    };

                    request.onsuccess = function(e) {
                        const db = e.target.result;
                        if (!db.objectStoreNames.contains(STORE_NAME)) {
                            resolve([]);
                            return;
                        }
                        const tx = db.transaction(STORE_NAME, 'readonly');
                        const store = tx.objectStore(STORE_NAME);
                        const getAllRequest = store.getAll();

                        getAllRequest.onsuccess = function() {
                            resolve(getAllRequest.result || []);
                        };

                        getAllRequest.onerror = function() {
                            resolve([]);
                        };
                    };

                    request.onerror = function() {
                        resolve([]);
                    };
                });
            }

            const mandatoryCategories = [
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

            getDocumentsFromDB().then(docs => {
                const rows = document.querySelectorAll('.pegawai-row');
                
                rows.forEach(row => {
                    const nip = row.getAttribute('data-nip');
                    const pBar = row.querySelector('.doc-progress-bar');
                    const pText = row.querySelector('.doc-progress-text');
                    
                    if (nip && pBar && pText) {
                        const nipDocs = docs.filter(d => d.pegNip === nip);
                        
                        let filledCategoriesCount = 0;
                        mandatoryCategories.forEach(cat => {
                            if (nipDocs.some(d => d.category === cat)) {
                                filledCategoriesCount++;
                            }
                        });

                        const percentage = Math.round((filledCategoriesCount / mandatoryCategories.length) * 100);
                        
                        // Small animation delay for better UX
                        setTimeout(() => {
                            pBar.style.width = percentage + '%';
                            pText.innerText = percentage + '%';

                            if (percentage === 100) {
                                pBar.classList.remove('bg-amber-500', 'bg-red-500');
                                pBar.classList.add('bg-status-success');
                            } else if (percentage >= 50) {
                                pBar.classList.remove('bg-status-success', 'bg-red-500');
                                pBar.classList.add('bg-amber-500');
                            } else {
                                pBar.classList.remove('bg-status-success', 'bg-amber-500');
                                pBar.classList.add('bg-red-500');
                            }
                        }, 100);
                    }
                });
            });
            // 1. DROPDOWN ACTIONS LOGIC
            const dropdownContainers = document.querySelectorAll('.dropdown-container');
            
            document.addEventListener('click', function (e) {
                dropdownContainers.forEach(container => {
                    const triggerBtn = container.querySelector('.dropdown-trigger-btn');
                    const menu = container.querySelector('.dropdown-menu');
                    
                    if (triggerBtn && triggerBtn.contains(e.target)) {
                        // Toggle menu visibility
                        menu.classList.toggle('hidden');
                    } else if (menu && !menu.contains(e.target)) {
                        // Hide menu when clicking outside
                        menu.classList.add('hidden');
                    }
                });
            });

            // 3. EDIT ASN MODAL LOGIC
            const editAsnModal = document.getElementById('edit-asn-modal');
            const closeEditAsnModalBtn = document.getElementById('close-edit-asn-modal-btn');
            const cancelEditAsnModalBtn = document.getElementById('cancel-edit-asn-modal-btn');
            const editAsnForm = document.getElementById('edit-asn-form');
            const editButtons = document.querySelectorAll('.edit-pegawai-btn');

            const editJabatanSelect = document.getElementById('edit_jabatan');
            const editCustomJabatanContainer = document.getElementById('edit-custom-jabatan-container');
            const editCustomJabatanInput = document.getElementById('edit_custom_jabatan');

            if (editJabatanSelect) {
                editJabatanSelect.addEventListener('change', function () {
                    if (this.value === 'custom') {
                        editCustomJabatanContainer.classList.remove('hidden');
                        editCustomJabatanInput.setAttribute('required', 'required');
                        editCustomJabatanInput.focus();
                    } else {
                        editCustomJabatanContainer.classList.add('hidden');
                        editCustomJabatanInput.removeAttribute('required');
                        editCustomJabatanInput.value = '';
                    }
                });
            }

            editButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const nip = this.dataset.nip;
                    const nama = this.dataset.nama;
                    const nik = this.dataset.nik;
                    const kk = this.dataset.kk;
                    const tempatLahir = this.dataset.tempat_lahir;
                    const tanggalLahir = this.dataset.tanggal_lahir;
                    const jenisKelamin = this.dataset.jenis_kelamin;
                    const agama = this.dataset.agama;
                    const jabatan = this.dataset.jabatan;
                    const isOutOfAnjab = this.dataset.is_out_of_anjab === 'true';
                    const unitKerja = this.dataset.unit_kerja;
                    const pangkatGolongan = this.dataset.pangkat_golongan;
                    const status = this.dataset.status;
                    const statusJabatan = this.dataset.status_jabatan;
                    const pendidikanTerakhir = this.dataset.pendidikan_terakhir;
                    const noHp = this.dataset.no_hp;
                    const email = this.dataset.email;
                    const alamat = this.dataset.alamat;
                    const latitude = this.dataset.latitude;
                    const longitude = this.dataset.longitude;

                    // Populate fields
                    document.getElementById('edit_nip').value = nip;
                    document.getElementById('edit_nama').value = nama;
                    document.getElementById('edit_nik').value = nik;
                    document.getElementById('edit_kk').value = kk;
                    document.getElementById('edit_tempat_lahir').value = tempatLahir;
                    document.getElementById('edit_tanggal_lahir').value = tanggalLahir;
                    document.getElementById('edit_jenis_kelamin').value = jenisKelamin;
                    document.getElementById('edit_agama').value = agama;
                    document.getElementById('edit_unit_kerja').value = unitKerja;
                    document.getElementById('edit_pangkat_golongan').value = pangkatGolongan;
                    document.getElementById('edit_status').value = status;
                    document.getElementById('edit_status_jabatan').value = statusJabatan;
                    document.getElementById('edit_pendidikan_terakhir').value = pendidikanTerakhir;
                    document.getElementById('edit_no_hp').value = noHp || '';
                    document.getElementById('edit_email').value = email || '';
                    document.getElementById('edit_alamat').value = alamat || '';
                    document.getElementById('edit_latitude').value = latitude || '';
                    document.getElementById('edit_longitude').value = longitude || '';

                    // Reset and Setup Edit Map
                    setTimeout(() => {
                        if (window.editMapMarker) {
                            window.editMapInstance.removeLayer(window.editMapMarker);
                        }
                        
                        let eLat = latitude ? parseFloat(latitude) : -3.714299;
                        let eLng = longitude ? parseFloat(longitude) : 137.973413;
                        
                        window.editMapInstance.setView([eLat, eLng], 13);
                        window.editMapInstance.invalidateSize();
                        
                        window.editMapMarker = L.marker([eLat, eLng], {draggable: true}).addTo(window.editMapInstance);
                        
                        if(!latitude || !longitude) {
                            document.getElementById('edit_latitude').value = eLat.toFixed(8);
                            document.getElementById('edit_longitude').value = eLng.toFixed(8);
                        }
                        window.editMapMarker.on('dragend', function (e) {
                            var coords = e.target.getLatLng();
                            document.getElementById('edit_latitude').value = coords.lat.toFixed(8);
                            document.getElementById('edit_longitude').value = coords.lng.toFixed(8);
                            updateAddressFromCoords(coords.lat, coords.lng, 'edit_alamat');
                        });
                        
                        window.editMapInstance.off('click'); // clear previous listeners to avoid duplicates
                        window.editMapInstance.on('click', function(e) {
                            if(window.editMapMarker) {
                                window.editMapMarker.setLatLng(e.latlng);
                                document.getElementById('edit_latitude').value = e.latlng.lat.toFixed(8);
                                document.getElementById('edit_longitude').value = e.latlng.lng.toFixed(8);
                                updateAddressFromCoords(e.latlng.lat, e.latlng.lng, 'edit_alamat');
                            }
                        });
                    }, 100);

                    // Handle jabatan select/custom
                    let selectOptionExists = false;
                    for (let i = 0; i < editJabatanSelect.options.length; i++) {
                        if (editJabatanSelect.options[i].value === jabatan) {
                            selectOptionExists = true;
                            break;
                        }
                    }

                    if (isOutOfAnjab || !selectOptionExists) {
                        editJabatanSelect.value = 'custom';
                        editCustomJabatanContainer.classList.remove('hidden');
                        editCustomJabatanInput.value = jabatan;
                        editCustomJabatanInput.setAttribute('required', 'required');
                    } else {
                        editJabatanSelect.value = jabatan;
                        editCustomJabatanContainer.classList.add('hidden');
                        editCustomJabatanInput.value = '';
                        editCustomJabatanInput.removeAttribute('required');
                    }

                    // Set Form Action
                    editAsnForm.setAttribute('action', `/pegawai/${id}/update`);

                    // Show Modal
                    editAsnModal.classList.remove('hidden');
                    setTimeout(() => {
                        editAsnModal.classList.remove('opacity-0');
                        editAsnModal.querySelector('div').classList.remove('scale-95');
                    }, 50);
                });
            });

            function hideEditAsnModal() {
                editAsnModal.classList.add('opacity-0');
                editAsnModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    editAsnModal.classList.add('hidden');
                }, 300);
            }

            if (closeEditAsnModalBtn) closeEditAsnModalBtn.addEventListener('click', hideEditAsnModal);
            if (cancelEditAsnModalBtn) cancelEditAsnModalBtn.addEventListener('click', hideEditAsnModal);
            if (editAsnModal) {
                editAsnModal.addEventListener('click', function (e) {
                    if (e.target === editAsnModal) {
                        hideEditAsnModal();
                    }
                });
                
                const innerEditBlock = editAsnModal.querySelector('.bg-surface-container-lowest');
                if (innerEditBlock) {
                    innerEditBlock.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            }
        });
    </script>

    <!-- Datalists for Searchable Dropdowns -->
    <datalist id="agama-list">
        <option value="Islam">
        <option value="Kristen Protestan">
        <option value="Katolik">
        <option value="Hindu">
        <option value="Buddha">
        <option value="Khonghucu">
    </datalist>

    <datalist id="pangkat-list">
        <option value="Juru Muda (I/a)">
        <option value="Juru Muda Tk. I (I/b)">
        <option value="Juru (I/c)">
        <option value="Juru Tk. I (I/d)">
        <option value="Pengatur Muda (II/a)">
        <option value="Pengatur Muda Tk. I (II/b)">
        <option value="Pengatur (II/c)">
        <option value="Pengatur Tk. I (II/d)">
        <option value="Penata Muda (III/a)">
        <option value="Penata Muda Tk. I (III/b)">
        <option value="Penata (III/c)">
        <option value="Penata Tk. I (III/d)">
        <option value="Pembina (IV/a)">
        <option value="Pembina Tk. I (IV/b)">
        <option value="Pembina Utama Muda (IV/c)">
        <option value="Pembina Utama Madya (IV/d)">
        <option value="Pembina Utama (IV/e)">
    </datalist>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</x-layout>
