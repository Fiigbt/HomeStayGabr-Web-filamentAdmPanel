# Sistem Foto Kamar - Dokumentasi Lengkap

## Overview

Sistem foto kamar yang terintegrasi penuh antara:

-   **Admin Panel** (Filament) - Upload dan manage foto kamar
-   **Customer Website** - Display foto kamar pada halaman reservasi

## Arsitektur Sistem

### 1. Database Schema

**Tabel: `foto_kamar`**

```
id              (BigInt PK)
id_kamar        (BigInt FK → kamar.id)
url             (String) - Path relatif foto di storage
caption         (Text) - Deskripsi/caption foto (opsional)
is_cover        (Boolean) - Flag untuk menandai sampul utama
timestamps      (created_at, updated_at)
```

### 2. Models & Relationships

#### Kamar Model (`app/Models/Kamar.php`)

```php
// Relasi: Satu kamar banyak foto
public function fotos()
{
    return $this->hasMany(FotoKamar::class, 'id_kamar');
}

// Relasi: Satu kamar satu foto sampul
public function fotoCover()
{
    return $this->hasOne(FotoKamar::class, 'id_kamar')
                ->where('is_cover', true);
}
```

#### FotoKamar Model (`app/Models/FotoKamar.php`)

```php
protected $fillable = ['id_kamar', 'url', 'caption', 'is_cover'];

public function kamar()
{
    return $this->belongsTo(Kamar::class, 'id_kamar');
}
```

### 3. Admin Panel Setup (Filament)

**Location**: `app/Filament/Resources/FotoKamar/`

#### File Upload Configuration

-   **Directory**: `foto-kamar` (auto-created in storage/app/public)
-   **Max Size**: 5MB
-   **Allowed Types**: JPEG, PNG, GIF (image validation)
-   **Storage Path**: `storage/app/public/foto-kamar/`

#### Features

✅ Upload foto kamar dengan preview
✅ Select kamar yang terkait dengan dropdown
✅ Add caption/deskripsi untuk foto
✅ Toggle "Jadikan Foto Sampul" untuk set cover photo
✅ List view untuk manage semua foto

### 4. Controller Implementation

**Location**: `app/Http/Controllers/ReservationController.php`

#### Eager Loading Pattern

```php
// Index - Tampilkan daftar kamar dengan foto
public function index()
{
    $kamar = Kamar::with('fotos')  // ← Eager load fotos
                  ->where('status_kamar', 'tersedia')
                  ->get();
}

// Create - Tampilkan form booking dengan foto kamar dipilih
public function create($id)
{
    $kamar = Kamar::with('fotos')  // ← Eager load fotos
                  ->findOrFail($id);
}
```

**Benefit**: Mencegah N+1 query problem, semua foto ter-load dalam 1 query saja.

### 5. View Implementation

#### index.blade.php (Room Listing)

```blade
@php
    $fotoCover = $item->fotos->firstWhere('is_cover', true) ?? $item->fotos->first();
@endphp

<div class="h-56 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl overflow-hidden">
    @if($fotoCover)
        <img src="{{ asset('storage/' . $fotoCover->url) }}"
             alt="{{ $item->nomor_kamar }}"
             class="w-full h-full object-cover">
    @else
        <!-- Fallback gradient dengan icon -->
    @endif
</div>
```

#### create.blade.php (Booking Form)

```blade
@php
    $fotoCover = $kamar->fotos->firstWhere('is_cover', true) ?? $kamar->fotos->first();
@endphp

<div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg overflow-hidden">
    @if($fotoCover)
        <img src="{{ asset('storage/' . $fotoCover->url) }}"
             alt="{{ $kamar->nomor_kamar }}"
             class="w-full h-full object-cover">
    @else
        <!-- Fallback icon -->
    @endif
</div>
```

#### confirmation.blade.php (Booking Confirmation)

```blade
@php
    $kamarPertama = $reservasi->kamar->first();
    $fotoCover = $kamarPertama->fotos->firstWhere('is_cover', true)
              ?? $kamarPertama->fotos->first();
@endphp

<div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg overflow-hidden">
    @if($fotoCover)
        <img src="{{ asset('storage/' . $fotoCover->url) }}"
             alt="{{ $kamarPertama->nomor_kamar }}"
             class="w-full h-full object-cover">
    @else
        <!-- Fallback icon -->
    @endif
</div>
```

### 6. Storage Configuration

**File**: `config/filesystems.php`

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',  // URL untuk assets
    'visibility' => 'public',
],
```

**Symlink Status**: ✅ LINKED

```
public/storage → storage/app/public
```

## Workflow Lengkap

### Untuk Admin (Upload Foto)

1. Login ke Filament admin panel
2. Navigasi ke **Foto Kamar** menu
3. Click **Create** / **Tambah Foto Kamar**
4. **Upload Foto**: Click upload area, pilih image file
5. **Pilih Kamar**: Select dari dropdown kamar mana
6. **Deskripsi** (opsional): Tambahkan caption/deskripsi
7. **Jadikan Sampul**: Toggle ON jika ini foto utama kamar
8. Click **Save**
9. ✅ Foto akan langsung muncul di website

### Untuk Customer (Lihat Foto)

1. Buka website booking → halaman **Daftar Kamar**
2. Semua kamar menampilkan foto yang di-upload admin
3. Click kamar → masuk form booking → lihat foto di sidebar
4. Selesai booking → confirmation page juga tampil foto

## File Structure

```
app/
├── Models/
│   ├── Kamar.php              (Relasi fotos & fotoCover)
│   └── FotoKamar.php          (Model dengan fillable fields)
├── Http/Controllers/
│   └── ReservationController.php    (with('fotos') eager load)
└── Filament/Resources/
    └── FotoKamar/
        ├── FotoKamarResource.php    (Admin resource)
        └── Schemas/
            └── FotoKamarForm.php    (Upload form config)

resources/views/reservations/
├── index.blade.php            (Room list with fotos)
├── create.blade.php           (Form with foto sidebar)
└── confirmation.blade.php     (Confirmation with foto)

config/
└── filesystems.php            (Disk configuration)

public/storage/               (Symlinked to storage/app/public)

storage/app/public/
└── foto-kamar/               (Foto directory, auto-created)
```

## Fitur & Best Practices

### ✅ Implemented Features

-   Automatic directory creation pada first upload
-   Fallback ke foto lain jika cover tidak ada
-   Fallback ke gradient icon jika tidak ada foto
-   Image optimization dengan `object-cover` (crop, no distort)
-   Responsive design (responsive images)
-   Admin dapat manage foto (create, edit, delete)

### 🔄 Display Logic

**Priority Urutan Foto:**

1. Gunakan foto yang di-mark `is_cover = true`
2. Jika tidak ada cover, gunakan foto pertama (oldest)
3. Jika tidak ada foto sama sekali, tampilkan gradient + icon

### 💡 Tips Penggunaan

1. **Set Cover Photo**: Setiap kamar minimal harus punya 1 cover photo
2. **Multiple Photos**: Bisa upload banyak foto, tapi hanya 1 yang menjadi cover
3. **File Size**: Max 5MB per foto, pastikan compressed/optimized
4. **Caption**: Gunakan untuk deskripsi detail (view, facilities, dll)

## URLs Penting

-   **Website Room List**: `/reservations` (display fotos)
-   **Website Booking Form**: `/reservations/{id}/create` (display foto)
-   **Website Confirmation**: `/reservations/{id}` (display foto)
-   **Admin Panel**: `/admin` (manage fotos)
-   **FotoKamar Admin**: `/admin/foto-kamar` (upload foto)

## Cache Management

Setelah upload foto di admin:

-   Website automatically menampilkan foto terbaru
-   Tidak perlu clear cache (foto di-fetch dari DB)
-   Blade views di-cache, tapi foto data di-load fresh setiap request

## Troubleshooting

### Foto Tidak Tampil di Website

**Check:**

1. ✅ Foto sudah ter-upload di admin (lihat di database)
2. ✅ File ada di folder `storage/app/public/foto-kamar/`
3. ✅ Symlink sudah created: `php artisan storage:link`
4. ✅ Browser cache cleared (Ctrl+Shift+Delete)

### Upload Gagal di Admin

**Check:**

1. ✅ File size < 5MB
2. ✅ Format file adalah image (JPEG, PNG, GIF)
3. ✅ Permissions: `storage/app/public/` writable
4. ✅ Disk space cukup

### Path Salah

**Solution**: Gunakan `asset('storage/' . $foto->url)` - path auto correct

## Future Enhancements

-   [ ] Photo gallery/carousel (multiple photos slider)
-   [ ] Photo ordering (drag-drop to reorder)
-   [ ] Compressed thumbnails generation
-   [ ] Photo edit capability (crop, rotate)
-   [ ] Bulk upload multiple photos
-   [ ] Photo delete soft-delete dengan restore

## Summary

✅ **Photo system fully integrated:**

-   Model relationships: DONE
-   Admin upload interface: DONE
-   Storage configuration: DONE
-   Symlink setup: DONE
-   Website display (all 3 pages): DONE
-   Fallback handling: DONE

**Status**: 🟢 READY FOR PRODUCTION

Admin dapat upload foto di Filament → Website auto menampilkan foto instantly!
