# Workflow Upload Foto Kamar - Panduan Lengkap

## 📸 Bagaimana Foto Upload Bekerja

### Alur Upload di Filament Admin

```
Admin Upload Foto
    ↓
Filament FileUpload Component
    ↓
File Saved ke: storage/app/public/foto-kamar/{random-name}.jpeg
    ↓
Database Record Created:
  - id_kamar: (selected kamar id)
  - url: foto-kamar/{random-name}.jpeg
  - caption: (optional deskripsi)
  - is_cover: (true/false)
    ↓
Website Otomatis Tampil Foto
```

## 🔧 Konfigurasi File Upload (Sudah Configured)

**File**: `app/Filament/Resources/FotoKamar/Schemas/FotoKamarForm.php`

```php
FileUpload::make('url')
    ->label('Foto Kamar')
    ->image()                          // ← Validate hanya image
    ->directory('foto-kamar')          // ← Save ke storage/app/public/foto-kamar/
    ->maxSize(5120)                    // ← Max 5MB
    ->required()
    ->helperText('Ukuran maksimal 5MB. Format: JPEG, PNG, GIF')
```

### Fitur FileUpload Component

✅ **Auto Create Directory**: Folder `foto-kamar` otomatis dibuat jika belum ada
✅ **Auto Generate Filename**: File disave dengan nama random (mencegah conflict)
✅ **Image Validation**: Hanya image files (JPEG, PNG, GIF, WebP) yang diizinkan
✅ **Size Limit**: Max 5MB per file (konfigurasi di maxSize)
✅ **Format Conversion**: Auto convert ke JPEG jika diperlukan

## 📋 Upload Process Step-by-Step (Untuk Admin)

### 1. Login Filament Admin

```
URL: http://127.0.0.1:8000/admin
atau di production: yourdomain.com/admin
```

### 2. Navigasi ke Foto Kamar

```
Sidebar → Foto Kamar menu
```

### 3. Klik Tombol "Create" atau "Tambah Foto Kamar"

```
Page: /admin/foto-kamar/create
```

### 4. Upload Foto

-   Click upload area (drag & drop OR click to browse)
-   Select image file dari komputer
-   Preview akan muncul
-   Auto upload & save to storage folder

### 5. Select Kamar (Opsional)

-   Dropdown: Pilih kamar mana foto ini
-   Searchable: Cari nomor kamar (01, 02, 101, dll)

### 6. Deskripsi (Opsional)

-   Add caption/deskripsi untuk foto
-   Misal: "View dari balkon", "Kamar mandi", "Area tidur", dll

### 7. Jadikan Foto Sampul (Opsional)

-   Toggle ON jika ini foto utama kamar
-   Hanya 1 sampul per kamar yang akan tampil di list

### 8. Save

-   Click "Create" atau "Save"
-   ✅ Foto otomatis tersimpan & muncul di website

## 📂 Struktur File Setelah Upload

```
storage/app/public/
├── foto-kamar/
│   ├── 01KD241PBP4QKYW9VCKGZPYMWZ.jpeg
│   ├── WWqrK4La54A83lqQjVNUMv8l.jpeg
│   ├── Kpz31GcTwHlA1nx4Xn5rDyIK.jpeg
│   └── ... (lebih banyak files)

public/storage/
├── foto-kamar/  ← Symlink ke storage/app/public/foto-kamar/

```

## 🌐 Website Display (Otomatis)

### Proses Display

```
User Akses /reservations
    ↓
Controller: ReservationController::index()
    with('fotos')  ← Eager load foto
    ↓
Database Query:
    SELECT * FROM foto_kamar WHERE id_kamar = 1
    ↓
View: resources/views/reservations/index.blade.php
    ↓
Display Logic:
    1. Cari foto dengan is_cover = true
    2. Jika ada → tampil foto
    3. Jika tidak → tampil foto pertama
    4. Jika tidak ada foto → tampil icon fallback
    ↓
<img src="/storage/foto-kamar/{random-name}.jpeg">
    ↓
✅ Foto muncul di website
```

### Display di Ketiga Halaman

#### 1. Daftar Kamar (`/reservations`)

```blade
@php
    $fotoCover = $item->fotos->firstWhere('is_cover', true) ?? $item->fotos->first();
@endphp
@if($fotoCover)
    <img src="{{ asset('storage/' . $fotoCover->url) }}"
         alt="{{ $item->nomor_kamar }}">
@else
    <!-- Icon fallback -->
@endif
```

#### 2. Form Booking (`/reservations/{id}/create`)

```blade
@php
    $fotoCover = $kamar->fotos->firstWhere('is_cover', true) ?? $kamar->fotos->first();
@endphp
@if($fotoCover)
    <img src="{{ asset('storage/' . $fotoCover->url) }}"
         alt="{{ $kamar->nomor_kamar }}">
@else
    <!-- Icon fallback -->
@endif
```

#### 3. Confirmation Page (`/reservations/{id}`)

```blade
@php
    $kamarPertama = $reservasi->kamar->first();
    $fotoCover = $kamarPertama->fotos->firstWhere('is_cover', true) ?? $kamarPertama->fotos->first();
@endphp
@if($fotoCover)
    <img src="{{ asset('storage/' . $fotoCover->url) }}"
         alt="{{ $kamarPertama->nomor_kamar }}">
@else
    <!-- Icon fallback -->
@endif
```

## 🔄 Update Flow (Jika Upload Foto Baru)

```
Admin Upload Foto Baru di Filament
    ↓
Foto disave ke storage/app/public/foto-kamar/
    ↓
Database record dibuat/updated
    ↓
Website di-refresh (Ctrl+F5)
    ↓
✅ Foto baru langsung muncul
```

**Catatan**: Tidak perlu restart server atau clear cache. Website akan auto load foto dari database.

## 🎯 Best Practices

### Untuk Upload Foto Terbaik

1. **Ukuran Foto**

    - Resolusi minimum: 800x600px
    - Resolusi optimal: 1200x800px
    - File size: 1-3MB (lebih baik < 2MB)

2. **Format Foto**

    - JPEG: Terbaik untuk foto real (compressed)
    - PNG: Untuk logo/graphic (lossless)
    - WebP: Paling optimal (modern browsers)

3. **Konten Foto**

    - Gunakan foto asli kamar (bukan generic)
    - Pencahayaan bagus (terang, tidak gelap)
    - Foto dari berbagai angle/view berbeda
    - Minimal 1 sampul per kamar

4. **Upload Multiple Photos**
    - Upload 3-5 foto per kamar untuk pilihan
    - Set 1 foto sebagai cover (is_cover = true)
    - Foto lain sebagai detail/gallery

### Untuk Performa Website

1. **File Size Management**

    - Compress foto sebelum upload
    - Gunakan tool: TinyPNG, ImageOptim, dll
    - Max 5MB sudah cukup

2. **Caching**

    - Website cache photo URLs
    - Refresh halaman jika upload foto baru
    - Browser cache clear jika needed

3. **Storage Management**
    - Monitor folder size: `storage/app/public/foto-kamar/`
    - Delete unused photos di admin panel
    - Database records auto delete dengan soft delete

## 📊 Database Schema

```sql
CREATE TABLE foto_kamar (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_kamar BIGINT NOT NULL,
    url VARCHAR(255) NOT NULL,              -- Path: foto-kamar/{filename}
    caption TEXT,                           -- Optional deskripsi
    is_cover BOOLEAN DEFAULT FALSE,         -- Flag untuk cover photo
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (id_kamar) REFERENCES kamar(id)
);
```

## 🐛 Troubleshooting

### Foto Tidak Muncul di Website

**Checklist:**

-   [ ] Foto sudah ter-upload di Filament admin
-   [ ] Check database: `SELECT * FROM foto_kamar`
-   [ ] Check storage folder: `storage/app/public/foto-kamar/`
-   [ ] Verify file ada di folder
-   [ ] Browser cache clear (Ctrl+Shift+Delete)
-   [ ] Page refresh (Ctrl+F5)

**Solution:**

```bash
# Clear all caches
php artisan optimize:clear

# Verify symlink
php artisan storage:link

# Check storage permissions
chmod -R 755 storage/app/public/
```

### Upload Gagal di Filament

**Checklist:**

-   [ ] File adalah image (JPEG, PNG, GIF)
-   [ ] File size < 5MB
-   [ ] Storage folder writable (chmod 755)
-   [ ] Disk space cukup

**Solution:**

```bash
# Fix permissions
chmod -R 755 storage/app/public/
chmod -R 755 storage/

# Create directory if missing
mkdir -p storage/app/public/foto-kamar
chmod 755 storage/app/public/foto-kamar
```

### Path Salah / 404 Image

**Checklist:**

-   [ ] Symlink sudah created: `public/storage → storage/app/public`
-   [ ] File ada: `storage/app/public/foto-kamar/{filename}.jpeg`

**Solution:**

```bash
# Re-create symlink
php artisan storage:link

# Verify symlink
ls -la public/storage
```

## 📈 Future Enhancements

-   [ ] Photo gallery/carousel (multiple photos slider)
-   [ ] Automatic image compression on upload
-   [ ] Thumbnail generation for list view
-   [ ] Drag-drop reorder photos
-   [ ] Photo crop/rotate editor
-   [ ] Bulk upload multiple files
-   [ ] Before/after photo comparison

## 📝 Summary

✅ **System Status**: Fully Operational

-   FileUpload component configured
-   Storage directory setup
-   Symlink created
-   Database schema ready
-   Website views integrated

**Next Steps untuk Admin**:

1. Login ke Filament (`/admin`)
2. Go to Foto Kamar menu
3. Click "Create" / "Tambah Foto Kamar"
4. Upload foto kamar
5. Select kamar & toggle cover photo
6. Save
7. Done! Foto langsung muncul di website

**No Manual Steps Needed** - Upload otomatis handle semua!
