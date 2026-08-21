<?php

namespace App\Core\Domain\Formasi;

interface FormasiRepositoryInterface
{
    public function findById(int $id): ?Formasi;
    public function findByNama(string $nama): ?Formasi;
    public function findAll(): array;
    public function save(Formasi $formasi): Formasi;
}
