<?php

namespace App\Core\Presentation\Page;

use App\Http\Controllers\Controller;
use App\Core\Application\Pegawai\GetDaftarPegawaiService;

class PageController extends Controller
{
    private GetDaftarPegawaiService $getDaftarPegawaiService;

    public function __construct(GetDaftarPegawaiService $getDaftarPegawaiService)
    {
        $this->getDaftarPegawaiService = $getDaftarPegawaiService;
    }


    public function jabatanFungsional(\App\Core\Application\Formasi\GetDaftarFormasiService $getDaftarFormasiService)
    {
        $pegawaiList = $this->getDaftarPegawaiService->execute();
        $formasiList = $getDaftarFormasiService->execute();
        return view('pages.jabatan-fungsional', compact('pegawaiList', 'formasiList'));
    }

    public function updateFormasi(\Illuminate\Http\Request $request, \App\Core\Application\Formasi\UpdateFormasiQuotaService $updateFormasiQuotaService)
    {
        $request->validate([
            'id' => 'required|integer',
            'kebutuhan' => 'required|integer|min:0',
            'kelas_jabatan' => 'required|integer|min:1|max:17',
        ]);

        $updateFormasiQuotaService->execute($request->id, $request->kebutuhan, $request->kelas_jabatan);

        return redirect()->route('manajemen-jabatan')->with('success', 'Formasi berhasil diperbarui!');
    }

    public function storeFormasi(\Illuminate\Http\Request $request, \App\Core\Application\Formasi\CreateFormasiService $createFormasiService)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'kebutuhan' => 'required|integer|min:0',
            'kelas_jabatan' => 'required|integer|min:1|max:17',
        ]);

        $createFormasiService->execute(
            $request->nama_jabatan,
            $request->kebutuhan,
            $request->kelas_jabatan
        );

        return redirect()->route('manajemen-jabatan')->with('success', 'Formasi Jabatan baru berhasil ditambahkan!');
    }

    public function kinerja()
    {
        $pegawaiList = $this->getDaftarPegawaiService->execute();
        return view('pages.kinerja', compact('pegawaiList'));
    }

    public function laporan()
    {
        $pegawaiList = $this->getDaftarPegawaiService->execute();
        return view('pages.laporan', compact('pegawaiList'));
    }

    public function exportExcelNominatif()
    {
        $pegawaiList = $this->getDaftarPegawaiService->execute();
        
        // Filter only active ASN
        $aktifList = array_filter($pegawaiList, function($p) {
            return $p->getStatus() === 'Aktif';
        });

        $filename = "Nominatif_ASN_Aktif_" . date('Ymd_His') . ".xls";
        
        return response(view('exports.nominatif-asn', compact('aktifList')))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function pengaturan()
    {
        return view('pages.pengaturan');
    }

    public function updateAdmin(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Kredensial admin berhasil diperbarui.');
    }

    public function generateApiToken(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $tokenName = 'Token-App-' . now()->format('YmdHi');
        $token = $user->createToken($tokenName);

        // Menghilangkan prefix ID (misal "1|") agar token terlihat bersih
        $plainToken = explode('|', $token->plainTextToken, 2)[1] ?? $token->plainTextToken;

        return redirect()->route('pengaturan')->with('api_token', $plainToken)
            ->with('success', 'Token API berhasil dibuat. Silakan salin sekarang!');
    }

    public function deleteApiToken($id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $user->tokens()->where('id', $id)->delete();
        
        return redirect()->route('pengaturan')->with('success', 'Token API berhasil dicabut.');
    }
}
