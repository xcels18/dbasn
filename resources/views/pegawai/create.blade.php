<x-layout title="Tambah ASN Baru - Inspektorat Puncak Jaya">
    <!-- Breadcrumbs & Header -->
    <div class="px-margin-desktop pt-8 pb-6 flex flex-col gap-4">
        <nav class="flex items-center text-on-surface-variant text-label-sm font-label-sm gap-2">
            <span class="material-symbols-outlined text-[16px]">home</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a href="{{ route('pegawai.index') }}" class="hover:underline">Direktori ASN</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-bold">Tambah ASN Baru</span>
        </nav>
        <div>
            <h1 class="text-headline-lg font-headline-lg text-primary">Formulir Tambah ASN Baru</h1>
            <p class="text-body-md font-body-md text-on-surface-variant mt-1">Masukkan data lengkap aparatur sipil negara baru sesuai standar spesifikasi data kepegawaian Inspektorat.</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="px-margin-desktop pb-margin-desktop">
        <div class="bg-surface-card border border-border-subtle rounded-xl p-8 max-w-[800px] shadow-sm">
            <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Section 1: Identitas Pribadi -->
                <div class="space-y-4">
                    <h3 class="text-label-md font-label-md text-primary font-bold border-b border-border-subtle pb-2 uppercase tracking-wide">1. Identitas &amp; Master Data</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NIP Field -->
                        <div class="flex flex-col gap-1">
                            <label for="nip" class="text-label-sm font-label-sm text-on-surface-variant font-medium">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none @error('nip') border-error @enderror" placeholder="18 Digit Unik" required maxlength="18"/>
                            @error('nip') <p class="text-[11px] text-error font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nama Field -->
                        <div class="flex flex-col gap-1">
                            <label for="nama" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nama Lengkap &amp; Gelar</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none @error('nama') border-error @enderror" placeholder="Contoh: Budi Santoso, S.Kom., M.Si." required/>
                            @error('nama') <p class="text-[11px] text-error font-medium mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NIK Field -->
                        <div class="flex flex-col gap-1">
                            <label for="nik" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none @error('nik') border-error @enderror" placeholder="16 Digit NIK KTP" required maxlength="16"/>
                            @error('nik') <p class="text-[11px] text-error font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- KK Field -->
                        <div class="flex flex-col gap-1">
                            <label for="kk" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="kk" id="kk" value="{{ old('kk') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none @error('kk') border-error @enderror" placeholder="16 Digit Kartu Keluarga" required maxlength="16"/>
                            @error('kk') <p class="text-[11px] text-error font-medium mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tempat Lahir -->
                        <div class="flex flex-col gap-1">
                            <label for="tempat_lahir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: Mulia" required/>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="flex flex-col gap-1">
                            <label for="tanggal_lahir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" required/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Jenis Kelamin -->
                        <div class="flex flex-col gap-1">
                            <label for="jenis_kelamin" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Jenis Kelamin</label>
                            <div class="relative">
                                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none" required>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin') === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Agama -->
                        <div class="flex flex-col gap-1">
                            <label for="agama" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Agama</label>
                            <input type="text" name="agama" id="agama" value="{{ old('agama') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: Islam, Protestan, Kristen" required/>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Formasi & Jabatan -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-label-md font-label-md text-primary font-bold border-b border-border-subtle pb-2 uppercase tracking-wide">2. Kedudukan Hukum, Pangkat &amp; Jabatan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Jabatan -->
                        <div class="flex flex-col gap-1">
                            <label for="jabatan" class="text-label-sm font-label-sm text-on-surface-variant font-semibold">Nama Jabatan (Formasi Terdaftar)</label>
                            <div class="relative">
                                <select name="jabatan" id="jabatan" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none" required>
                                    @if(count($formasiList) === 0)
                                        <option value="" disabled selected>Belum ada formasi terdaftar. Tambahkan di Manajemen Jabatan dahulu!</option>
                                    @else
                                        <option value="" disabled selected>-- Pilih Formasi Jabatan --</option>
                                        @foreach($formasiList as $f)
                                            <option value="{{ $f->getNamaJabatan() }}" {{ old('jabatan') === $f->getNamaJabatan() ? 'selected' : '' }}>
                                                {{ $f->getNamaJabatan() }} (Kelas {{ $f->getKelasJabatan() }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                            <p class="text-[11px] text-outline mt-0.5">Jabatan disesuaikan dengan formasi terdaftar pada menu <a href="{{ route('manajemen-jabatan') }}" class="text-primary hover:underline font-bold">Manajemen Jabatan</a>.</p>
                        </div>

                        <!-- Unit Kerja -->
                        <div class="flex flex-col gap-1">
                            <label for="unit_kerja" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Unit Kerja / Penempatan</label>
                            <div class="relative">
                                <select name="unit_kerja" id="unit_kerja" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none" required>
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
                        <!-- Pangkat Golongan -->
                        <div class="flex flex-col gap-1">
                            <label for="pangkat_golongan" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pangkat &amp; Golongan Ruang terakhir</label>
                            <input type="text" name="pangkat_golongan" id="pangkat_golongan" value="{{ old('pangkat_golongan') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: Penata Tk. I (III/d)" required/>
                        </div>

                        <!-- Status Kepegawaian -->
                        <div class="flex flex-col gap-1">
                            <label for="status" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Kedudukan Hukum (Status)</label>
                            <div class="relative">
                                <select name="status" id="status" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none" required>
                                    <option value="Aktif" {{ old('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Cuti" {{ old('status') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="Non-Aktif" {{ old('status') === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Status Jabatan -->
                        <div class="flex flex-col gap-1">
                            <label for="status_jabatan" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Status Jabatan</label>
                            <div class="relative">
                                <select name="status_jabatan" id="status_jabatan" class="w-full h-10 pl-3 pr-8 rounded border border-outline-variant text-body-sm appearance-none focus:ring-primary focus:border-primary bg-transparent focus:outline-none" required>
                                    <option value="Definitif" {{ old('status_jabatan') === 'Definitif' ? 'selected' : '' }}>Definitif</option>
                                    <option value="Pelaksana Tugas (Plt)" {{ old('status_jabatan') === 'Pelaksana Tugas (Plt)' ? 'selected' : '' }}>Pelaksana Tugas (Plt)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Pendidikan & Kinerja -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-label-md font-label-md text-primary font-bold border-b border-border-subtle pb-2 uppercase tracking-wide">3. Pendidikan &amp; Kinerja</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Pendidikan Terakhir -->
                        <div class="flex flex-col gap-1">
                            <label for="pendidikan_terakhir" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pendidikan Formal Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: S1 Teknik Informatika" required/>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Kontak & Alamat -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-label-md font-label-md text-primary font-bold border-b border-border-subtle pb-2 uppercase tracking-wide">4. Kontak &amp; Alamat Lengkap</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label for="no_hp" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Nomor HP (WhatsApp)</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: 081234567890"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="email" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Email Pribadi / Dinas</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full h-10 px-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Contoh: asn@puncakjaya.go.id"/>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="alamat" class="text-label-sm font-label-sm text-on-surface-variant font-medium">Alamat Tempat Tinggal</label>
                        <textarea name="alamat" id="alamat" rows="2" class="w-full p-3 rounded border border-outline-variant text-body-sm focus:ring-1 focus:ring-primary focus:border-primary bg-transparent focus:outline-none" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm font-label-sm text-on-surface-variant font-medium">Pin Lokasi (Peta)</label>
                        <p class="text-[11px] text-outline mb-2">Geser penanda merah pada peta untuk menentukan koordinat tempat tinggal.</p>
                        
                        <!-- Peta Leaflet -->
                        <div id="map" class="w-full h-64 rounded border border-outline-variant z-10" style="position: relative;"></div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="flex flex-col gap-1">
                                <label for="latitude" class="text-[11px] text-on-surface-variant">Latitude</label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" readonly class="w-full h-8 px-2 rounded border border-outline-variant text-[11px] bg-surface-container-low focus:outline-none" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="longitude" class="text-[11px] text-on-surface-variant">Longitude</label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" readonly class="w-full h-8 px-2 rounded border border-outline-variant text-[11px] bg-surface-container-low focus:outline-none" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4 border-t border-border-subtle mt-8">
                    <button type="submit" class="bg-primary text-on-primary h-12 px-6 rounded text-label-md font-label-md hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Simpan Data
                    </button>
                    <a href="{{ route('pegawai.index') }}" class="bg-surface text-primary border border-border-subtle h-12 px-6 rounded text-label-md font-label-md hover:bg-surface-container-low transition-colors flex items-center justify-center gap-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Init Map (-3.714299, 137.973413 -> default Mulia, Puncak Jaya as example fallback if no old value)
        let defaultLat = -3.714299;
        let defaultLng = 137.973413;
        
        let oldLat = document.getElementById('latitude').value;
        let oldLng = document.getElementById('longitude').value;

        if (oldLat && oldLng) {
            defaultLat = parseFloat(oldLat);
            defaultLng = parseFloat(oldLng);
        }

        var map = L.map('map').setView([defaultLat, defaultLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

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

        // Update inputs on marker drag
        marker.on('dragend', function (e) {
            var coords = e.target.getLatLng();
            document.getElementById('latitude').value = coords.lat.toFixed(8);
            document.getElementById('longitude').value = coords.lng.toFixed(8);
            updateAddressFromCoords(coords.lat, coords.lng, 'alamat');
        });

        // Update marker and inputs on map click
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(8);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(8);
            updateAddressFromCoords(e.latlng.lat, e.latlng.lng, 'alamat');
        });

        // Set inputs initially if empty but we use default
        if (!oldLat || !oldLng) {
            document.getElementById('latitude').value = defaultLat.toFixed(8);
            document.getElementById('longitude').value = defaultLng.toFixed(8);
        }
    });
</script>
