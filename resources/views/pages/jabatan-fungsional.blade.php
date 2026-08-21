@php
    $totalKebutuhan = 0;
    $totalTerisi = 0;
    foreach($formasiList as $item) {
        $totalKebutuhan += $item->getKebutuhan();
        $totalTerisi += $item->getKeterisian();
    }
    $selisihTotal = $totalTerisi - $totalKebutuhan;
@endphp
<x-layout title="Manajemen Jabatan - Inspektorat Puncak Jaya">
    <!-- Breadcrumbs & Header -->
    <div class="px-margin-desktop pt-8 pb-6 flex flex-col gap-4">
        <nav class="flex items-center text-on-surface-variant text-label-sm font-label-sm gap-2">
            <span class="material-symbols-outlined text-[16px]">home</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span>Organisasi</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-bold">Manajemen Jabatan</span>
        </nav>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-headline-lg font-headline-lg text-primary">Manajemen Jabatan</h1>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Registrasi formasi kuota jabatan ASN di lingkungan Inspektorat Kabupaten Puncak Jaya.</p>
            </div>
            <button id="trigger-create-formasi-btn" class="bg-primary text-on-primary h-10 px-4 rounded flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-sm focus:outline-none">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="text-label-md font-label-md">Tambah Formasi</span>
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="px-margin-desktop mb-6">
        <nav class="flex border-b border-border-subtle gap-2">
            <button id="tab-btn-anjab" class="tab-trigger px-6 py-3 text-label-md font-label-md text-primary border-b-2 border-primary font-bold" data-target="tab-anjab">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">analytics</span>
                    Analisis Jabatan (Anjab)
                </span>
            </button>
            <button id="tab-btn-existing" class="tab-trigger px-6 py-3 text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors border-b-2 border-transparent" data-target="tab-existing">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                    Existing (Keterisian)
                </span>
            </button>
        </nav>
    </div>

    <!-- MAIN TAB CONTENTS -->
    <div class="px-margin-desktop pb-margin-desktop">
        
        <!-- TAB 1: ANALISIS JABATAN (ANJAB) -->
        <div id="tab-anjab" class="tab-content space-y-6">
            <!-- Anjab Summary Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-surface-card border border-border-subtle rounded-lg p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">reduce_capacity</span>
                    </div>
                    <div>
                        <div class="text-headline-md font-headline-md font-bold leading-none">{{ $totalKebutuhan }}</div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant mt-1">Total Kebutuhan Formasi</div>
                    </div>
                </div>
                <div class="bg-surface-card border border-border-subtle rounded-lg p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-status-success/10 text-status-success flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">how_to_reg</span>
                    </div>
                    <div>
                        <div class="text-headline-md font-headline-md font-bold leading-none text-status-success">{{ $totalTerisi }}</div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant mt-1">Formasi Terisi (Existing)</div>
                    </div>
                </div>
                <div class="bg-surface-card border border-border-subtle rounded-lg p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-error/10 text-error flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">group_remove</span>
                    </div>
                    <div>
                        <div class="text-headline-md font-headline-md font-bold leading-none text-error">{{ $selisihTotal }}</div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant mt-1">Kekurangan Pegawai (Lapor BKN)</div>
                    </div>
                </div>
            </div>

            <!-- Anjab Comparison Grid -->
            <div class="border border-border-subtle rounded-lg bg-surface-card overflow-hidden shadow-sm">
                <div class="p-4 border-b border-border-subtle bg-surface-container-low">
                    <h3 class="text-label-lg font-label-lg text-primary font-bold">Matriks Perbandingan Kebutuhan vs Keterisian Jabatan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="text-label-sm font-label-sm text-on-surface-variant bg-surface-container-low border-b border-border-subtle font-medium">
                                <th class="py-3 px-4 text-left">Nama Jabatan Fungsional</th>
                                <th class="py-3 px-4 text-center w-32">Kebutuhan (Formasi)</th>
                                <th class="py-3 px-4 text-center w-32">Terisi (Existing)</th>
                                <th class="py-3 px-4 text-center w-32">Selisih / Kekurangan</th>
                                <th class="py-3 px-4 text-left w-56">Keterisian (%)</th>
                                <th class="py-3 px-4 text-left w-40">Status Pemenuhan</th>
                            </tr>
                        </thead>
                        <tbody class="text-body-sm font-body-sm text-on-surface divide-y divide-border-subtle font-medium">
                            @foreach($formasiList as $item)
                            @php
                                $req = $item->getKebutuhan();
                                $ext = $item->getKeterisian();
                                $pct = $req > 0 ? round(($ext / $req) * 100) : 0;
                                $diff = $ext - $req;
                                
                                // Color logic based on percentage
                                $color = 'bg-primary';
                                if ($pct < 40) {
                                    $color = 'bg-error';
                                } elseif ($pct < 80) {
                                    $color = 'bg-amber-500';
                                } else {
                                    $color = 'bg-status-success';
                                }
                            @endphp
                            <tr class="hover:bg-surface-container-lowest transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-primary">
                                    <div class="flex flex-col">
                                        <span>{{ $item->getNamaJabatan() }}</span>
                                        <span class="text-xs text-outline font-medium">Kelas Jabatan {{ $item->getKelasJabatan() }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-body-md">{{ $req }}</td>
                                <td class="py-3.5 px-4 text-center font-bold text-body-md text-status-success">{{ $ext }}</td>
                                <td class="py-3.5 px-4 text-center font-bold text-body-md {{ $diff < 0 ? 'text-error' : 'text-status-success' }}">{{ $diff }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-surface-container rounded-full overflow-hidden">
                                            <div class="h-full {{ $color }}" style="width: {{ min($pct, 100) }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-on-surface-variant shrink-0 w-8 text-right">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center justify-between gap-2">
                                        @if($pct >= 80)
                                            <span class="px-2.5 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] rounded font-bold uppercase tracking-wider">Cukup</span>
                                        @else
                                            <span class="px-2.5 py-0.5 bg-error-container/20 text-error text-[10px] rounded font-bold uppercase tracking-wider">Kurang</span>
                                        @endif
                                        
                                        <button class="edit-quota-btn p-1.5 rounded hover:bg-surface-container-high text-primary flex items-center justify-center transition-colors focus:outline-none" 
                                                data-id="{{ $item->getId() }}" 
                                                data-name="{{ $item->getNamaJabatan() }}" 
                                                data-kelas="{{ $item->getKelasJabatan() }}"
                                                data-kebutuhan="{{ $req }}">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: EXISTING (KETERISIAN) -->
        <div id="tab-existing" class="tab-content hidden">
            <div class="border border-border-subtle rounded-lg flex flex-col bg-surface-card overflow-hidden shadow-sm">
                <div class="p-4 border-b border-border-subtle bg-surface-container-low flex justify-between items-center">
                    <h3 class="text-label-lg font-label-lg text-primary font-bold">Daftar Penempatan Jabatan Fungsional Saat Ini</h3>
                </div>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-label-sm font-label-sm text-on-surface-variant bg-surface-container-low border-b border-border-subtle">
                            <th class="py-3 px-4 text-left">Jabatan Saat Ini</th>
                            <th class="py-3 px-4 text-left">Kelas Jabatan</th>
                            <th class="py-3 px-4 text-left">Total ASN</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-sm font-body-sm text-on-surface divide-y divide-border-subtle">
                        @php
                            $groupedASN = collect($pegawaiList)->groupBy(function($p) {
                                return $p->getJabatan();
                            });
                        @endphp
                        @foreach($groupedASN as $jabatanName => $asnGroup)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="py-3.5 px-4 font-medium text-primary">
                                {{ $jabatanName }}
                            </td>
                            <td class="py-3.5 px-4 text-on-surface-variant font-medium">
                                @php
                                    $matchedFormasi = collect($formasiList)->first(function($f) use ($jabatanName) {
                                        return strtolower($f->getNamaJabatan()) === strtolower($jabatanName);
                                    });
                                @endphp
                                @if($matchedFormasi)
                                    Kelas {{ $matchedFormasi->getKelasJabatan() }}
                                @else
                                    <span class="text-outline italic text-xs">Belum Diatur</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="relative group inline-block cursor-help">
                                    <span class="underline decoration-dashed decoration-primary/50 text-primary font-bold">{{ $asnGroup->count() }} ASN</span>
                                    
                                    <!-- Tooltip -->
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-xs p-3 bg-surface-container-highest text-on-surface rounded shadow-lg text-xs hidden group-hover:block z-10 border border-border-subtle">
                                        <div class="font-bold border-b border-outline-variant pb-1 mb-2">Daftar ASN:</div>
                                        <ul class="list-disc pl-4 space-y-1 text-left">
                                            @foreach($asnGroup as $asn)
                                                <li>{{ $asn->getNama() }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Edit Quota Modal -->
    <div id="quota-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle shadow-lg w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-border-subtle bg-surface-container-low flex justify-between items-center">
                <h3 class="text-headline-sm font-headline-sm text-primary font-bold">Edit Kebutuhan Jabatan</h3>
                <button id="close-quota-modal-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:bg-surface-container-high transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <!-- Modal Body -->
            <form action="{{ route('manajemen-jabatan.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="id" id="modal-formasi-id">
                
                <div>
                    <label class="text-label-sm font-label-sm text-on-surface-variant font-semibold">Nama Jabatan</label>
                    <div class="text-body-md font-bold text-primary mt-1" id="modal-nama-jabatan">Auditor Ahli Madya</div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="modal-kelas-jabatan" class="text-label-sm font-label-sm text-primary font-semibold">Kelas Jabatan</label>
                    <input type="number" name="kelas_jabatan" id="modal-kelas-jabatan" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-primary focus:border-primary bg-transparent focus:outline-none" min="1" max="17" required>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="modal-kebutuhan" class="text-label-sm font-label-sm text-primary font-semibold">Jumlah Kebutuhan Formasi</label>
                    <input type="number" name="kebutuhan" id="modal-kebutuhan" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-primary focus:border-primary bg-transparent focus:outline-none" min="0" required>
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-border-subtle">
                    <button type="button" id="cancel-quota-modal-btn" class="h-10 px-4 border border-border-subtle rounded text-label-md font-label-md hover:bg-surface-container-low transition-colors">
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

    <!-- Create Formasi Modal -->
    <div id="create-formasi-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-surface-container-lowest rounded-xl border border-border-subtle shadow-lg w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-border-subtle bg-surface-container-low flex justify-between items-center">
                <h3 class="text-headline-sm font-headline-sm text-primary font-bold">Tambah Formasi Jabatan</h3>
                <button id="close-create-formasi-modal-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:bg-surface-container-high transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <!-- Modal Body -->
            <form action="{{ route('manajemen-jabatan.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <div class="flex flex-col gap-2">
                    <label for="create-nama-jabatan" class="text-label-sm font-label-sm text-primary font-semibold">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" id="create-nama-jabatan" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: Auditor Ahli Madya" required>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="create-kelas-jabatan" class="text-label-sm font-label-sm text-primary font-semibold">Kelas Jabatan</label>
                    <input type="number" name="kelas_jabatan" id="create-kelas-jabatan" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-primary focus:border-primary bg-transparent focus:outline-none" min="1" max="17" value="9" required>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="create-kebutuhan" class="text-label-sm font-label-sm text-primary font-semibold">Jumlah Kebutuhan Formasi</label>
                    <input type="number" name="kebutuhan" id="create-kebutuhan" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-primary focus:border-primary bg-transparent focus:outline-none" min="0" value="1" required>
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-border-subtle">
                    <button type="button" id="cancel-create-formasi-modal-btn" class="h-10 px-4 border border-border-subtle rounded text-label-md font-label-md hover:bg-surface-container-low transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="h-10 px-4 bg-primary text-on-primary rounded text-label-md font-label-md hover:bg-primary/90 transition-colors shadow-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Tambah Formasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Client-side tab toggle & modal script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const triggers = document.querySelectorAll('.tab-trigger');
            const contents = document.querySelectorAll('.tab-content');

            triggers.forEach(trigger => {
                trigger.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');

                    triggers.forEach(t => {
                        t.classList.remove('text-primary', 'border-primary', 'border-b-2', 'font-bold');
                        t.classList.add('text-on-surface-variant', 'border-transparent');
                    });

                    this.classList.remove('text-on-surface-variant', 'border-transparent');
                    this.classList.add('text-primary', 'border-primary', 'border-b-2', 'font-bold');

                    contents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    document.getElementById(targetId).classList.remove('hidden');
                });
            });

            // EDIT QUOTA MODAL LOGIC
            const quotaModal = document.getElementById('quota-modal');
            const closeQuotaModalBtn = document.getElementById('close-quota-modal-btn');
            const cancelQuotaModalBtn = document.getElementById('cancel-quota-modal-btn');
            const modalFormasiId = document.getElementById('modal-formasi-id');
            const modalNamaJabatan = document.getElementById('modal-nama-jabatan');
            const modalKebutuhan = document.getElementById('modal-kebutuhan');
            const modalKelasJabatan = document.getElementById('modal-kelas-jabatan');

            document.querySelectorAll('.edit-quota-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const kelas = this.getAttribute('data-kelas');
                    const kebutuhan = this.getAttribute('data-kebutuhan');

                    modalFormasiId.value = id;
                    modalNamaJabatan.innerText = name;
                    modalKelasJabatan.value = kelas;
                    modalKebutuhan.value = kebutuhan;

                    quotaModal.classList.remove('hidden');
                    setTimeout(() => {
                        quotaModal.classList.remove('opacity-0');
                        quotaModal.querySelector('div').classList.remove('scale-95');
                    }, 50);
                });
            });

            function hideQuotaModal() {
                quotaModal.classList.add('opacity-0');
                quotaModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    quotaModal.classList.add('hidden');
                }, 300);
            }

            closeQuotaModalBtn.addEventListener('click', hideQuotaModal);
            cancelQuotaModalBtn.addEventListener('click', hideQuotaModal);
            quotaModal.addEventListener('click', function (e) {
                if (e.target === quotaModal) {
                    hideQuotaModal();
                }
            });

            // CREATE FORMASI MODAL LOGIC
            const createModal = document.getElementById('create-formasi-modal');
            const triggerCreateBtn = document.getElementById('trigger-create-formasi-btn');
            const closeCreateModalBtn = document.getElementById('close-create-formasi-modal-btn');
            const cancelCreateModalBtn = document.getElementById('cancel-create-formasi-modal-btn');

            triggerCreateBtn.addEventListener('click', function () {
                createModal.classList.remove('hidden');
                setTimeout(() => {
                    createModal.classList.remove('opacity-0');
                    createModal.querySelector('div').classList.remove('scale-95');
                }, 50);
            });

            function hideCreateModal() {
                createModal.classList.add('opacity-0');
                createModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    createModal.classList.add('hidden');
                }, 300);
            }

            closeCreateModalBtn.addEventListener('click', hideCreateModal);
            cancelCreateModalBtn.addEventListener('click', hideCreateModal);
            createModal.addEventListener('click', function (e) {
                if (e.target === createModal) {
                    hideCreateModal();
                }
            });
        });
    </script>
</x-layout>
