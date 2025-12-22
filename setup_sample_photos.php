<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\FotoKamar;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Generate sample photos untuk kamar yang ada
$kamarList = Kamar::all();

echo "Setting up sample photos for " . count($kamarList) . " kamar...\n\n";

foreach ($kamarList as $kamar) {
    // Check if kamar already has a cover photo
    $existingCover = FotoKamar::where('id_kamar', $kamar->id)
                              ->where('is_cover', true)
                              ->first();
    
    if (!$existingCover) {
        // Generate unique filename
        $filename = Str::random(24) . '.jpeg';
        $storagePath = storage_path('app/public/foto-kamar/' . $filename);
        
        // Create a simple placeholder image (200x200 colored rectangle)
        $colors = [
            [100, 150, 255],  // Blue
            [100, 200, 150],  // Green
            [255, 180, 100],  // Orange
            [180, 150, 220],  // Purple
            [200, 180, 150],  // Beige
        ];
        
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
        
        echo "✓ Created sample photo for Kamar {$kamar->nomor_kamar}\n";
        echo "  File: storage/app/public/foto-kamar/{$filename}\n";
        echo "  URL: /storage/foto-kamar/{$filename}\n\n";
    } else {
        echo "✓ Kamar {$kamar->nomor_kamar} already has a cover photo\n\n";
    }
}

echo "Done! All sample photos have been created.\n";
echo "Visit http://127.0.0.1:8000/reservations to see the photos.\n";
