<x-layout title="Dashboard - Inspektorat Kab. Puncak Jaya">

@php
    $totalAsn = count($pegawaiList ?? []);
    $statusCounts = ['Aktif' => 0, 'Cuti' => 0, 'Pensiun' => 0, 'Non-Aktif' => 0];
    $golonganCounts = ['I' => 0, 'II' => 0, 'III' => 0, 'IV' => 0];
    $pendidikanCounts = ['SD/SMP' => 0, 'SMA/SMK' => 0, 'D3' => 0, 'S1' => 0, 'S2' => 0, 'S3' => 0];
    $jabatanCounts = [];
    $cutiList = [];

    foreach (($pegawaiList ?? []) as $p) {
        $status = $p->getStatus() ?? 'Aktif';
        if (isset($statusCounts[$status])) $statusCounts[$status]++;

        // Kumpulkan ASN yang cuti
        if ($status === 'Cuti') $cutiList[] = $p;

        // Hitung distribusi golongan
        $golRaw = $p->getPangkatGolongan() ?? '';
        if (str_contains($golRaw, 'IV/')) $golonganCounts['IV']++;
        elseif (str_contains($golRaw, 'III/')) $golonganCounts['III']++;
        elseif (str_contains($golRaw, 'II/')) $golonganCounts['II']++;
        elseif (str_contains($golRaw, 'I/')) $golonganCounts['I']++;

        // Hitung distribusi pendidikan
        $pend = strtoupper(trim($p->getPendidikanTerakhir() ?? ''));
        if (str_starts_with($pend, 'S3')) $pendidikanCounts['S3']++;
        elseif (str_starts_with($pend, 'S2')) $pendidikanCounts['S2']++;
        elseif (str_starts_with($pend, 'S1') || str_starts_with($pend, 'D4')) $pendidikanCounts['S1']++;
        elseif (str_starts_with($pend, 'D3')) $pendidikanCounts['D3']++;
        elseif (str_starts_with($pend, 'SMA') || str_starts_with($pend, 'SMK')) $pendidikanCounts['SMA/SMK']++;
        else $pendidikanCounts['SD/SMP']++;

        // Hitung distribusi jabatan
        $jab = trim($p->getJabatan() ?? 'Tidak Diketahui');
        if ($jab) $jabatanCounts[$jab] = ($jabatanCounts[$jab] ?? 0) + 1;
    }

    arsort($jabatanCounts);
    $topJabatan = array_slice($jabatanCounts, 0, 5, true);
    $totalJabatanUnik = count($jabatanCounts);

    $asnAktif    = $statusCounts['Aktif'];
    $asnCuti     = $statusCounts['Cuti'];
    $asnPensiun  = $statusCounts['Pensiun'];
    $maxGol      = max(array_values($golonganCounts)) ?: 1;
    $maxPend     = max(array_values($pendidikanCounts)) ?: 1;
    $recentAsn   = array_slice(($pegawaiList ?? []), 0, 8);
@endphp

<style>
@keyframes fadeUp { from { opacity:0; transform:translateY(10px);} to { opacity:1; transform:translateY(0);} }
.kpi-card { animation: fadeUp 0.4s ease both; transition: box-shadow 0.2s, transform 0.2s; }
.kpi-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.09); }
.quick-link:hover .ql-icon { transform: scale(1.12); }
.ql-icon { transition: transform 0.18s; }
</style>

<div class="flex items-end justify-between flex-wrap gap-3 mb-1">
    <div>
        <div class="flex items-center text-label-sm text-on-surface-variant gap-2 mb-1">
            <span>Inspektorat</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Dashboard</span>
        </div>
        <h1 class="text-headline-lg font-headline-lg text-primary leading-tight">Portal Data Kepegawaian</h1>
        <p class="text-body-sm text-on-surface-variant mt-0.5">Inspektorat Kabupaten Puncak Jaya &mdash; Ringkasan eksekutif data ASN</p>
    </div>
    <div class="flex items-center gap-2 text-label-sm text-on-surface-variant bg-surface-container-low border border-border-subtle rounded-lg px-4 py-2 shrink-0">
        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
        <span id="today-date">Memuat...</span>
    </div>
</div>

<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 w-full">
    <div class="kpi-card bg-surface-card border border-border-subtle rounded-xl p-5 flex flex-col gap-3 shadow-sm" style="animation-delay:0.05s">
        <div class="flex justify-between items-start">
            <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Total ASN</span>
            <div class="w-9 h-9 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">groups</span>
            </div>
        </div>
        <div>
            <div class="text-[2.4rem] font-black text-primary leading-none">{{ $totalAsn }}</div>
            <div class="flex items-center gap-1.5 mt-2 flex-wrap">
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-green-500/10 text-green-700">
                    <span class="material-symbols-outlined text-[11px]">check_circle</span>{{ $asnAktif }} Aktif
                </span>
                @if($asnCuti > 0)
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-700">{{ $asnCuti }} Cuti</span>
                @endif
            </div>
        </div>
    </div>

    <div class="kpi-card bg-surface-card border border-border-subtle rounded-xl p-5 flex flex-col gap-3 shadow-sm" style="animation-delay:0.10s">
        <div class="flex justify-between items-start">
            <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Jenis Jabatan</span>
            <div class="w-9 h-9 rounded-lg bg-violet-500/10 text-violet-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">account_balance</span>
            </div>
        </div>
        <div>
            <div class="text-[2.4rem] font-black text-primary leading-none">{{ $totalJabatanUnik }}</div>
            <div class="flex items-center gap-1.5 mt-2">
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-violet-500/10 text-violet-700">
                    {{ $totalJabatanUnik }} jabatan berbeda
                </span>
            </div>
            <p class="text-[11px] text-on-surface-variant mt-1">Di antara {{ $totalAsn }} pegawai</p>
        </div>
    </div>

    <div class="kpi-card bg-surface-card border border-border-subtle rounded-xl p-5 flex flex-col gap-3 shadow-sm" style="animation-delay:0.15s">
        <div class="flex justify-between items-start">
            <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Golongan Terbanyak</span>
            <div class="w-9 h-9 rounded-lg bg-teal-500/10 text-teal-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">military_tech</span>
            </div>
        </div>
        @php
            $dominanGol = array_search(max($golonganCounts), $golonganCounts);
            $dominanGolCount = max($golonganCounts);
            $dominanGolPct = $totalAsn > 0 ? round(($dominanGolCount / $totalAsn) * 100) : 0;
        @endphp
        <div>
            <div class="text-[2.4rem] font-black text-primary leading-none">Gol. {{ $dominanGol ?: '-' }}</div>
            <div class="flex items-center gap-2 mt-2">
                <div class="flex-1 bg-surface-container-highest rounded-full h-1.5 overflow-hidden">
                    <div class="bg-teal-500 h-1.5 rounded-full" style="width:{{ $dominanGolPct }}%"></div>
                </div>
                <span class="text-[11px] text-teal-600 font-bold">{{ $dominanGolPct }}%</span>
            </div>
            <p class="text-[11px] text-on-surface-variant mt-1">{{ $dominanGolCount }} dari {{ $totalAsn }} ASN</p>
        </div>
    </div>

    <div class="kpi-card bg-surface-card border border-border-subtle rounded-xl p-5 flex flex-col gap-3 shadow-sm" style="animation-delay:0.20s">
        <div class="flex justify-between items-start">
            <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Sedang Cuti</span>
            <div class="w-9 h-9 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">event_busy</span>
            </div>
        </div>
        <div>
            <div class="text-[2.4rem] font-black text-amber-600 leading-none">{{ $asnCuti }}</div>
            <div class="flex flex-col gap-1 mt-2">
                <div class="flex justify-between text-[11px]">
                    <span class="text-on-surface-variant">Pensiun</span>
                    <span class="font-bold text-slate-500">{{ $asnPensiun }}</span>
                </div>
                <div class="flex justify-between text-[11px]">
                    <span class="text-on-surface-variant">Non-Aktif</span>
                    <span class="font-bold text-rose-600">{{ $statusCounts['Non-Aktif'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-4 w-full items-start">

    <div class="xl:col-span-8 flex flex-col gap-4 w-full">

        <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm w-full">
            <div class="flex justify-between items-start mb-5 flex-wrap gap-2">
                <div>
                    <h2 class="text-label-lg font-bold text-primary">Distribusi ASN</h2>
                    <p class="text-[11px] text-on-surface-variant mt-0.5">Golongan Kepangkatan &amp; Tingkat Pendidikan</p>
                </div>
                <span class="text-[11px] text-on-surface-variant font-medium bg-surface-container-low border border-border-subtle rounded px-2 py-1">Total: {{ $totalAsn }} ASN</span>
            </div>

            <div class="flex items-end gap-3 h-40 px-2 mb-3">
                @php
                    $golColors = [
                        'I'   => ['bar' => 'bg-amber-400',  'text' => 'text-amber-600',  'label' => 'Gol. I'],
                        'II'  => ['bar' => 'bg-cyan-400',   'text' => 'text-cyan-600',   'label' => 'Gol. II'],
                        'III' => ['bar' => 'bg-blue-500',   'text' => 'text-blue-600',   'label' => 'Gol. III'],
                        'IV'  => ['bar' => 'bg-violet-500', 'text' => 'text-violet-600', 'label' => 'Gol. IV'],
                    ];
                @endphp
                @foreach($golonganCounts as $gol => $count)
                @php $pct = round(($count / $maxGol) * 100); $col = $golColors[$gol]; @endphp
                <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                    <span class="{{ $col['text'] }} text-[11px] font-bold">{{ $count }}</span>
                    <div class="w-full rounded-t-md {{ $col['bar'] }}" style="height:{{ max($pct, 3) }}%"></div>
                    <span class="text-[10px] font-semibold text-on-surface-variant">{{ $col['label'] }}</span>
                </div>
                @endforeach

                <div class="w-px bg-border-subtle self-stretch"></div>

                @php
                    $pendColors = [
                        'S3'      => ['bar' => 'bg-purple-500', 'text' => 'text-purple-600'],
                        'S2'      => ['bar' => 'bg-indigo-500', 'text' => 'text-indigo-600'],
                        'S1'      => ['bar' => 'bg-sky-500',    'text' => 'text-sky-600'],
                        'D3'      => ['bar' => 'bg-teal-400',   'text' => 'text-teal-600'],
                        'SMA/SMK' => ['bar' => 'bg-orange-400', 'text' => 'text-orange-600'],
                        'SD/SMP'  => ['bar' => 'bg-rose-400',   'text' => 'text-rose-600'],
                    ];
                @endphp
                @foreach($pendidikanCounts as $pend => $count)
                @if($count > 0)
                @php $pct2 = round(($count / $maxPend) * 100); $col2 = $pendColors[$pend]; @endphp
                <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                    <span class="{{ $col2['text'] }} text-[11px] font-bold">{{ $count }}</span>
                    <div class="w-full rounded-t-md {{ $col2['bar'] }}" style="height:{{ max($pct2, 3) }}%"></div>
                    <span class="text-[10px] font-semibold text-on-surface-variant">{{ $pend }}</span>
                </div>
                @endif
                @endforeach
            </div>

            <div class="flex gap-5 flex-wrap pt-3 border-t border-border-subtle">
                <div class="flex items-center gap-1.5 text-[11px] text-on-surface-variant font-medium">
                    <span class="w-3 h-3 rounded-sm bg-blue-500 inline-block"></span>Golongan Kepangkatan
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-on-surface-variant font-medium">
                    <span class="w-3 h-3 rounded-sm bg-sky-500 inline-block"></span>Tingkat Pendidikan
                </div>
            </div>
        </div>

        <div class="bg-surface-card border border-border-subtle rounded-xl overflow-hidden shadow-sm w-full">
            <div class="px-6 py-4 border-b border-border-subtle flex justify-between items-center">
                <div>
                    <h2 class="text-label-lg font-bold text-primary">Daftar ASN</h2>
                    <p class="text-[11px] text-on-surface-variant mt-0.5">Menampilkan {{ count($recentAsn) }} dari {{ $totalAsn }} pegawai</p>
                </div>
                <a href="{{ route('pegawai.index') }}" class="flex items-center gap-1 text-label-sm text-primary hover:underline font-semibold">
                    Lihat Semua <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low text-[11px] text-on-surface-variant uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-5 font-semibold border-b border-border-subtle">Pegawai</th>
                            <th class="py-3 px-5 font-semibold border-b border-border-subtle">NIP</th>
                            <th class="py-3 px-5 font-semibold border-b border-border-subtle">Jabatan</th>
                            <th class="py-3 px-5 font-semibold border-b border-border-subtle">Golongan</th>
                            <th class="py-3 px-5 font-semibold border-b border-border-subtle">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle text-[13px]">
                        @forelse($recentAsn as $p)
                        @php
                            $st = $p->getStatus() ?? 'Aktif';
                            $stClass = match($st) {
                                'Aktif'   => 'bg-green-500/10 text-green-700',
                                'Cuti'    => 'bg-amber-500/10 text-amber-700',
                                'Pensiun' => 'bg-slate-400/10 text-slate-600',
                                default   => 'bg-rose-500/10 text-rose-700',
                            };
                            $bgColors = ['bg-blue-500/20 text-blue-700','bg-violet-500/20 text-violet-700','bg-teal-500/20 text-teal-700','bg-rose-500/20 text-rose-700','bg-amber-500/20 text-amber-700'];
                            $bgColor = $bgColors[abs(crc32($p->getNama() ?? '')) % count($bgColors)];
                        @endphp
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $bgColor }} flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($p->getNama() ?? '?', 0, 1)) }}
                                    </div>
                                    <a href="{{ route('pegawai.show', $p->getId()) }}" class="font-semibold text-primary hover:underline">{{ $p->getNama() }}</a>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-on-surface-variant font-mono text-[12px]">{{ $p->getNip() }}</td>
                            <td class="py-3 px-5 text-on-surface">{{ Str::limit($p->getJabatan() ?? '-', 28) }}</td>
                            <td class="py-3 px-5 font-medium text-on-surface">{{ $p->getPangkatGolongan() ?? '-' }}</td>
                            <td class="py-3 px-5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $stClass }}">{{ $st }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[40px] block mb-2 opacity-30">group</span>
                                Belum ada data pegawai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="xl:col-span-4 flex flex-col gap-4 w-full">

        <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm">
            <h2 class="text-label-lg font-bold text-primary mb-4">Status Kepegawaian</h2>
            <div class="flex flex-col gap-3">
                @php
                    $statusConfig = [
                        'Aktif'     => ['color' => 'bg-green-500',  'icon' => 'check_circle'],
                        'Cuti'      => ['color' => 'bg-amber-400',  'icon' => 'event_busy'],
                        'Pensiun'   => ['color' => 'bg-slate-400',  'icon' => 'person_off'],
                        'Non-Aktif' => ['color' => 'bg-rose-400',   'icon' => 'block'],
                    ];
                @endphp
                @foreach($statusCounts as $status => $count)
                @php $cfg = $statusConfig[$status]; $pct = $totalAsn > 0 ? round(($count/$totalAsn)*100) : 0; @endphp
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg {{ $cfg['color'] }}/15 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px] {{ str_replace('bg-','text-',$cfg['color']) }}" style="font-variation-settings:'FILL' 1">{{ $cfg['icon'] }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center text-[13px] mb-1">
                            <span class="font-medium text-on-surface">{{ $status }}</span>
                            <span class="font-bold text-primary">{{ $count }} <span class="text-on-surface-variant font-normal text-[11px]">({{ $pct }}%)</span></span>
                        </div>
                        <div class="w-full bg-surface-container-highest rounded-full h-1.5 overflow-hidden">
                            <div class="{{ $cfg['color'] }} h-1.5 rounded-full" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm">
            <h2 class="text-label-lg font-bold text-primary mb-4">Akses Cepat</h2>
            <div class="grid grid-cols-3 gap-2">
                @php
                    $quickLinks = [
                        ['route' => 'pegawai.index',     'icon' => 'groups',              'label' => 'Direktori',  'color' => 'text-blue-600',   'bg' => 'bg-blue-500/10'],
                        ['route' => 'manajemen-jabatan', 'icon' => 'account_balance',     'label' => 'Jabatan',    'color' => 'text-violet-600', 'bg' => 'bg-violet-500/10'],

                        ['route' => 'laporan',           'icon' => 'analytics',           'label' => 'Laporan',    'color' => 'text-cyan-600',   'bg' => 'bg-cyan-500/10'],
                        ['route' => 'pengaturan',        'icon' => 'settings',            'label' => 'Pengaturan', 'color' => 'text-slate-600',  'bg' => 'bg-slate-400/10'],
                    ];
                @endphp
                @foreach($quickLinks as $ql)
                <a href="{{ route($ql['route']) }}" class="quick-link flex flex-col items-center gap-1.5 p-2.5 rounded-lg {{ $ql['bg'] }} border border-transparent hover:border-border-subtle transition-all text-center">
                    <div class="ql-icon w-10 h-10 rounded-lg {{ $ql['bg'] }} {{ $ql['color'] }} flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">{{ $ql['icon'] }}</span>
                    </div>
                    <span class="text-[11px] font-semibold text-on-surface leading-tight">{{ $ql['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm">
            <h2 class="text-label-lg font-bold text-primary mb-4 flex items-center gap-2">
                ASN Sedang Cuti
                @if($asnCuti > 0)
                <span class="bg-amber-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $asnCuti }}</span>
                @endif
            </h2>
            <div class="flex flex-col gap-2">
                @forelse(array_slice($cutiList, 0, 5) as $cp)
                <div class="flex items-center gap-3 p-3 rounded-lg bg-surface-container-lowest border border-surface-container">
                    @php
                        $cbgColors = ['bg-blue-500/20 text-blue-700','bg-violet-500/20 text-violet-700','bg-teal-500/20 text-teal-700','bg-amber-500/20 text-amber-700'];
                        $cbg = $cbgColors[abs(crc32($cp->getNama() ?? '')) % count($cbgColors)];
                    @endphp
                    <div class="w-8 h-8 rounded-full {{ $cbg }} flex items-center justify-center font-bold text-sm shrink-0">
                        {{ strtoupper(substr($cp->getNama() ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-semibold text-on-surface truncate">{{ $cp->getNama() }}</div>
                        <div class="text-[11px] text-on-surface-variant mt-0.5">{{ Str::limit($cp->getJabatan() ?? '-', 30) }}</div>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-700 shrink-0">Cuti</span>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-6 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[36px] opacity-30 mb-2">event_available</span>
                    <p class="text-[13px] font-medium">Tidak ada ASN yang cuti</p>
                </div>
                @endforelse
                @if($asnCuti > 5)
                <a href="{{ route('pegawai.index') }}" class="flex items-center justify-center gap-1 text-[12px] text-primary font-semibold hover:underline pt-1">
                    Lihat {{ $asnCuti - 5 }} lainnya <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const d = new Date();
    document.getElementById('today-date').textContent = d.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
</script>

</x-layout>
