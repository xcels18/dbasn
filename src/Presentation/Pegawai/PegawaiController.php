<?php

namespace App\Core\Presentation\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Application\Pegawai\GetDaftarPegawaiService;
use App\Core\Application\Pegawai\GetPegawaiByIdService;
use App\Core\Application\Pegawai\CreatePegawaiService;
use App\Core\Application\Pegawai\UpdatePegawaiService;
use App\Core\Application\Pegawai\DeletePegawaiService;

class PegawaiController extends Controller
{
    private GetDaftarPegawaiService $getDaftarPegawaiService;
    private GetPegawaiByIdService $getPegawaiByIdService;
    private CreatePegawaiService $createPegawaiService;
    private UpdatePegawaiService $updatePegawaiService;
    private DeletePegawaiService $deletePegawaiService;

    public function __construct(
        GetDaftarPegawaiService $getDaftarPegawaiService,
        GetPegawaiByIdService $getPegawaiByIdService,
        CreatePegawaiService $createPegawaiService,
        UpdatePegawaiService $updatePegawaiService,
        DeletePegawaiService $deletePegawaiService
    ) {
        $this->getDaftarPegawaiService = $getDaftarPegawaiService;
        $this->getPegawaiByIdService = $getPegawaiByIdService;
        $this->createPegawaiService = $createPegawaiService;
        $this->updatePegawaiService = $updatePegawaiService;
        $this->deletePegawaiService = $deletePegawaiService;
    }

    public function index(Request $request, \App\Core\Application\Formasi\GetDaftarFormasiService $getDaftarFormasiService)
    {
        $filters = $request->only(['search', 'status', 'jabatan']);
        $pegawaiList = $this->getDaftarPegawaiService->execute($filters);
        $formasiList = $getDaftarFormasiService->execute();
        return view('pegawai.index', compact('pegawaiList', 'formasiList'));
    }

    public function apiIndex(Request $request)
    {
        $filters = $request->only(['search', 'status', 'jabatan']);
        $pegawaiList = $this->getDaftarPegawaiService->execute($filters);
        return response()->json($pegawaiList);
    }

    public function show(int $id)
    {
        $pegawai = $this->getPegawaiByIdService->execute($id);

        if (!$pegawai) {
            abort(404, 'Pegawai tidak ditemukan.');
        }

        return view('pegawai.show', compact('pegawai'));
    }

    public function create(\App\Core\Application\Formasi\GetDaftarFormasiService $getDaftarFormasiService)
    {
        $formasiList = $getDaftarFormasiService->execute();
        return view('pegawai.create', compact('formasiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:pegawais,nip|max:18',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:pegawais,nik|max:16',
            'kk' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-Laki,Perempuan',
            'agama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'custom_jabatan' => 'nullable|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Cuti,Non-Aktif',
            'status_jabatan' => 'required|string|in:Definitif,Pelaksana Tugas (Plt)',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $jabatan = $validated['jabatan'];
        $isOutOfAnjab = false;

        if ($jabatan === 'custom') {
            $jabatan = $validated['custom_jabatan'] ?? 'Jabatan Tidak Terdaftar';
            $isOutOfAnjab = true;
        }

        $this->createPegawaiService->execute(
            $validated['nip'],
            $validated['nama'],
            $validated['nik'],
            $validated['kk'],
            $validated['tempat_lahir'],
            $validated['tanggal_lahir'],
            $validated['jenis_kelamin'],
            $validated['agama'],
            $jabatan,
            $validated['unit_kerja'],
            $validated['pangkat_golongan'],
            $validated['pendidikan_terakhir'],
            $validated['status'],
            $validated['status_jabatan'],
            $isOutOfAnjab,
            $validated['no_hp'] ?? null,
            $validated['email'] ?? null,
            $validated['alamat'] ?? null,
            isset($validated['latitude']) ? (float) $validated['latitude'] : null,
            isset($validated['longitude']) ? (float) $validated['longitude'] : null
        );

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function update(int $id, Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:18|unique:pegawais,nip,' . $id,
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:pegawais,nik,' . $id,
            'kk' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-Laki,Perempuan',
            'agama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'custom_jabatan' => 'nullable|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Cuti,Non-Aktif',
            'status_jabatan' => 'required|string|in:Definitif,Pelaksana Tugas (Plt)',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $jabatan = $validated['jabatan'];
        $isOutOfAnjab = false;

        if ($jabatan === 'custom') {
            $jabatan = $validated['custom_jabatan'] ?? 'Jabatan Tidak Terdaftar';
            $isOutOfAnjab = true;
        }

        $this->updatePegawaiService->execute(
            $id,
            $validated['nip'],
            $validated['nama'],
            $validated['nik'],
            $validated['kk'],
            $validated['tempat_lahir'],
            $validated['tanggal_lahir'],
            $validated['jenis_kelamin'],
            $validated['agama'],
            $jabatan,
            $validated['unit_kerja'],
            $validated['pangkat_golongan'],
            $validated['pendidikan_terakhir'],
            $validated['status'],
            $validated['status_jabatan'],
            $isOutOfAnjab,
            $validated['no_hp'] ?? null,
            $validated['email'] ?? null,
            $validated['alamat'] ?? null,
            isset($validated['latitude']) ? (float) $validated['latitude'] : null,
            isset($validated['longitude']) ? (float) $validated['longitude'] : null
        );

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $this->deletePegawaiService->execute($id);
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus!');
    }
}
