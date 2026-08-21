<?php

namespace App\Core\Infrastructure\Pegawai;

use App\Core\Domain\Pegawai\Pegawai;
use App\Core\Domain\Pegawai\PegawaiRepositoryInterface;

class EloquentPegawaiRepository implements PegawaiRepositoryInterface
{
    public function findById(int $id): ?Pegawai
    {
        $model = PegawaiModel::find($id);

        if (!$model) {
            return null;
        }

        return $this->toDomain($model);
    }

    public function findAll(): array
    {
        return PegawaiModel::all()->map(function ($model) {
            return $this->toDomain($model);
        })->toArray();
    }

    public function search(array $filters): array
    {
        $query = PegawaiModel::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['jabatan'])) {
            $query->where('jabatan', 'like', "%{$filters['jabatan']}%");
        }

        return $query->get()->map(function ($model) {
            return $this->toDomain($model);
        })->toArray();
    }

    public function save(Pegawai $pegawai): Pegawai
    {
        $model = PegawaiModel::updateOrCreate(
            ['id' => $pegawai->getId()],
            [
                'nip' => $pegawai->getNip(),
                'nama' => $pegawai->getNama(),
                'nik' => $pegawai->getNik(),
                'kk' => $pegawai->getKk(),
                'tempat_lahir' => $pegawai->getTempatLahir(),
                'tanggal_lahir' => $pegawai->getTanggalLahir(),
                'jenis_kelamin' => $pegawai->getJenisKelamin(),
                'agama' => $pegawai->getAgama(),
                'jabatan' => $pegawai->getJabatan(),
                'unit_kerja' => $pegawai->getUnitKerja(),
                'pangkat_golongan' => $pegawai->getPangkatGolongan(),
                'pendidikan_terakhir' => $pegawai->getPendidikanTerakhir(),
                'status' => $pegawai->getStatus(),
                'status_jabatan' => $pegawai->getStatusJabatan(),
                'is_out_of_anjab' => $pegawai->isOutOfAnjab(),
                'no_hp' => $pegawai->getNoHp(),
                'email' => $pegawai->getEmail(),
                'alamat' => $pegawai->getAlamat(),
                'latitude' => $pegawai->getLatitude(),
                'longitude' => $pegawai->getLongitude(),
            ]
        );

        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        PegawaiModel::destroy($id);
    }

    private function toDomain(PegawaiModel $model): Pegawai
    {
        return new Pegawai(
            $model->nip,
            $model->nama,
            $model->nik,
            $model->kk,
            $model->tempat_lahir,
            $model->tanggal_lahir,
            $model->jenis_kelamin,
            $model->agama,
            $model->jabatan,
            $model->unit_kerja,
            $model->pangkat_golongan,
            $model->pendidikan_terakhir,
            $model->status,
            $model->status_jabatan ?? 'Definitif',
            (bool) ($model->is_out_of_anjab ?? false),
            $model->no_hp,
            $model->email,
            $model->alamat,
            $model->latitude !== null ? (float) $model->latitude : null,
            $model->longitude !== null ? (float) $model->longitude : null,
            $model->id
        );
    }
}
