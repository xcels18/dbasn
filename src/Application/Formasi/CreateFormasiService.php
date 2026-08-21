<?php

namespace App\Core\Application\Formasi;

use App\Core\Domain\Formasi\Formasi;
use App\Core\Domain\Formasi\FormasiRepositoryInterface;

class CreateFormasiService
{
    private FormasiRepositoryInterface $formasiRepository;

    public function __construct(FormasiRepositoryInterface $formasiRepository)
    {
        $this->formasiRepository = $formasiRepository;
    }

    public function execute(string $namaJabatan, int $kebutuhan, int $kelasJabatan): Formasi
    {
        $existing = $this->formasiRepository->findByNama($namaJabatan);
        if ($existing) {
            return $existing;
        }

        $formasi = new Formasi($namaJabatan, $kebutuhan, $kelasJabatan);
        return $this->formasiRepository->save($formasi);
    }
}
