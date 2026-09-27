<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\AdminBlk;
use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\DaftarLowongan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\Sertifikat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Daftarkan component pagination custom sebagai default
        Paginator::defaultView('components.pagination');

        // 2. Kirim data count dinamis ke seluruh view layout / sidebar
        View::composer('*', function ($view) {
            $view->with([
                'countAdminBlk'     => AdminBlk::count(),
                'countDaftarPelatihan' => DaftarPelatihan::count(),
                'countJadwalPelatihan'    => JadwalPelatihan::count(),
                'countDaftarLowongan'  => DaftarLowongan::count(),
                'countMitra'     => Mitra::count(),
                'countPeserta'   => Peserta::count(),
                'countSertifikat'=> Sertifikat::count(),
            ]);
        });
    }
}