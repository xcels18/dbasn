<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('kk');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->string('pangkat_golongan');
            $table->string('pendidikan_terakhir');
            $table->decimal('nilai_skp', 5, 2)->default(0.00);
            $table->string('status')->default('Aktif');
            $table->string('status_jabatan')->default('Definitif');
            $table->boolean('is_out_of_anjab')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
