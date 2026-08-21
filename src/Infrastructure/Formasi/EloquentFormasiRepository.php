<?php

namespace App\Core\Infrastructure\Formasi;

use App\Core\Domain\Formasi\Formasi;
use App\Core\Domain\Formasi\FormasiRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentFormasiRepository implements FormasiRepositoryInterface
{
    public function findById(int $id): ?Formasi
    {
        $model = FormasiModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toDomain($model);
    }

    public function findByNama(string $nama): ?Formasi
    {
        $model = FormasiModel::where('nama_jabatan', $nama)->first();
        if (!$model) {
            return null;
        }
        return $this->toDomain($model);
    }

    public function findAll(): array
    {
        return FormasiModel::all()->map(function ($model) {
            return $this->toDomain($model);
        })->toArray();
    }

    public function save(Formasi $formasi): Formasi
    {
        $model = FormasiModel::updateOrCreate(
            ['id' => $formasi->getId()],
            [
                'nama_jabatan' => $formasi->getNamaJabatan(),
                'kebutuhan' => $formasi->getKebutuhan(),
                'kelas_jabatan' => $formasi->getKelasJabatan(),
            ]
        );
        return $this->toDomain($model);
    }

    private function toDomain(FormasiModel $model): Formasi
    {
        $keterisian = DB::table('pegawais')->where('jabatan', $model->nama_jabatan)->count();
        return new Formasi(
            $model->nama_jabatan,
            $model->kebutuhan,
            $model->kelas_jabatan,
            $keterisian,
            $model->id
        );
    }
}
