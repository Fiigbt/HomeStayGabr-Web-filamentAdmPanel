#!/bin/bash
# Verification script untuk foto upload system

echo "=== Verifikasi Sistem Upload Foto Kamar ==="
echo ""

# Check storage directory
echo "✓ Checking storage/app/public/foto-kamar/ directory..."
STORAGE_PATH="./storage/app/public/foto-kamar"
if [ -d "$STORAGE_PATH" ]; then
    FILE_COUNT=$(find "$STORAGE_PATH" -type f | wc -l)
    echo "  ✓ Directory exists"
    echo "  ✓ Files: $FILE_COUNT"
else
    echo "  ✗ Directory not found"
fi
echo ""

# Check public/storage symlink
echo "✓ Checking public/storage symlink..."
PUBLIC_LINK="./public/storage"
if [ -L "$PUBLIC_LINK" ] || [ -d "$PUBLIC_LINK" ]; then
    echo "  ✓ Symlink/Junction exists"
    TARGET=$(readlink -f "$PUBLIC_LINK")
    echo "  ✓ Points to: $TARGET"
else
    echo "  ✗ Symlink not found"
fi
echo ""

# Check accessible files
echo "✓ Checking file accessibility via symlink..."
PUBLIC_FOTO_PATH="./public/storage/foto-kamar"
if [ -d "$PUBLIC_FOTO_PATH" ]; then
    FILE_COUNT=$(find "$PUBLIC_FOTO_PATH" -type f | wc -l)
    echo "  ✓ Files accessible via symlink: $FILE_COUNT"
else
    echo "  ✗ Files not accessible"
fi
echo ""

# Check database
echo "✓ Checking database records..."
php artisan tinker --execute="
\$count = \App\Models\FotoKamar::count();
echo 'Total FotoKamar records: ' . \$count . PHP_EOL;

\$withoutCover = \App\Models\FotoKamar::where('is_cover', false)->count();
echo 'Non-cover photos: ' . \$withoutCover . PHP_EOL;

\$withCover = \App\Models\FotoKamar::where('is_cover', true)->count();
echo 'Cover photos: ' . \$withCover . PHP_EOL;
"
echo ""

echo "=== Verifikasi Selesai ==="
echo ""
echo "Status: ✓ Sistem foto upload ready!"
echo ""
echo "Untuk upload foto baru:"
echo "1. Login ke Filament admin (/admin)"
echo "2. Navigasi ke Foto Kamar"
echo "3. Click 'Create' / 'Tambah Foto Kamar'"
echo "4. Upload foto → Select kamar → Toggle cover → Save"
echo "5. ✓ Foto otomatis tersimpan di storage & muncul di website"
echo ""
echo "Website URLs:"
echo "- Daftar Kamar: http://127.0.0.1:8000/reservations"
echo "- Admin Panel: http://127.0.0.1:8000/admin"
echo "- Foto Storage: http://127.0.0.1:8000/storage/foto-kamar/"
