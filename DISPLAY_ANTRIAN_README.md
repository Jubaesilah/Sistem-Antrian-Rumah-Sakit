# Sistem Display Antrian Rumah Sakit

Sistem display antrian rumah sakit yang dibangun menggunakan Laravel 12 dan Livewire 3.6.

## Arsitektur

Frontend Livewire mengkonsumsi data dari **Backend API** (terpisah) melalui HTTP/JSON.

```
Frontend (Livewire) ◄──── HTTP/JSON ────► Backend API
```

## Fitur

- **Display Real-time**: Menampilkan nomor antrian yang sedang dipanggil secara real-time
- **Auto Refresh**: Otomatis refresh setiap 3 detik menggunakan Livewire polling
- **Multi Loket**: Mendukung 5 loket pelayanan
- **Running Text**: Teks berjalan di bagian bawah untuk informasi tambahan
- **Responsive Design**: Tampilan yang responsif dengan Tailwind CSS
- **Live Clock**: Jam digital yang update setiap detik
- **API Integration**: Konsumsi data dari backend API eksternal
- **Fallback Data**: Tetap berfungsi meskipun API error
- **Caching**: Cache data untuk performa optimal

## Instalasi

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi API Backend

Edit file `.env` dan tambahkan konfigurasi API backend:

```env
# API Backend Configuration
API_BASE_URL=http://localhost:8080
API_TIMEOUT=5
API_AUTH_TYPE=bearer
API_AUTH_TOKEN=your_token_here
API_KEY=
```

**Catatan:** Sesuaikan `API_BASE_URL` dengan URL backend API yang dibuat oleh backend developer.

### 4. Konfigurasi Database (Optional)

Jika ingin menggunakan database lokal sebagai fallback:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=antrian_rumah_sakit
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migration dan Seeder

```bash
php artisan migrate
php artisan db:seed --class=AntrianSeeder
```

### 5. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 6. Jalankan Server

```bash
php artisan serve
```

## Akses Aplikasi

Buka browser dan akses:
- **Display Antrian**: http://localhost:8000/display-antrian

## Struktur Database

### Tabel: `antrian`

| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| id | bigint | Primary key |
| nomor_antrian | string(10) | Nomor antrian (contoh: A 145) |
| loket_id | integer | ID loket (1-5) |
| status | enum | Status: menunggu, dipanggil, selesai |
| nama_pasien | string | Nama pasien (nullable) |
| jenis_layanan | string | Jenis layanan (nullable) |
| waktu_panggil | timestamp | Waktu antrian dipanggil (nullable) |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

## Komponen Livewire

### DisplayAntrian Component

**Path**: `app/Livewire/DisplayAntrian.php`

**Properties**:
- `$currentQueue`: Antrian yang sedang aktif
- `$loket1` - `$loket5`: Nomor antrian untuk setiap loket
- `$currentTime`: Waktu saat ini
- `$currentDate`: Tanggal saat ini

**Methods**:
- `mount()`: Inisialisasi data saat komponen dimuat
- `loadQueueData()`: Memuat data antrian dari database
- `refreshQueue()`: Refresh data antrian (dipanggil otomatis setiap 3 detik)

## Customisasi

### Mengubah Interval Refresh

Edit file `resources/views/livewire/display-antrian.blade.php`:

```blade
<!-- Ubah dari 3s ke interval yang diinginkan -->
<div wire:poll.3s="refreshQueue">
```

### Mengubah Running Text

Edit file `resources/views/livewire/display-antrian.blade.php` pada bagian footer:

```blade
<span class="text-lg font-semibold">
    Teks running Anda di sini..
</span>
```

### Mengubah Gambar Background

Edit file `resources/views/livewire/display-antrian.blade.php`:

```blade
<img src="URL_GAMBAR_ANDA" alt="Scenic View" class="w-full h-full object-cover">
```

## API/Method untuk Update Antrian

Untuk mengupdate antrian dari sistem lain, Anda bisa menggunakan:

```php
use App\Models\Antrian;

// Panggil antrian baru
Antrian::create([
    'nomor_antrian' => 'A 147',
    'loket_id' => 1,
    'status' => 'dipanggil',
    'nama_pasien' => 'Nama Pasien',
    'jenis_layanan' => 'Pendaftaran',
    'waktu_panggil' => now(),
]);

// Update status antrian
$antrian = Antrian::where('nomor_antrian', 'A 145')->first();
$antrian->update(['status' => 'selesai']);
```

## Troubleshooting

### Display tidak auto-refresh
- Pastikan Livewire scripts sudah ter-load dengan benar
- Cek console browser untuk error JavaScript
- Pastikan `wire:poll.3s` ada di element root

### Gambar tidak muncul
- Pastikan URL gambar valid dan accessible
- Atau gunakan gambar lokal di folder `public/images`

### Styling tidak muncul
- Jalankan `npm run build` atau `npm run dev`
- Pastikan Tailwind CSS sudah terkonfigurasi dengan benar

## Teknologi yang Digunakan

- **Laravel 12**: PHP Framework
- **Livewire 3.6**: Full-stack framework untuk Laravel
- **Tailwind CSS**: Utility-first CSS framework
- **MySQL**: Database

## Lisensi

MIT License
