<x-layout title="Laporan & Analitik ASN - Inspektorat Puncak Jaya">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Breadcrumbs & Header -->
    <div class="px-margin-desktop pt-8 pb-6 flex flex-col gap-4">
        <nav class="flex items-center text-on-surface-variant text-label-sm font-label-sm gap-2">
            <span class="material-symbols-outlined text-[16px]">home</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span>Statistik</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-bold">Laporan Demografi</span>
        </nav>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-headline-lg font-headline-lg text-primary">Laporan &amp; Analitik ASN</h1>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Analisis demografi komprehensif, pendidikan, masa kerja, dan penyebaran aparat sipil negara.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('laporan.export') }}" class="bg-emerald-600 text-white h-10 px-4 rounded flex items-center gap-2 hover:bg-emerald-700 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">table_chart</span>
                    <span class="text-label-md font-label-md">Unduh Nominatif (Excel)</span>
                </a>
                <button class="bg-primary text-on-primary h-10 px-4 rounded flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">download_for_offline</span>
                    <span class="text-label-md font-label-md">Unduh Laporan PDF</span>
                </button>
            </div>
        </div>
    </div>

    @php
        $total = count($pegawaiList) ?: 1;
        $aktif = count(array_filter($pegawaiList, fn($p) => $p->getStatus() === 'Aktif'));
        $cuti = count(array_filter($pegawaiList, fn($p) => $p->getStatus() === 'Cuti'));
        $nonAktif = count(array_filter($pegawaiList, fn($p) => $p->getStatus() === 'Non-Aktif'));

        // Pendidikan
        $pendidikan = [];
        foreach($pegawaiList as $p) {
            $pt = $p->getPendidikanTerakhir() ?: 'Tidak Diketahui';
            $pendidikan[$pt] = ($pendidikan[$pt] ?? 0) + 1;
        }
        arsort($pendidikan);

        // Gender
        $pria = count(array_filter($pegawaiList, fn($p) => $p->getJenisKelamin() === 'Laki-Laki'));
        $wanita = count(array_filter($pegawaiList, fn($p) => $p->getJenisKelamin() === 'Perempuan'));

        // Agama
        $agama = [];
        foreach($pegawaiList as $p) {
            $ag = $p->getAgama();
            $agama[$ag] = ($agama[$ag] ?? 0) + 1;
        }
        arsort($agama);

        // Jabatan Status
        $definitif = count(array_filter($pegawaiList, fn($p) => $p->getStatusJabatan() === 'Definitif'));
        $plt = count(array_filter($pegawaiList, fn($p) => $p->getStatusJabatan() === 'Pelaksana Tugas (Plt)'));
        $bukanAnjab = count(array_filter($pegawaiList, fn($p) => $p->isOutOfAnjab()));

        // Golongan Pangkat
        $golonganCount = ['I' => 0, 'II' => 0, 'III' => 0, 'IV' => 0];
        $subGolongan = [];
        foreach($pegawaiList as $p) {
            $pangkat = $p->getPangkatGolongan();
            if (preg_match('/(IV|III|II|I)\/[a-e]/', $pangkat, $matches)) {
                $golonganCount[$matches[1]]++;
                $subGolongan[$matches[0]] = ($subGolongan[$matches[0]] ?? 0) + 1;
            }
        }
        ksort($subGolongan);

        // Masa Kerja
        $masaKerjaGroups = ['0-5 Tahun' => 0, '6-10 Tahun' => 0, '11-20 Tahun' => 0, '> 20 Tahun' => 0];
        $totalValidMk = 0;
        foreach($pegawaiList as $p) {
            $mkString = $p->getMasaKerja();
            if ($mkString === 'NIP Tidak Valid') continue;
            
            $tahun = 0;
            if (preg_match('/(\d+)\sTahun/', $mkString, $m)) {
                $tahun = (int)$m[1];
            }
            
            $totalValidMk++;
            if ($tahun <= 5) $masaKerjaGroups['0-5 Tahun']++;
            elseif ($tahun <= 10) $masaKerjaGroups['6-10 Tahun']++;
            elseif ($tahun <= 20) $masaKerjaGroups['11-20 Tahun']++;
            else $masaKerjaGroups['> 20 Tahun']++;
        }
        $totalValidMk = $totalValidMk ?: 1;

        // Usia
        $usiaGroups = ['< 30 Tahun' => 0, '30-39 Tahun' => 0, '40-49 Tahun' => 0, '>= 50 Tahun' => 0];
        $totalValidUsia = 0;
        foreach($pegawaiList as $p) {
            $u = $p->getUsia();
            if ($u > 0) {
                $totalValidUsia++;
                if ($u < 30) $usiaGroups['< 30 Tahun']++;
                elseif ($u <= 39) $usiaGroups['30-39 Tahun']++;
                elseif ($u <= 49) $usiaGroups['40-49 Tahun']++;
                else $usiaGroups['>= 50 Tahun']++;
            }
        }
        $totalValidUsia = $totalValidUsia ?: 1;

        // Raw Data for Custom Analytics
        $rawPegawaiData = array_map(function($p) {
            $gol = preg_match('/(IV|III|II|I)/', $p->getPangkatGolongan(), $m) ? 'Golongan '.$m[1] : 'Lainnya';
            $u = $p->getUsia();
            $usiaStr = 'Tidak Diketahui';
            if ($u > 0) {
                if ($u < 30) $usiaStr = '< 30 Tahun';
                elseif ($u <= 39) $usiaStr = '30-39 Tahun';
                elseif ($u <= 49) $usiaStr = '40-49 Tahun';
                else $usiaStr = '>= 50 Tahun';
            }
            
            return [
                'nama' => $p->getNama(),
                'jenis_kelamin' => $p->getJenisKelamin() ?: 'Tidak Diketahui',
                'usia' => $usiaStr,
                'pendidikan' => $p->getPendidikanTerakhir() ?: 'Tidak Diketahui',
                'golongan' => $gol,
                'agama' => $p->getAgama() ?: 'Tidak Diketahui',
                'status_jabatan' => $p->getStatusJabatan() ?: 'Tidak Diketahui',
                'status' => $p->getStatus() ?: 'Tidak Diketahui'
            ];
        }, $pegawaiList);
        $jsonPegawaiData = json_encode($rawPegawaiData);

        // Maps Data
        $mapData = [];
        foreach($pegawaiList as $p) {
            if ($p->getLatitude() && $p->getLongitude()) {
                $mapData[] = [
                    'id' => $p->getId(),
                    'nip' => $p->getNip(),
                    'nama' => $p->getNama(),
                    'jabatan' => $p->getJabatan(),
                    'unit_kerja' => $p->getUnitKerja(),
                    'latitude' => $p->getLatitude(),
                    'longitude' => $p->getLongitude(),
                ];
            }
        }
        $jsonMapData = json_encode($mapData);

        // Reminders
        $currentYear = (int) date('Y');
        $reminderPensiun = [];
        $reminderKP = [];
        $reminderKGB = [];

        foreach($pegawaiList as $p) {
            if ($p->getStatus() !== 'Aktif') continue; // Only active ASN
            
            $nip = $p->getNip();
            if (strlen($nip) >= 14) {
                // Pensiun (Tahun Lahir + 58)
                $tahunLahir = (int) substr($nip, 0, 4);
                $bulanLahir = substr($nip, 4, 2);
                $tglLahir = substr($nip, 6, 2);

                if ($tahunLahir > 1900) {
                    $bup = 58; // Default BUP
                    if (strtolower(trim($p->getJabatan())) === 'inspektur' && strtolower(trim($p->getStatusJabatan())) === 'definitif') {
                        $bup = 60; // BUP Khusus Inspektur Definitif
                    }
                    
                    $tahunPensiun = $tahunLahir + $bup;
                    $sisaPensiun = $tahunPensiun - $currentYear;
                    if ($sisaPensiun <= 1) { 
                        $reminderPensiun[] = [
                            'nama' => $p->getNama(),
                            'nip' => $nip,
                            'tahun_pensiun' => $tahunPensiun,
                            'tgl_pensiun' => "$tglLahir/$bulanLahir/$tahunPensiun",
                            'sisa' => $sisaPensiun,
                            'bup' => $bup
                        ];
                    }
                }

                // Pengangkatan CPNS
                $tahunCpns = (int) substr($nip, 8, 4);
                $bulanCpns = substr($nip, 12, 2);
                if ($tahunCpns > 1900 && $tahunCpns <= $currentYear) {
                    $masaKerjaTotal = $currentYear - $tahunCpns;
                    
                    // Kenaikan Pangkat (every 4 years)
                    if ($masaKerjaTotal > 0 && $masaKerjaTotal % 4 === 0) {
                        $reminderKP[] = [
                            'nama' => $p->getNama(),
                            'nip' => $nip,
                            'pangkat' => $p->getPangkatGolongan(),
                            'tmt_estimasi' => "01/$bulanCpns/$currentYear",
                            'masa_kerja' => $masaKerjaTotal
                        ];
                    }
                    
                    // Kenaikan Gaji Berkala (every 2 years)
                    if ($masaKerjaTotal > 0 && $masaKerjaTotal % 2 === 0) {
                        $reminderKGB[] = [
                            'nama' => $p->getNama(),
                            'nip' => $nip,
                            'pangkat' => $p->getPangkatGolongan(),
                            'tmt_estimasi' => "01/$bulanCpns/$currentYear",
                            'masa_kerja' => $masaKerjaTotal
                        ];
                    }
                }
            }
        }
        usort($reminderPensiun, fn($a, $b) => $a['sisa'] <=> $b['sisa']);
    @endphp

    <!-- Tabs Navigation -->
    <div class="px-margin-desktop mb-6">
        <div class="flex border-b border-border-subtle">
            <button class="tab-btn active px-6 py-3 text-label-md font-bold border-b-2 border-primary text-primary transition-colors flex items-center gap-2" data-target="tab-demografi">
                <span class="material-symbols-outlined text-[18px]">analytics</span> Demografi
            </button>
            <button class="tab-btn px-6 py-3 text-label-md font-medium border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-2" data-target="tab-reminder">
                <span class="material-symbols-outlined text-[18px]">notifications_active</span> Reminder Administrasi
                @php $totalReminders = count($reminderPensiun) + count($reminderKP) + count($reminderKGB); @endphp
                @if($totalReminders > 0)
                    <span class="bg-error text-on-primary text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">{{ $totalReminders }}</span>
                @endif
            </button>
            <button class="tab-btn px-6 py-3 text-label-md font-medium border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-2" data-target="tab-sebaran-map">
                <span class="material-symbols-outlined text-[18px]">map</span> Peta Sebaran ASN
            </button>
        </div>
    </div>

    <!-- Tab 1: Demografi -->
    <div id="tab-demografi" class="tab-content block px-margin-desktop pb-margin-desktop space-y-6">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-label-sm font-label-sm text-outline mb-1">Total ASN</div>
                    <div class="text-display-sm font-display-sm text-primary font-bold">{{ $total }}</div>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[28px]">groups</span>
                </div>
            </div>
            <!-- Aktif -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-label-sm font-label-sm text-outline mb-1">ASN Aktif</div>
                    <div class="text-display-sm font-display-sm text-status-success font-bold">{{ $aktif }}</div>
                    <div class="text-[11px] text-on-surface-variant font-medium">{{ round(($aktif/$total)*100, 1) }}% dari total</div>
                </div>
                <div class="w-12 h-12 rounded-full bg-status-success/10 flex items-center justify-center text-status-success">
                    <span class="material-symbols-outlined text-[28px]">verified_user</span>
                </div>
            </div>
            <!-- Cuti -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-label-sm font-label-sm text-outline mb-1">Cuti / Tugas Belajar</div>
                    <div class="text-display-sm font-display-sm text-amber-600 font-bold">{{ $cuti }}</div>
                    <div class="text-[11px] text-on-surface-variant font-medium">{{ round(($cuti/$total)*100, 1) }}% dari total</div>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-[28px]">pending_actions</span>
                </div>
            </div>
            <!-- Non-Aktif -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-label-sm font-label-sm text-outline mb-1">Pensiun / Non-Aktif</div>
                    <div class="text-display-sm font-display-sm text-error font-bold">{{ $nonAktif }}</div>
                    <div class="text-[11px] text-on-surface-variant font-medium">{{ round(($nonAktif/$total)*100, 1) }}% dari total</div>
                </div>
                <div class="w-12 h-12 rounded-full bg-error/10 flex items-center justify-center text-error">
                    <span class="material-symbols-outlined text-[28px]">person_off</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Card 1: Demografi & Agama -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm flex flex-col h-full lg:col-span-1">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">wc</span> Jenis Kelamin & Agama
                </h3>
                
                <!-- Gender Progress -->
                <div class="mb-8">
                    <div class="flex justify-between text-label-sm mb-2 text-on-surface font-semibold">
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Pria ({{ $pria }})</span>
                        <span class="flex items-center gap-1">Wanita ({{ $wanita }}) <span class="w-3 h-3 rounded-full bg-pink-500"></span></span>
                    </div>
                    <div class="w-full h-4 rounded-full flex overflow-hidden">
                        <div class="h-full bg-blue-500 transition-all duration-1000" style="width: {{ ($pria/$total)*100 }}%"></div>
                        <div class="h-full bg-pink-500 transition-all duration-1000" style="width: {{ ($wanita/$total)*100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] mt-1 text-outline">
                        <span>{{ round(($pria/$total)*100, 1) }}%</span>
                        <span>{{ round(($wanita/$total)*100, 1) }}%</span>
                    </div>
                </div>

                <!-- Agama Breakdown -->
                <div>
                    <h4 class="text-label-sm font-bold text-outline mb-3 uppercase tracking-wider">Distribusi Agama</h4>
                    <div class="space-y-3">
                        @foreach($agama as $ag => $count)
                        <div>
                            <div class="flex justify-between text-body-sm font-medium mb-1">
                                <span>{{ $ag }}</span>
                                <span>{{ $count }} ({{ round(($count/$total)*100, 1) }}%)</span>
                            </div>
                            <div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full bg-teal-500 transition-all duration-1000" style="width: {{ ($count/$total)*100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Card 2: Pendidikan Terakhir -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm flex flex-col h-full lg:col-span-1">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">school</span> Pendidikan Terakhir
                </h3>
                
                <div class="space-y-4 flex-1">
                    @foreach($pendidikan as $level => $count)
                        @if($count > 0 || $level !== 'Lainnya')
                        <div class="group">
                            <div class="flex justify-between text-body-sm mb-1.5 font-medium group-hover:text-primary transition-colors">
                                <span>{{ $level }}</span>
                                <span>{{ $count }} ASN <span class="text-[11px] text-outline ml-1">({{ round(($count/$total)*100, 1) }}%)</span></span>
                            </div>
                            <div class="w-full h-2 bg-surface-container rounded-full overflow-hidden relative">
                                <div class="absolute top-0 left-0 h-full bg-primary/20 w-full"></div>
                                <div class="h-full bg-primary relative z-10 transition-all duration-1000" style="width: {{ ($count/$total)*100 }}%"></div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Card 3: Masa Kerja -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm flex flex-col h-full lg:col-span-1">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">hourglass_top</span> Rentang Masa Kerja
                </h3>
                
                <div class="grid grid-cols-2 gap-4">
                    @php 
                        $colors = ['0-5 Tahun' => 'bg-indigo-500', '6-10 Tahun' => 'bg-emerald-500', '11-20 Tahun' => 'bg-amber-500', '> 20 Tahun' => 'bg-rose-500'];
                    @endphp
                    
                    @foreach($masaKerjaGroups as $range => $count)
                    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl text-center hover:shadow-md transition-all">
                        <div class="text-[28px] font-display-md text-on-surface font-bold mb-1">{{ $count }}</div>
                        <div class="text-label-sm font-label-sm text-outline mb-2">{{ $range }}</div>
                        <div class="w-full bg-surface-container h-1 rounded-full overflow-hidden">
                            <div class="h-full {{ $colors[$range] }} transition-all duration-1000" style="width: {{ ($count/$totalValidMk)*100 }}%"></div>
                        </div>
                        <div class="text-[10px] text-on-surface-variant mt-1.5">{{ round(($count/$totalValidMk)*100, 1) }}% dari total valid</div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 p-3 bg-secondary-container/50 text-on-secondary-container rounded-lg flex items-start gap-3 text-body-sm">
                    <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5">info</span>
                    <p>Masa kerja dihitung otomatis secara *real-time* berdasarkan data Tahun dan Bulan Pengangkatan CPNS dari NIP setiap ASN.</p>
                </div>
            </div>

            <!-- Card 4: Pangkat & Golongan -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm lg:col-span-1">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">workspace_premium</span> Pangkat & Golongan
                </h3>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @php $gColors = ['I' => 'bg-slate-500', 'II' => 'bg-blue-500', 'III' => 'bg-amber-500', 'IV' => 'bg-purple-500']; @endphp
                    @foreach($golonganCount as $g => $count)
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-10 {{ $gColors[$g] }} rounded-full"></div>
                        <div>
                            <div class="text-label-sm font-bold text-outline">GOL {{ $g }}</div>
                            <div class="text-title-md font-bold text-on-surface">{{ $count }} <span class="text-body-sm font-normal text-on-surface-variant">ASN</span></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-2 mt-auto">
                    @foreach($subGolongan as $sg => $count)
                    <div class="inline-flex items-center border border-border-subtle rounded-lg overflow-hidden shadow-sm">
                        <div class="bg-surface-container-high px-2 py-1 text-[11px] font-bold text-on-surface border-r border-border-subtle">{{ $sg }}</div>
                        <div class="bg-surface-container-lowest px-2 py-1 text-[11px] font-medium text-primary">{{ $count }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Card 6: Usia (Demografi Umur) -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm flex flex-col h-full lg:col-span-1">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">cake</span> Rentang Usia
                </h3>
                
                <div class="space-y-4 flex-1">
                    @php 
                        $uColors = ['< 30 Tahun' => 'bg-blue-400', '30-39 Tahun' => 'bg-teal-500', '40-49 Tahun' => 'bg-amber-500', '>= 50 Tahun' => 'bg-rose-500'];
                    @endphp
                    @foreach($usiaGroups as $range => $count)
                        <div class="group">
                            <div class="flex justify-between text-body-sm mb-1.5 font-medium group-hover:text-primary transition-colors">
                                <span>{{ $range }}</span>
                                <span>{{ $count }} ASN <span class="text-[11px] text-outline ml-1">({{ round(($count/$totalValidUsia)*100, 1) }}%)</span></span>
                            </div>
                            <div class="w-full h-2 bg-surface-container rounded-full overflow-hidden relative">
                                <div class="absolute top-0 left-0 h-full bg-surface-container-high w-full"></div>
                                <div class="h-full {{ $uColors[$range] }} relative z-10 transition-all duration-1000" style="width: {{ ($count/$totalValidUsia)*100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 p-3 bg-secondary-container/30 text-on-secondary-container rounded-lg flex items-start gap-3 text-[11px]">
                    <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">info</span>
                    <p>Usia diekstrak secara dinamis dari 8 digit pertama NIP.</p>
                </div>
            </div>

            <!-- Card 5: Pemetaan Jabatan & Status -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm lg:col-span-1">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">account_balance</span> Status Jabatan
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 border border-border-subtle rounded-lg bg-surface-container-lowest">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-status-success/10 text-status-success flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                            </div>
                            <span class="text-label-md font-medium text-on-surface">Definitif</span>
                        </div>
                        <span class="text-title-md font-bold text-primary">{{ $definitif }}</span>
                    </div>

                    <div class="flex justify-between items-center p-3 border border-border-subtle rounded-lg bg-surface-container-lowest">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-amber-500/10 text-amber-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">engineering</span>
                            </div>
                            <span class="text-label-md font-medium text-on-surface">Pelaksana Tugas (Plt)</span>
                        </div>
                        <span class="text-title-md font-bold text-primary">{{ $plt }}</span>
                    </div>

                    @if($bukanAnjab > 0)
                    <div class="mt-4 p-4 border border-error/30 bg-error/10 rounded-lg">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-error">warning</span>
                            <div>
                                <h4 class="text-label-md font-bold text-error mb-1">Peringatan ANJAB</h4>
                                <p class="text-body-sm text-error/90">Terdapat <strong>{{ $bukanAnjab }} ASN</strong> yang saat ini menempati formasi di luar Analisis Jabatan (ANJAB). Segera lakukan peninjauan.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div> <!-- End Tab 1 Demografi -->

    <!-- Tab 2: Reminder -->
    <div id="tab-reminder" class="tab-content hidden px-margin-desktop pb-margin-desktop space-y-6">
        
        <!-- Pensiun Warning -->
        <div class="bg-error/10 border border-error/30 rounded-xl p-6 shadow-sm">
            <h3 class="text-title-md font-title-md text-error font-bold mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined">hourglass_empty</span> Peringatan Mendekati Pensiun
            </h3>
            <p class="text-body-sm text-error/80 mb-4">ASN aktif yang mencapai atau mendekati Batas Usia Pensiun (BUP 58 Tahun / 60 Tahun untuk Inspektur) di tahun {{ $currentYear }}.</p>
            
            <div class="overflow-x-auto bg-surface border border-error/20 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-error/5 border-b border-error/20">
                            <th class="px-4 py-3 text-label-sm font-bold text-error">NAMA / NIP</th>
                            <th class="px-4 py-3 text-label-sm font-bold text-error">TGL PROYEKSI PENSIUN</th>
                            <th class="px-4 py-3 text-label-sm font-bold text-error">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reminderPensiun as $p)
                        <tr class="border-b border-error/10 hover:bg-error/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-body-sm font-bold text-on-surface">{{ $p['nama'] }}</div>
                                <div class="text-[11px] text-on-surface-variant font-mono">{{ $p['nip'] }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-body-sm font-bold text-error">{{ $p['tgl_pensiun'] }}</div>
                                <div class="text-[11px] text-on-surface-variant font-mono">BUP: {{ $p['bup'] }} Tahun</div>
                            </td>
                            <td class="px-4 py-3 text-body-sm">
                                @if($p['sisa'] < 0)
                                    <span class="px-2 py-1 bg-error text-on-primary rounded text-[11px] font-bold">Sudah Lewat (Lebih {{ abs($p['sisa']) }} Tahun)</span>
                                @elseif($p['sisa'] === 0)
                                    <span class="px-2 py-1 bg-error text-on-primary rounded text-[11px] font-bold">Tahun Ini</span>
                                @else
                                    <span class="px-2 py-1 bg-amber-500 text-on-primary rounded text-[11px] font-bold">Tahun Depan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-body-sm text-on-surface-variant">Tidak ada ASN yang mendekati pensiun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kenaikan Pangkat -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm">
                <h3 class="text-title-md font-title-md text-primary font-bold mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined">trending_up</span> Proyeksi Kenaikan Pangkat
                </h3>
                <p class="text-body-sm text-on-surface-variant mb-4">ASN yang mencapai kelipatan 4 tahun masa kerja di tahun {{ $currentYear }}.</p>
                
                <div class="overflow-x-auto bg-surface border border-border-subtle rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-high border-b border-border-subtle">
                                <th class="px-4 py-3 text-label-sm font-bold text-on-surface">NAMA / NIP</th>
                                <th class="px-4 py-3 text-label-sm font-bold text-on-surface">GOLONGAN SAAT INI</th>
                                <th class="px-4 py-3 text-label-sm font-bold text-primary">TGL PROYEKSI (TMT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reminderKP as $kp)
                            <tr class="border-b border-border-subtle hover:bg-surface-container-lowest transition-colors">
                                <td class="px-4 py-3">
                                    <div class="text-body-sm font-bold text-on-surface">{{ $kp['nama'] }}</div>
                                    <div class="text-[11px] text-on-surface-variant font-mono">{{ $kp['nip'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-body-sm">{{ $kp['pangkat'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-body-sm font-bold text-primary">{{ $kp['tmt_estimasi'] }}</div>
                                    <div class="text-[11px] text-on-surface-variant">Siklus: {{ $kp['masa_kerja'] }} thn</div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-4 py-6 text-center text-body-sm text-on-surface-variant">Tidak ada jadwal Kenaikan Pangkat tahun ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- KGB -->
            <div class="bg-surface-card border border-border-subtle rounded-xl p-6 shadow-sm">
                <h3 class="text-title-md font-title-md text-status-success font-bold mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined">payments</span> Kenaikan Gaji Berkala (KGB)
                </h3>
                <p class="text-body-sm text-on-surface-variant mb-4">ASN yang mencapai kelipatan 2 tahun masa kerja di tahun {{ $currentYear }}.</p>
                
                <div class="overflow-x-auto bg-surface border border-border-subtle rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-high border-b border-border-subtle">
                                <th class="px-4 py-3 text-label-sm font-bold text-on-surface">NAMA / NIP</th>
                                <th class="px-4 py-3 text-label-sm font-bold text-on-surface">GOLONGAN SAAT INI</th>
                                <th class="px-4 py-3 text-label-sm font-bold text-status-success">TGL PROYEKSI (TMT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reminderKGB as $kgb)
                            <tr class="border-b border-border-subtle hover:bg-surface-container-lowest transition-colors">
                                <td class="px-4 py-3">
                                    <div class="text-body-sm font-bold text-on-surface">{{ $kgb['nama'] }}</div>
                                    <div class="text-[11px] text-on-surface-variant font-mono">{{ $kgb['nip'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-body-sm">{{ $kgb['pangkat'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-body-sm font-bold text-status-success">{{ $kgb['tmt_estimasi'] }}</div>
                                    <div class="text-[11px] text-on-surface-variant">Siklus: {{ $kgb['masa_kerja'] }} thn</div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-4 py-6 text-center text-body-sm text-on-surface-variant">Tidak ada jadwal KGB tahun ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- End Tab 2 Reminder -->

    <!-- Tab 3: Peta Sebaran ASN -->
    <div id="tab-sebaran-map" class="tab-content hidden px-margin-desktop pb-margin-desktop space-y-6 h-full">
        <div class="bg-surface-card border border-border-subtle rounded-xl p-5 shadow-sm h-full flex flex-col gap-4">
            <div class="flex justify-between items-center">
                <h2 class="text-title-lg font-bold text-on-surface">Peta Sebaran Lokasi ASN</h2>
                <div class="relative w-72">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" id="map-search" placeholder="Cari Nama atau NIP..." class="w-full bg-surface border border-border-subtle text-on-surface rounded-full pl-10 pr-4 py-2 text-body-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
            </div>
            <div id="map-sebaran" class="w-full h-[600px] rounded-lg border border-border-subtle z-0 relative z-[1]"></div>
        </div>
    </div> <!-- End Tab 3 -->

    <!-- Script for Tabs & Custom Analytics -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab Switching Logic
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Reset all buttons
                    tabBtns.forEach(b => {
                        b.classList.remove('active', 'border-primary', 'text-primary');
                        b.classList.add('border-transparent', 'text-on-surface-variant');
                    });
                    
                    // Set active button
                    btn.classList.add('active', 'border-primary', 'text-primary');
                    btn.classList.remove('border-transparent', 'text-on-surface-variant');

                    // Hide all contents
                    tabContents.forEach(c => c.classList.add('hidden'));
                    tabContents.forEach(c => c.classList.remove('block'));

                    // Show target content
                    const targetId = btn.getAttribute('data-target');
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                        targetContent.classList.add('block');

                        // If it's the map tab, invalidate size to fix gray areas
                        if (targetId === 'tab-sebaran-map' && window.sebaranMap) {
                            setTimeout(() => {
                                window.sebaranMap.invalidateSize();
                            }, 100);
                        }
                    }
                });
            });

            // --- MAP LOGIC ---
            const mapData = {!! $jsonMapData !!};
            let markers = [];
            
            // Init map only if there's a container
            const mapContainer = document.getElementById('map-sebaran');
            if (mapContainer) {
                // Default center to Puncak Jaya (approx -3.75, 137.95) or use first ASN data
                let center = [-3.75, 137.95];
                if (mapData.length > 0) {
                    center = [mapData[0].latitude, mapData[0].longitude];
                }
                
                window.sebaranMap = L.map('map-sebaran').setView(center, 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(window.sebaranMap);

                // Add markers
                mapData.forEach(asn => {
                    // Create a custom icon containing a pin and the ASN name above it
                    const iconHtml = `
                        <div class="flex flex-col items-center justify-end h-full">
                            <div class="bg-white/95 text-primary text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm border border-border-subtle mb-0.5 whitespace-nowrap pointer-events-none text-center leading-tight">
                                ${asn.nama}
                            </div>
                            <img src="https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png" class="w-[25px] h-[41px]" style="filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.3));" />
                        </div>
                    `;

                    const customIcon = L.divIcon({
                        html: iconHtml,
                        className: 'bg-transparent border-none',
                        iconSize: [120, 65],
                        iconAnchor: [60, 65], // Anchor at bottom of the marker image
                        popupAnchor: [0, -65]
                    });

                    const marker = L.marker([asn.latitude, asn.longitude], { icon: customIcon }).addTo(window.sebaranMap);
                    
                    const popupContent = `
                        <div class="p-2 min-w-[200px]">
                            <h3 class="font-bold text-primary text-sm mb-1">${asn.nama}</h3>
                            <div class="text-xs text-on-surface mb-2 font-medium">${asn.nip}</div>
                            <div class="text-xs text-on-surface-variant flex items-start gap-1 mb-1">
                                <span class="material-symbols-outlined text-[14px]">work</span>
                                <span>${asn.jabatan || '-'}</span>
                            </div>
                            <div class="text-xs text-on-surface-variant flex items-start gap-1">
                                <span class="material-symbols-outlined text-[14px]">corporate_fare</span>
                                <span>${asn.unit_kerja || '-'}</span>
                            </div>
                            <div class="mt-3 text-right">
                                <a href="/pegawai/${asn.id}" class="text-xs text-primary font-bold hover:underline">Lihat Profil &rarr;</a>
                            </div>
                        </div>
                    `;
                    marker.bindPopup(popupContent);
                    
                    // Store marker with data for filtering
                    markers.push({
                        marker: marker,
                        asn: asn
                    });
                });

                // Auto fit bounds if multiple markers exist
                if (markers.length > 0) {
                    const group = new L.featureGroup(markers.map(m => m.marker));
                    window.sebaranMap.fitBounds(group.getBounds(), { padding: [30, 30] });
                }

                // Search Filter Logic
                const searchInput = document.getElementById('map-search');
                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        let visibleMarkers = [];

                        markers.forEach(item => {
                            const match = item.asn.nama.toLowerCase().includes(searchTerm) || 
                                          item.asn.nip.toLowerCase().includes(searchTerm);
                            
                            if (match) {
                                if (!window.sebaranMap.hasLayer(item.marker)) {
                                    window.sebaranMap.addLayer(item.marker);
                                }
                                visibleMarkers.push(item.marker);
                            } else {
                                if (window.sebaranMap.hasLayer(item.marker)) {
                                    window.sebaranMap.removeLayer(item.marker);
                                }
                            }
                        });

                        // Optionally fit bounds to filtered result
                        if (visibleMarkers.length > 0 && searchTerm.length > 1) {
                            const group = new L.featureGroup(visibleMarkers);
                            window.sebaranMap.fitBounds(group.getBounds(), { padding: [30, 30], maxZoom: 16 });
                        } else if (searchTerm.length === 0 && markers.length > 0) {
                            // Reset bounds
                            const group = new L.featureGroup(markers.map(m => m.marker));
                            window.sebaranMap.fitBounds(group.getBounds(), { padding: [30, 30] });
                        }
                    });
                }
            }
            // --- END MAP LOGIC ---
        });
    </script>
</x-layout>
