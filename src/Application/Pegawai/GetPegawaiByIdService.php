<?php

namespace App\Core\Application\Pegawai;

use App\Core\Domain\Pegawai\Pegawai;
use App\Core\Domain\Pegawai\PegawaiRepositoryInterface;

class GetPegawaiByIdService
{
    private PegawaiRepositoryInterface $pegawaiRepository;

    public function __construct(PegawaiRepositoryInterface $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;
    }

    public function execute(int $id): ?Pegawai
    {
        return $this->pegawaiRepository->findById($id);
    }
}
