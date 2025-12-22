<?php

namespace App\Console\Commands;

use App\Models\FotoKamar;
use App\Models\Kamar;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetupSamplePhotos extends Command
{
    protected $signature = 'app:setup-sample-photos';
    protected $description = 'Create sample photos for all kamar';

    public function handle()
    {
        $this->info('Setting up sample photos for kamar...');
        $this->newLine();

        // Ensure directory exists
        if (!is_dir(storage_path('app/public/foto-kamar'))) {
            mkdir(storage_path('app/public/foto-kamar'), 0755, true);
        }

        $kamarList = Kamar::all();
        $colors = [
            [100, 150, 255],  // Blue
            [100, 200, 150],  // Green
            [255, 180, 100],  // Orange
            [180, 150, 220],  // Purple
            [200, 180, 150],  // Beige
        ];

        foreach ($kamarList as $kamar) {
            $existingCover = FotoKamar::where('id_kamar', $kamar->id)
                                      ->where('is_cover', true)
                                      ->first();

            if (!$existingCover) {
                $filename = Str::random(24) . '.jpeg';
                $storagePath = storage_path('app/public/foto-kamar/' . $filename);

                $color = $colors[$kamar->id % count($colors)];

                // Create image using GD library
                $image = imagecreatetruecolor(800, 600);
                $bgColor = imagecolorallocate($image, $color[0], $color[1], $color[2]);
                imagefill($image, 0, 0, $bgColor);

                // Add text
                $textColor = imagecolorallocate($image, 255, 255, 255);
                $fontSize = 5;
                $text = 'Kamar ' . $kamar->nomor_kamar;
                $textX = 50;
                $textY = 280;
                imagestring($image, $fontSize, $textX, $textY, $text, $textColor);

                // Save image
                imagejpeg($image, $storagePath, 90);
                imagedestroy($image);

                // Create database record
                FotoKamar::create([
                    'id_kamar' => $kamar->id,
                    'url' => 'foto-kamar/' . $filename,
                    'caption' => 'Foto Kamar ' . $kamar->nomor_kamar,
                    'is_cover' => true,
                ]);

                $this->info("✓ Created sample photo for Kamar {$kamar->nomor_kamar}");
                $this->line("  File: storage/app/public/foto-kamar/{$filename}");
            } else {
                $this->comment("✓ Kamar {$kamar->nomor_kamar} already has a cover photo");
            }
        }

        $this->newLine();
        $this->info('Done! All sample photos have been created.');
        $this->line('Visit http://127.0.0.1:8000/reservations to see the photos.');
    }
}
