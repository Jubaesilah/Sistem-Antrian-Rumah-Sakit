# Quick Start - Display Antrian (Tanpa Backend)

Panduan cepat untuk menjalankan display antrian **tanpa backend API** terlebih dahulu.

## Mode Development (Dummy Data)

Sistem sudah dikonfigurasi untuk berjalan dengan **dummy data** sehingga Anda bisa melihat tampilan display antrian tanpa perlu backend API yang sudah jadi.

### Langkah Cepat

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Build assets
npm run build
# atau untuk development
npm run dev

# 4. Jalankan server
php artisan serve
```

### Akses Display

Buka browser dan akses:
```
http://localhost:8000/display-antrian
```

**Anda akan melihat:**
- ✅ Display antrian dengan 5 loket
- ✅ Nomor antrian yang berubah otomatis setiap 3 detik (wire:poll)
- ✅ Badge "DEMO MODE" di kanan atas
- ✅ Jam digital yang berjalan
- ✅ Running text di bawah

## Fitur Demo Mode

### 1. Auto Refresh
Data antrian akan otomatis berubah setiap 3 detik menggunakan `wire:poll`.

### 2. Simulasi Data Real-time
Nomor antrian akan berubah-ubah setiap menit untuk simulasi data yang dinamis.

### 3. Visual Indicators
- **DEMO MODE**: Badge kuning menandakan sedang menggunakan dummy data
- **Live**: Indikator hijau berkedip menandakan polling aktif
- **Last Update**: Waktu terakhir data di-refresh

## Konfigurasi

### File `.env`

```env
# Mode dummy data (default: true)
API_USE_DUMMY_DATA=true

# Interval polling dalam detik (default: 3)
API_POLLING_INTERVAL=3
```

### Mengubah Interval Refresh

Edit file `.env`:
```env
# Refresh setiap 2 detik
API_POLLING_INTERVAL=2

# Refresh setiap 5 detik
API_POLLING_INTERVAL=5
```

Atau edit langsung di `config/api.php`:
```php
'polling_interval' => env('API_POLLING_INTERVAL', 3),
```

## Cara Kerja wire:poll

### Di View (Blade)
```blade
<div wire:poll.3s="refreshQueue">
    <!-- Content akan auto-refresh setiap 3 detik -->
</div>
```

### Di Component (PHP)
```php
public function refreshQueue()
{
    $this->loadQueueData(); // Method ini dipanggil otomatis setiap 3 detik
}
```

## Switching ke Mode API (Nanti)

Ketika backend API sudah ready, cukup ubah 1 setting:

### Option 1: Via .env
```env
# Ubah dari true ke false
API_USE_DUMMY_DATA=false

# Set URL backend
API_BASE_URL=http://localhost:8080
```

### Option 2: Via config/api.php
```php
'use_dummy_data' => false,
```

Sistem akan otomatis switch ke mode API dan mulai mengkonsumsi data dari backend.

## Troubleshooting

### Display tidak auto-refresh
**Solusi:**
1. Pastikan Livewire scripts ter-load (cek browser console)
2. Clear cache: `php artisan cache:clear`
3. Rebuild assets: `npm run build`

### Styling tidak muncul
**Solusi:**
```bash
npm run build
# atau
npm run dev
```

### Error "Class not found"
**Solusi:**
```bash
composer dump-autoload
php artisan clear-compiled
php artisan cache:clear
```

## Customisasi Tampilan

### Mengubah Warna
Edit file `resources/views/livewire/display-antrian.blade.php`:

```blade
<!-- Ubah warna header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800">

<!-- Ubah warna nomor antrian -->
<div class="bg-gradient-to-br from-yellow-400 to-yellow-500">
```

### Mengubah Running Text
```blade
<span class="text-lg font-semibold">
    Teks Anda di sini.. Teks Anda di sini..
</span>
```

### Mengubah Logo/Nama RS
```blade
<h1 class="text-2xl font-bold">Nama Rumah Sakit Anda</h1>
<p class="text-sm opacity-90">Tagline Anda</p>
```

## Preview Features

### 1. Real-time Clock
Jam digital update setiap detik tanpa refresh halaman.

### 2. Smooth Transitions
Livewire menggunakan morphing untuk transisi yang smooth saat data berubah.

### 3. Loading States
Visual feedback saat data sedang di-update.

### 4. Responsive Design
Tampilan optimal di berbagai ukuran layar.

## Next Steps

Setelah tampilan sudah sesuai:

1. ✅ **Koordinasi dengan Backend Developer**
   - Berikan file `BACKEND_REQUIREMENTS.md`
   - Pastikan format response API sesuai

2. ✅ **Testing API Integration**
   - Set `API_USE_DUMMY_DATA=false`
   - Set `API_BASE_URL` ke URL backend
   - Test koneksi

3. ✅ **Production Deployment**
   - Build assets: `npm run build`
   - Set environment variables
   - Deploy ke server

## Tips Development

### Hot Reload
Gunakan `npm run dev` untuk auto-reload saat edit file:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

### Debug Mode
Untuk melihat detail error:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Browser DevTools
- **Network Tab**: Monitor Livewire requests
- **Console**: Check JavaScript errors
- **Elements**: Inspect real-time DOM changes

## Support

Jika ada pertanyaan atau issue:
1. Check file `API_INTEGRATION.md` untuk detail integrasi API
2. Check file `BACKEND_REQUIREMENTS.md` untuk requirement backend
3. Check `storage/logs/laravel.log` untuk error logs

---

**Happy Coding! 🚀**

Sistem display antrian siap digunakan untuk preview/demo tanpa perlu backend API terlebih dahulu.
