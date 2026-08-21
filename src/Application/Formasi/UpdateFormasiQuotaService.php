<?php

namespace App\Core\Application\Formasi;

use App\Core\Domain\Formasi\FormasiRepositoryInterface;

class UpdateFormasiQuotaService
{
    private FormasiRepositoryInterface $formasiRepository;

    public function __construct(FormasiRepositoryInterface $formasiRepository)
    {
        $this->formasiRepository = $formasiRepository;
    }

    public function execute(int $id, int $kebutuhan, int $kelasJabatan): void
    {
        $formasi = $this->formasiRepository->findById($id);
        if ($formasi) {
            $formasi->setKebutuhan($kebutuhan);
            $formasi->setKelasJabatan($kelasJabatan);
            $this->formasiRepository->save($formasi);
        }
    }
}
