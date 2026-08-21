<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Domain\Pegawai\PegawaiRepositoryInterface;
use App\Core\Infrastructure\Pegawai\EloquentPegawaiRepository;
use App\Core\Domain\Formasi\FormasiRepositoryInterface;
use App\Core\Infrastructure\Formasi\EloquentFormasiRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PegawaiRepositoryInterface::class, EloquentPegawaiRepository::class);
        $this->app->bind(FormasiRepositoryInterface::class, EloquentFormasiRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
