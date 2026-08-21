<?php

namespace App\Core\Application\Pegawai;

use App\Core\Domain\Pegawai\Pegawai;
use App\Core\Domain\Pegawai\PegawaiRepositoryInterface;

class CreatePegawaiService
{
    private PegawaiRepositoryInterface $pegawaiRepository;

    public function __construct(PegawaiRepositoryInterface $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;
    }

    public function execute(
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
        string $status,
        string $statusJabatan = 'Definitif',
        bool $isOutOfAnjab = false,
        ?string $noHp = null,
        ?string $email = null,
        ?string $alamat = null,
        ?float $latitude = null,
        ?float $longitude = null
    ): Pegawai {
        $pegawai = new Pegawai(
            $nip,
            $nama,
            $nik,
            $kk,
            $tempatLahir,
            $tanggalLahir,
            $jenisKelamin,
            $agama,
            $jabatan,
            $unitKerja,
            $pangkatGolongan,
            $pendidikanTerakhir,
            $status,
            $statusJabatan,
            $isOutOfAnjab,
            $noHp,
            $email,
            $alamat,
            $latitude,
            $longitude
        );
        return $this->pegawaiRepository->save($pegawai);
    }
}
