<?php
// Create a simple JPEG image for testing
$width = 400;
$height = 300;

// Create image resource
$image = imagecreatetruecolor($width, $height);

// Create colors
$bgColor = imagecolorallocate($image, 52, 152, 219); // Blue
$textColor = imagecolorallocate($image, 255, 255, 255); // White

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

// Add text
$text = "Kamar Kami";
$fontSize = 5;
$textWidth = imagefontwidth($fontSize) * strlen($text);
$textHeight = imagefontheight($fontSize);
$x = ($width - $textWidth) / 2;
$y = ($height - $textHeight) / 2;
imagestring($image, $fontSize, $x, $y, $text, $textColor);

// Save JPEG
$filepath = __DIR__ . '/storage/app/public/foto-kamar/01KD241PBP4QKYW9VCKGZPYMWZ.jpeg';
imagejpeg($image, $filepath, 85);
imagedestroy($image);

echo "File created: " . $filepath . "\n";
echo "File size: " . filesize($filepath) . " bytes\n";
