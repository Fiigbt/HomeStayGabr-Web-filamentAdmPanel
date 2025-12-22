<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Reservasi;
use App\Models\FotoKamar;
use App\Observers\ReservasiObserver;
use App\Observers\FotoKamarObserver;

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
         Reservasi::observe(ReservasiObserver::class);
         FotoKamar::observe(FotoKamarObserver::class);

         // Ensure foto-kamar directory exists in public storage
         $this->ensurePhotoDirectoriesExist();
    }

    /**
     * Ensure photo directories exist and are accessible
     */
    private function ensurePhotoDirectoriesExist(): void
    {
        // Create storage/app/public/foto-kamar directory
        $storagePath = storage_path('app/public/foto-kamar');
        if (!is_dir($storagePath)) {
            @mkdir($storagePath, 0755, true);
        }

        // Create public/storage/foto-kamar directory or symlink
        $publicPath = public_path('storage/foto-kamar');
        if (!is_dir($publicPath) && !is_link($publicPath)) {
            @mkdir($publicPath, 0755, true);
        }

        // Set proper permissions
        @chmod($storagePath, 0755);
        if (is_dir($publicPath)) {
            @chmod($publicPath, 0755);
        }
    }

    
}
