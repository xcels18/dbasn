<?php

namespace App\Core\Domain\Pegawai;

interface PegawaiRepositoryInterface
{
    public function findById(int $id): ?Pegawai;
    public function findAll(): array;
    public function search(array $filters): array;
    public function save(Pegawai $pegawai): Pegawai;
    public function delete(int $id): void;
}
