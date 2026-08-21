<?php

namespace App\Core\Infrastructure\Pegawai;

use Illuminate\Database\Eloquent\Model;

class PegawaiModel extends Model
{
    protected $table = 'pegawais';

    protected $fillable = [
        'nip',
        'nama',
        'nik',
        'kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'jabatan',
        'unit_kerja',
        'pangkat_golongan',
        'pendidikan_terakhir',
        'status',
        'status_jabatan',
        'is_out_of_anjab',
        'no_hp',
        'email',
        'alamat',
        'latitude',
        'longitude',
    ];
}
