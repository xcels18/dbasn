<?php

use Illuminate\Support\Facades\Route;
use App\Core\Application\Pegawai\GetDaftarPegawaiService;
use App\Core\Presentation\Pegawai\PegawaiController;
use App\Core\Presentation\Page\PageController;

use App\Http\Controllers\AuthController;

// Public routes
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function (GetDaftarPegawaiService $service) {
        $pegawaiList = $service->execute();
        return view('dashboard', compact('pegawaiList'));
    })->name('dashboard');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
    Route::post('/pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::post('/pegawai/{id}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/manajemen-jabatan', [PageController::class, 'jabatanFungsional'])->name('manajemen-jabatan');
    Route::post('/manajemen-jabatan', [PageController::class, 'storeFormasi'])->name('manajemen-jabatan.store');
    Route::post('/manajemen-jabatan/update', [PageController::class, 'updateFormasi'])->name('manajemen-jabatan.update');

    Route::get('/laporan', [PageController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export-excel', [PageController::class, 'exportExcelNominatif'])->name('laporan.export');
    Route::get('/pengaturan', [PageController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan/admin', [PageController::class, 'updateAdmin'])->name('pengaturan.admin');
    Route::post('/pengaturan/api-token', [PageController::class, 'generateApiToken'])->name('pengaturan.api.token');
    Route::delete('/pengaturan/api-token/{id}', [PageController::class, 'deleteApiToken'])->name('pengaturan.api.token.delete');

});
