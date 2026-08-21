<?php

namespace App\Core\Application\Pegawai;

use App\Core\Domain\Pegawai\PegawaiRepositoryInterface;

class DeletePegawaiService
{
    private PegawaiRepositoryInterface $pegawaiRepository;

    public function __construct(PegawaiRepositoryInterface $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;
    }

    public function execute(int $id): void
    {
        $this->pegawaiRepository->delete($id);
    }
}
