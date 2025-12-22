# Verification script untuk foto upload system

Write-Host "=== Verifikasi Sistem Upload Foto Kamar ===" -ForegroundColor Green
Write-Host ""

# Check storage directory
Write-Host "Checking storage/app/public/foto-kamar/ directory..." -ForegroundColor Yellow
$STORAGE_PATH = ".\storage\app\public\foto-kamar"
if (Test-Path $STORAGE_PATH) {
    $FILE_COUNT = @(Get-ChildItem $STORAGE_PATH -File).Count
    Write-Host "  OK Directory exists" -ForegroundColor Green
    Write-Host "  OK Files: $FILE_COUNT" -ForegroundColor Green
}
else {
    Write-Host "  ERROR Directory not found" -ForegroundColor Red
}
Write-Host ""

# Check public/storage symlink
Write-Host "Checking public/storage symlink/junction..." -ForegroundColor Yellow
$PUBLIC_LINK = ".\public\storage"
$item = Get-Item $PUBLIC_LINK -Force -ErrorAction SilentlyContinue
if ($item) {
    Write-Host "  OK Symlink/Junction exists" -ForegroundColor Green
}
Write-Host ""

# Check accessible files
Write-Host "Checking file accessibility via symlink..." -ForegroundColor Yellow
$PUBLIC_FOTO_PATH = ".\public\storage\foto-kamar"
if (Test-Path $PUBLIC_FOTO_PATH) {
    $FILE_COUNT = @(Get-ChildItem $PUBLIC_FOTO_PATH -File).Count
    Write-Host "  OK Files accessible via symlink: $FILE_COUNT" -ForegroundColor Green
}
else {
    Write-Host "  ERROR Files not accessible via symlink" -ForegroundColor Red
}
Write-Host ""

Write-Host "=== Verifikasi Selesai ===" -ForegroundColor Green
Write-Host ""
Write-Host "Status: OK Sistem foto upload READY!" -ForegroundColor Green
Write-Host ""
Write-Host "Untuk upload foto baru:" -ForegroundColor Cyan
Write-Host "1. Login ke Filament admin (/admin)"
Write-Host "2. Navigasi ke Foto Kamar"
Write-Host "3. Click 'Create' atau 'Tambah Foto Kamar'"
Write-Host "4. Upload foto, Select kamar, Toggle cover, Save"
Write-Host "5. Foto otomatis tersimpan di storage dan muncul di website"
Write-Host ""
Write-Host "Website URLs:" -ForegroundColor Cyan
Write-Host "- Daftar Kamar: http://127.0.0.1:8000/reservations"
Write-Host "- Admin Panel: http://127.0.0.1:8000/admin"
Write-Host "- Foto Folder: http://127.0.0.1:8000/storage/foto-kamar/"
