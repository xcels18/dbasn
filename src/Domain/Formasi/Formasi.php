<?php

namespace App\Core\Domain\Formasi;

class Formasi
{
    private ?int $id;
    private string $namaJabatan;
    private int $kebutuhan;
    private int $kelasJabatan;
    private int $keterisian;

    public function __construct(
        string $namaJabatan,
        int $kebutuhan,
        int $kelasJabatan,
        int $keterisian = 0,
        ?int $id = null
    ) {
        $this->namaJabatan = $namaJabatan;
        $this->kebutuhan = $kebutuhan;
        $this->kelasJabatan = $kelasJabatan;
        $this->keterisian = $keterisian;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamaJabatan(): string
    {
        return $this->namaJabatan;
    }

    public function getKebutuhan(): int
    {
        return $this->kebutuhan;
    }

    public function getKelasJabatan(): int
    {
        return $this->kelasJabatan;
    }

    public function getKeterisian(): int
    {
        return $this->keterisian;
    }

    public function setKebutuhan(int $kebutuhan): void
    {
        $this->kebutuhan = $kebutuhan;
    }

    public function setKelasJabatan(int $kelasJabatan): void
    {
        $this->kelasJabatan = $kelasJabatan;
    }

    public function setKeterisian(int $keterisian): void
    {
        $this->keterisian = $keterisian;
    }
}
