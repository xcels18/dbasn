<?php

namespace App\Core\Domain\Pegawai;

class Pegawai
{
    private ?int $id;
    private string $nip;
    private string $nama;
    private string $nik;
    private string $kk;
    private string $tempatLahir;
    private string $tanggalLahir; // Stored as Y-m-d string
    private string $jenisKelamin;
    private string $agama;
    private string $jabatan;
    private string $unitKerja;
    private string $pangkatGolongan;
    private string $pendidikanTerakhir;
    private string $status;
    private string $statusJabatan;
    private bool $isOutOfAnjab;
    private ?string $noHp;
    private ?string $email;
    private ?string $alamat;
    private ?float $latitude;
    private ?float $longitude;
 
    public function __construct(
        string $nip,
        string $nama,
        string $nik,
        string $kk,
        string $tempatLahir,
        string $tanggalLahir,
        string $jenisKelamin,
        string $agama,
        string $jabatan,
        string $unitKerja,
        string $pangkatGolongan,
        string $pendidikanTerakhir,
        string $status = 'Aktif',
        string $statusJabatan = 'Definitif',
        bool $isOutOfAnjab = false,
        ?string $noHp = null,
        ?string $email = null,
        ?string $alamat = null,
        ?float $latitude = null,
        ?float $longitude = null,
        ?int $id = null
    ) {
        $this->nip = $nip;
        $this->nama = $nama;
        $this->nik = $nik;
        $this->kk = $kk;
        $this->tempatLahir = $tempatLahir;
        $this->tanggalLahir = $tanggalLahir;
        $this->jenisKelamin = $jenisKelamin;
        $this->agama = $agama;
        $this->jabatan = $jabatan;
        $this->unitKerja = $unitKerja;
        $this->pangkatGolongan = $pangkatGolongan;
        $this->pendidikanTerakhir = $pendidikanTerakhir;
        $this->status = $status;
        $this->statusJabatan = $statusJabatan;
        $this->isOutOfAnjab = $isOutOfAnjab;
        $this->noHp = $noHp;
        $this->email = $email;
        $this->alamat = $alamat;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoHp(): ?string
    {
        return $this->noHp;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getAlamat(): ?string
    {
        return $this->alamat;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getNip(): string
    {
        return $this->nip;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getNik(): string
    {
        return $this->nik;
    }

    public function getKk(): string
    {
        return $this->kk;
    }

    public function getTempatLahir(): string
    {
        return $this->tempatLahir;
    }

    public function getTanggalLahir(): string
    {
        return $this->tanggalLahir;
    }

    public function getJenisKelamin(): string
    {
        return $this->jenisKelamin;
    }

    public function getAgama(): string
    {
        return $this->agama;
    }

    public function getJabatan(): string
    {
        return $this->jabatan;
    }

    public function getUnitKerja(): string
    {
        return $this->unitKerja;
    }

    public function getPangkatGolongan(): string
    {
        return $this->pangkatGolongan;
    }

    public function getPendidikanTerakhir(): string
    {
        return $this->pendidikanTerakhir;
    }



    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusJabatan(): string
    {
        return $this->statusJabatan;
    }

    public function getUsia(): int
    {
        // Extract YYYYMMDD from the first 8 characters of NIP
        if (strlen($this->nip) >= 8) {
            $tahunLahir = (int) substr($this->nip, 0, 4);
            $bulanLahir = (int) substr($this->nip, 4, 2);
            $tanggalLahir = (int) substr($this->nip, 6, 2);
            
            if ($tahunLahir > 1900 && $tahunLahir <= (int) date('Y')) {
                $birthDate = \DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-%02d', $tahunLahir, $bulanLahir, $tanggalLahir));
                if ($birthDate) {
                    $now = new \DateTime();
                    $diff = $now->diff($birthDate);
                    return $diff->y;
                }
            }
        }
        return 0; // Return 0 if NIP is invalid
    }

    public function isOutOfAnjab(): bool
    {
        return $this->isOutOfAnjab;
    }

    public function getMasaKerja(): string
    {
        if (strlen($this->nip) !== 18) {
            return 'NIP Tidak Valid';
        }

        $tahunCpns = (int) substr($this->nip, 8, 4);
        $bulanCpns = (int) substr($this->nip, 12, 2);

        if ($tahunCpns === 0 || $bulanCpns === 0 || $bulanCpns > 12) {
            return 'NIP Tidak Valid';
        }

        $tmtCpns = \Carbon\Carbon::createFromDate($tahunCpns, $bulanCpns, 1);
        $sekarang = \Carbon\Carbon::now();

        if ($tmtCpns->greaterThan($sekarang)) {
            return '0 Bulan';
        }

        $diff = $tmtCpns->diff($sekarang);
        
        $tahun = $diff->y;
        $bulan = $diff->m;

        if ($tahun === 0 && $bulan === 0) {
            return '0 Bulan';
        }

        $hasil = [];
        if ($tahun > 0) {
            $hasil[] = $tahun . ' Tahun';
        }
        if ($bulan > 0) {
            $hasil[] = $bulan . ' Bulan';
        }

        return implode(' ', $hasil);
    }
}
