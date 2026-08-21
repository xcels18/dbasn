<?php

namespace App\Core\Application\Formasi;

use App\Core\Domain\Formasi\FormasiRepositoryInterface;

class GetDaftarFormasiService
{
    private FormasiRepositoryInterface $formasiRepository;

    public function __construct(FormasiRepositoryInterface $formasiRepository)
    {
        $this->formasiRepository = $formasiRepository;
    }

    public function execute(): array
    {
        return $this->formasiRepository->findAll();
    }
}
