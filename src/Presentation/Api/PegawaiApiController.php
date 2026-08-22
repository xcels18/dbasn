<?php

namespace App\Core\Presentation\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Application\Pegawai\GetDaftarPegawaiService;

class PegawaiApiController extends Controller
{
    private GetDaftarPegawaiService $getDaftarPegawaiService;

    public function __construct(GetDaftarPegawaiService $getDaftarPegawaiService)
    {
        $this->getDaftarPegawaiService = $getDaftarPegawaiService;
    }

    public function index(Request $request)
    {
        // Ambil filter jika ada (opsional)
        $filters = $request->only(['search']);
        
        $pegawaiList = $this->getDaftarPegawaiService->execute($filters);

        // Hanya kembalikan data dasar, tidak mengekspos dokumen.
        $safePegawaiData = collect($pegawaiList)->map(function ($pegawai) {
            return [
                'id' => $pegawai->getId(),
                'nip' => $pegawai->getNip(),
                'nama' => $pegawai->getNama(),
                'jabatan' => $pegawai->getJabatan(),
                'unit_kerja' => $pegawai->getUnitKerja(),
                'golongan' => $pegawai->getPangkatGolongan(),
                'tempat_lahir' => $pegawai->getTempatLahir(),
                'tanggal_lahir' => $pegawai->getTanggalLahir(),
                'jenis_kelamin' => $pegawai->getJenisKelamin(),
                'pendidikan_terakhir' => $pegawai->getPendidikanTerakhir(),
                'status_pegawai' => $pegawai->getStatus(),
                'latitude' => $pegawai->getLatitude(),
                'longitude' => $pegawai->getLongitude(),
                // Tidak menyertakan dokumen
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar pegawai berhasil diambil.',
            'data' => $safePegawaiData
        ], 200);
    }
}
