<x-layout title="Riwayat Pangkat - Inspektorat Puncak Jaya">
    <!-- Breadcrumbs & Header -->
    <div class="px-margin-desktop pt-8 pb-6 flex flex-col gap-4">
        <nav class="flex items-center text-on-surface-variant text-label-sm font-label-sm gap-2">
            <span class="material-symbols-outlined text-[16px]">home</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span>Kepegawaian</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-bold">Riwayat Pangkat</span>
        </nav>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-headline-lg font-headline-lg text-primary">Riwayat &amp; Kenaikan Pangkat</h1>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Sistem pelacakan berkas kenaikan pangkat reguler dan pilihan ASN Kabupaten Puncak Jaya.</p>
            </div>
            <button class="bg-primary text-on-primary h-10 px-4 rounded flex items-center gap-2 hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="text-label-md font-label-md">Usulkan Kenaikan</span>
            </button>
        </div>
    </div>

    <!-- Tracker Cards -->
    <div class="px-margin-desktop pb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-surface-card border border-border-subtle rounded-lg p-5 flex flex-col gap-2 shadow-sm border-l-4 border-l-status-success">
            <span class="text-label-sm font-label-sm text-on-surface-variant">SELESAI TAHUN INI</span>
            <div class="text-headline-lg font-headline-lg text-status-success font-bold">8 Pegawai</div>
            <p class="text-[11px] text-outline">Pangkat baru telah tercatat di SAPK BKN</p>
        </div>
        <div class="bg-surface-card border border-border-subtle rounded-lg p-5 flex flex-col gap-2 shadow-sm border-l-4 border-l-amber-500">
            <span class="text-label-sm font-label-sm text-on-surface-variant">PROSES VERIFIKASI BKN</span>
            <div class="text-headline-lg font-headline-lg text-amber-500 font-bold">2 Pegawai</div>
            <p class="text-[11px] text-outline">Menunggu persetujuan Teknis (Pertek) BKN</p>
        </div>
        <div class="bg-surface-card border border-border-subtle rounded-lg p-5 flex flex-col gap-2 shadow-sm border-l-4 border-l-primary">
            <span class="text-label-sm font-label-sm text-on-surface-variant">UPCOMING PROMOTIONS (2027)</span>
            <div class="text-headline-lg font-headline-lg text-primary font-bold">5 Pegawai</div>
            <p class="text-[11px] text-outline">Periode Kenaikan Pangkat April/Oktober</p>
        </div>
    </div>

    <!-- Table -->
    <div class="px-margin-desktop flex-1 pb-margin-desktop">
        <div class="border border-border-subtle rounded-lg flex flex-col bg-surface-card overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-label-sm font-label-sm text-on-surface-variant bg-surface-container-low">
                        <th class="py-3 px-4 border-b border-border-subtle text-left">Pegawai</th>
                        <th class="py-3 px-4 border-b border-border-subtle text-left">Golongan Terakhir</th>
                        <th class="py-3 px-4 border-b border-border-subtle text-left">Target Golongan</th>
                        <th class="py-3 px-4 border-b border-border-subtle text-left">TMT Kenaikan</th>
                        <th class="py-3 px-4 border-b border-border-subtle text-left">Jenis Kenaikan</th>
                        <th class="py-3 px-4 border-b border-border-subtle text-left">Status Prosedur</th>
                    </tr>
                </thead>
                <tbody class="text-body-sm font-body-sm text-on-surface divide-y divide-border-subtle">
                    @foreach($pegawaiList as $index => $pegawai)
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="py-3 px-4">
                            <div class="font-medium text-primary">{{ $pegawai->getNama() }}</div>
                            <div class="text-xs text-outline">NIP. {{ $pegawai->getNip() }}</div>
                        </td>
                        <td class="py-3 px-4">
                            @if($pegawai->getStatus() === 'Cuti')
                                Penata Muda (III/a)
                            @else
                                Penata Tk. I (III/d)
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($pegawai->getStatus() === 'Cuti')
                                Penata Muda Tk. I (III/b)
                            @else
                                Pembina (IV/a)
                            @endif
                        </td>
                        <td class="py-3 px-4">01 Apr 2027</td>
                        <td class="py-3 px-4">Reguler</td>
                        <td class="py-3 px-4">
                            @if($index === 0)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Validasi BKN
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Selesai
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
