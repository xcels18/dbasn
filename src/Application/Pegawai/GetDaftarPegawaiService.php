<?php

namespace App\Core\Application\Pegawai;

use App\Core\Domain\Pegawai\PegawaiRepositoryInterface;

class GetDaftarPegawaiService
{
    private PegawaiRepositoryInterface $pegawaiRepository;

    public function __construct(PegawaiRepositoryInterface $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;
    }

    public function execute(array $filters = []): array
    {
        if (empty($filters)) {
            return $this->pegawaiRepository->findAll();
        }
        return $this->pegawaiRepository->search($filters);
    }
}
