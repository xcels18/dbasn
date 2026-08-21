<?php

namespace App\Core\Infrastructure\Formasi;

use Illuminate\Database\Eloquent\Model;

class FormasiModel extends Model
{
    protected $table = 'formasis';

    protected $fillable = [
        'nama_jabatan',
        'kebutuhan',
        'kelas_jabatan',
    ];
}
