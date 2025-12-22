<?php

namespace App\Observers;

use App\Models\FotoKamar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FotoKamarObserver
{
    /**
     * Handle the FotoKamar "created" event.
     */
    public function created(FotoKamar $fotoKamar): void
    {
        // Ensure file is in storage and accessible
        $this->ensureFileAccessible($fotoKamar);
    }

    /**
     * Handle the FotoKamar "updated" event.
     */
    public function updated(FotoKamar $fotoKamar): void
    {
        // Ensure file is in storage and accessible
        $this->ensureFileAccessible($fotoKamar);
    }

    /**
     * Handle the FotoKamar "deleted" event.
     */
    public function deleted(FotoKamar $fotoKamar): void
    {
        // Delete file from storage if it exists
        if ($fotoKamar->url && Storage::disk('public')->exists($fotoKamar->url)) {
            Storage::disk('public')->delete($fotoKamar->url);
        }
    }

    /**
     * Ensure file is accessible via public/storage symlink
     */
    private function ensureFileAccessible(FotoKamar $fotoKamar): void
    {
        // Check if file exists in storage/app/public/
        if ($fotoKamar->url && Storage::disk('public')->exists($fotoKamar->url)) {
            // File sudah ada di storage/app/public/
            // Symlink akan otomatis expose ke public/storage/
            // Verify dengan cek physical path
            $physicalPath = storage_path('app/public/' . $fotoKamar->url);
            $publicPath = public_path('storage/' . $fotoKamar->url);

            // Verify symlink working
            if (!file_exists($publicPath)) {
                // If symlink not working, create junction on Windows or symlink on Linux
                $this->createLinkIfNeeded($physicalPath, $publicPath);
            }
        }
    }

    /**
     * Create symlink/junction if needed
     */
    private function createLinkIfNeeded($source, $link): void
    {
        // Skip if link already exists
        if (file_exists($link) || is_link($link)) {
            return;
        }

        // For Windows, use junction
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Create parent directory if needed
            $linkDir = dirname($link);
            if (!is_dir($linkDir)) {
                @mkdir($linkDir, 0755, true);
            }

            // Use Windows mklink command for junction
            $command = 'mklink /J "' . str_replace('/', '\\', $link) . '" "' . str_replace('/', '\\', $source) . '"';
            shell_exec($command);
        } else {
            // For Linux/Mac, use symlink
            @symlink($source, $link);
        }
    }
}
