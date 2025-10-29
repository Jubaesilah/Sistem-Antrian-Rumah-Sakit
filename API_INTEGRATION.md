# API Integration Guide - Sistem Display Antrian

Dokumentasi untuk integrasi frontend Livewire dengan backend API.

## Arsitektur

```
┌─────────────────┐         HTTP/JSON          ┌─────────────────┐
│   Frontend      │ ◄────────────────────────► │   Backend API   │
│   (Livewire)    │                             │   (Your API)    │
└─────────────────┘                             └─────────────────┘
```

Frontend Livewire akan mengkonsumsi data dari backend API yang dibuat oleh teman Anda.

## Konfigurasi

### 1. Setup Environment Variables

Edit file `.env` dan tambahkan konfigurasi API:

```env
# API Backend Configuration
API_BASE_URL=http://localhost:8080
API_TIMEOUT=5
API_AUTH_TYPE=bearer
API_AUTH_TOKEN=your_token_here
API_KEY=your_api_key_here
```

**Parameter:**
- `API_BASE_URL`: URL base dari backend API
- `API_TIMEOUT`: Timeout request dalam detik (default: 5)
- `API_AUTH_TYPE`: Tipe autentikasi (`bearer`, `basic`, `api_key`)
- `API_AUTH_TOKEN`: Token untuk Bearer authentication
- `API_KEY`: API Key jika menggunakan API Key authentication

### 2. Konfigurasi Endpoint

Edit file `config/api.php` untuk menyesuaikan endpoint:

```php
'endpoints' => [
    'display' => '/api/antrian/display',  // Endpoint untuk display semua loket
    'loket' => '/api/antrian/loket',      // Endpoint untuk data per loket
    'current' => '/api/antrian/current',  // Endpoint untuk antrian aktif
],
```

## Format Response API yang Diharapkan

### Endpoint: GET `/api/antrian/display`

**Response Success:**

```json
{
  "success": true,
  "data": {
    "loket1": "A 145",
    "loket2": "A 146",
    "loket3": "A 144",
    "loket4": "B 143",
    "loket5": "B 098",
    "current_queue": {
      "nomor_antrian": "A 145",
      "loket_id": 1,
      "nama_pasien": "John Doe",
      "jenis_layanan": "Pendaftaran"
    }
  }
}
```

**Response Error:**

```json
{
  "success": false,
  "message": "Error message here",
  "data": null
}
```

### Endpoint: GET `/api/antrian/loket/{id}`

**Response Success:**

```json
{
  "success": true,
  "data": {
    "loket_id": 1,
    "nomor_antrian": "A 145",
    "status": "dipanggil",
    "nama_pasien": "John Doe",
    "jenis_layanan": "Pendaftaran",
    "waktu_panggil": "2024-01-01 10:30:00"
  }
}
```

### Endpoint: GET `/api/antrian/current`

**Response Success:**

```json
{
  "success": true,
  "data": {
    "nomor_antrian": "A 145",
    "loket_id": 1,
    "status": "dipanggil",
    "nama_pasien": "John Doe",
    "jenis_layanan": "Pendaftaran",
    "waktu_panggil": "2024-01-01 10:30:00"
  }
}
```

## Contoh Backend API (untuk teman Anda)

Berikut contoh implementasi endpoint di backend (bisa menggunakan Express.js, Laravel, dll):

### Contoh dengan Express.js

```javascript
// routes/antrian.js
const express = require('express');
const router = express.Router();

// GET /api/antrian/display
router.get('/display', async (req, res) => {
  try {
    // Ambil data dari database
    const antrian = await getAntrianFromDatabase();
    
    res.json({
      success: true,
      data: {
        loket1: antrian.loket1?.nomor_antrian || 'A 145',
        loket2: antrian.loket2?.nomor_antrian || 'A 146',
        loket3: antrian.loket3?.nomor_antrian || 'A 144',
        loket4: antrian.loket4?.nomor_antrian || 'B 143',
        loket5: antrian.loket5?.nomor_antrian || 'B 098',
        current_queue: antrian.current
      }
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: error.message,
      data: null
    });
  }
});

// GET /api/antrian/loket/:id
router.get('/loket/:id', async (req, res) => {
  try {
    const loketId = req.params.id;
    const antrian = await getAntrianByLoket(loketId);
    
    res.json({
      success: true,
      data: antrian
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: error.message,
      data: null
    });
  }
});

module.exports = router;
```

### Contoh dengan Laravel

```php
// routes/api.php
Route::prefix('antrian')->group(function () {
    Route::get('/display', [AntrianController::class, 'display']);
    Route::get('/loket/{id}', [AntrianController::class, 'loket']);
    Route::get('/current', [AntrianController::class, 'current']);
});

// app/Http/Controllers/AntrianController.php
class AntrianController extends Controller
{
    public function display()
    {
        $antrian = Antrian::where('status', 'dipanggil')
            ->get()
            ->groupBy('loket_id');

        return response()->json([
            'success' => true,
            'data' => [
                'loket1' => $antrian->get(1)?->first()?->nomor_antrian ?? 'A 145',
                'loket2' => $antrian->get(2)?->first()?->nomor_antrian ?? 'A 146',
                'loket3' => $antrian->get(3)?->first()?->nomor_antrian ?? 'A 144',
                'loket4' => $antrian->get(4)?->first()?->nomor_antrian ?? 'B 143',
                'loket5' => $antrian->get(5)?->first()?->nomor_antrian ?? 'B 098',
                'current_queue' => $antrian->get(1)?->first(),
            ]
        ]);
    }

    public function loket($id)
    {
        $antrian = Antrian::where('loket_id', $id)
            ->where('status', 'dipanggil')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $antrian
        ]);
    }

    public function current()
    {
        $antrian = Antrian::where('status', 'dipanggil')
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $antrian
        ]);
    }
}
```

## Authentication

### Bearer Token

Jika backend menggunakan Bearer Token:

```env
API_AUTH_TYPE=bearer
API_AUTH_TOKEN=your_bearer_token_here
```

Backend akan menerima header:
```
Authorization: Bearer your_bearer_token_here
```

### API Key

Jika backend menggunakan API Key:

```env
API_AUTH_TYPE=api_key
API_KEY=your_api_key_here
```

Backend akan menerima header:
```
X-API-Key: your_api_key_here
```

## Fitur-Fitur

### 1. Auto Refresh
Display akan otomatis refresh setiap 3 detik menggunakan Livewire polling.

### 2. Caching
Data API di-cache selama 2 detik untuk mengurangi beban server backend.

### 3. Fallback Data
Jika API error atau tidak tersedia, sistem akan menggunakan data fallback atau data cache terakhir.

### 4. Error Handling
Semua error akan di-log ke `storage/logs/laravel.log`.

### 5. Timeout Protection
Request ke API akan timeout setelah 5 detik (configurable).

## Testing API

### Menggunakan cURL

```bash
# Test endpoint display
curl -X GET http://localhost:8080/api/antrian/display \
  -H "Accept: application/json" \
  -H "Authorization: Bearer your_token"

# Test endpoint loket
curl -X GET http://localhost:8080/api/antrian/loket/1 \
  -H "Accept: application/json"

# Test endpoint current
curl -X GET http://localhost:8080/api/antrian/current \
  -H "Accept: application/json"
```

### Menggunakan Postman

1. Create new request
2. Method: GET
3. URL: `http://localhost:8080/api/antrian/display`
4. Headers:
   - `Accept: application/json`
   - `Authorization: Bearer your_token` (jika perlu)
5. Send

## Monitoring & Debugging

### Check Logs

```bash
# Lihat log error
tail -f storage/logs/laravel.log

# Filter log API
tail -f storage/logs/laravel.log | grep "AntrianApiService"
```

### Debug Mode

Untuk melihat detail error di browser, set di `.env`:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Check Cache

```bash
# Clear cache
php artisan cache:clear

# Check cache keys
php artisan tinker
>>> Cache::get('antrian_display_data')
```

## Troubleshooting

### API tidak bisa diakses

1. **Check URL**: Pastikan `API_BASE_URL` benar
2. **Check Network**: Pastikan backend API running
3. **Check Firewall**: Pastikan port tidak diblok
4. **Check CORS**: Pastikan backend mengizinkan CORS dari frontend

### Data tidak update

1. **Check Polling**: Pastikan `wire:poll.3s` ada di view
2. **Check Cache**: Clear cache dengan `php artisan cache:clear`
3. **Check Backend**: Pastikan backend mengembalikan data terbaru

### Authentication Error

1. **Check Token**: Pastikan token valid dan tidak expired
2. **Check Header**: Pastikan format header sesuai dengan backend
3. **Check Permission**: Pastikan token memiliki akses ke endpoint

## Performance Tips

1. **Adjust Polling Interval**: Ubah dari 3s ke interval yang lebih besar jika tidak perlu real-time
2. **Use Cache**: Manfaatkan cache untuk mengurangi request ke backend
3. **Optimize Backend**: Pastikan backend API cepat (< 100ms response time)
4. **Use CDN**: Untuk assets static seperti gambar

## Security Considerations

1. **HTTPS**: Gunakan HTTPS untuk production
2. **Token Rotation**: Rotate API token secara berkala
3. **Rate Limiting**: Implementasi rate limiting di backend
4. **Input Validation**: Validasi semua input dari API
5. **Error Messages**: Jangan expose sensitive info di error messages

## Contoh Lengkap Setup

### 1. Backend (Express.js)

```javascript
// server.js
const express = require('express');
const cors = require('cors');
const app = express();

app.use(cors());
app.use(express.json());

// Middleware auth
const authMiddleware = (req, res, next) => {
  const token = req.headers.authorization?.replace('Bearer ', '');
  if (token === 'your_secret_token') {
    next();
  } else {
    res.status(401).json({ success: false, message: 'Unauthorized' });
  }
};

// Routes
app.get('/api/antrian/display', authMiddleware, (req, res) => {
  res.json({
    success: true,
    data: {
      loket1: 'A 145',
      loket2: 'A 146',
      loket3: 'A 144',
      loket4: 'B 143',
      loket5: 'B 098',
      current_queue: {
        nomor_antrian: 'A 145',
        loket_id: 1
      }
    }
  });
});

app.listen(8080, () => {
  console.log('API running on port 8080');
});
```

### 2. Frontend (.env)

```env
API_BASE_URL=http://localhost:8080
API_AUTH_TYPE=bearer
API_AUTH_TOKEN=your_secret_token
```

### 3. Test

```bash
# Start backend
node server.js

# Start frontend
php artisan serve

# Open browser
http://localhost:8000/display-antrian
```

## Support

Jika ada pertanyaan atau issue, silakan check:
- Log file: `storage/logs/laravel.log`
- API documentation dari backend developer
- Network tab di browser developer tools
