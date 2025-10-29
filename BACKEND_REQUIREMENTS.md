# Backend API Requirements - Sistem Antrian Rumah Sakit

Dokumen ini untuk **Backend Developer** yang akan membuat API untuk sistem display antrian.

## Overview

Frontend (Livewire) akan melakukan HTTP request ke backend API untuk mendapatkan data antrian yang akan ditampilkan di display.

## Required Endpoints

### 1. GET `/api/antrian/display`

**Deskripsi:** Endpoint utama untuk mendapatkan data semua loket yang akan ditampilkan di display.

**Request:**
```http
GET /api/antrian/display HTTP/1.1
Host: your-backend-url.com
Accept: application/json
Authorization: Bearer {token}  # Optional, jika pakai auth
```

**Response Success (200):**
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
      "jenis_layanan": "Pendaftaran",
      "waktu_panggil": "2024-01-01 10:30:00"
    }
  }
}
```

**Response Error (500):**
```json
{
  "success": false,
  "message": "Error message here",
  "data": null
}
```

**Field Explanation:**
- `loket1` - `loket5`: Nomor antrian yang sedang dipanggil di setiap loket (string)
- `current_queue`: Data detail antrian yang sedang aktif di loket 1 (object, optional)

---

### 2. GET `/api/antrian/loket/{id}` (Optional)

**Deskripsi:** Mendapatkan data antrian untuk loket tertentu.

**Request:**
```http
GET /api/antrian/loket/1 HTTP/1.1
Host: your-backend-url.com
Accept: application/json
```

**Response Success (200):**
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

---

### 3. GET `/api/antrian/current` (Optional)

**Deskripsi:** Mendapatkan antrian yang sedang aktif/dipanggil saat ini.

**Request:**
```http
GET /api/antrian/current HTTP/1.1
Host: your-backend-url.com
Accept: application/json
```

**Response Success (200):**
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

---

## Technical Requirements

### 1. Response Format
- **Content-Type:** `application/json`
- **Character Encoding:** UTF-8
- **Response Time:** < 200ms (recommended)

### 2. HTTP Status Codes
- `200` - Success
- `400` - Bad Request
- `401` - Unauthorized (jika pakai authentication)
- `404` - Not Found
- `500` - Internal Server Error

### 3. CORS Configuration

Jika frontend dan backend di domain/port berbeda, backend harus mengizinkan CORS:

**Headers yang harus di-set:**
```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, OPTIONS
Access-Control-Allow-Headers: Content-Type, Authorization, Accept
```

**Contoh di Express.js:**
```javascript
const cors = require('cors');
app.use(cors());
```

**Contoh di Laravel:**
```php
// config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['*'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### 4. Authentication (Optional)

Jika menggunakan authentication, pilih salah satu:

**Option A: Bearer Token**
```http
Authorization: Bearer your_token_here
```

**Option B: API Key**
```http
X-API-Key: your_api_key_here
```

Frontend akan mengirim header sesuai konfigurasi di `.env`.

---

## Database Schema Recommendation

Berikut rekomendasi struktur database untuk backend:

### Table: `antrian`

| Column | Type | Description |
|--------|------|-------------|
| id | INT/BIGINT | Primary key |
| nomor_antrian | VARCHAR(10) | Nomor antrian (e.g., "A 145") |
| loket_id | INT | ID loket (1-5) |
| status | ENUM | 'menunggu', 'dipanggil', 'selesai' |
| nama_pasien | VARCHAR(100) | Nama pasien (optional) |
| jenis_layanan | VARCHAR(50) | Jenis layanan (optional) |
| waktu_panggil | TIMESTAMP | Waktu antrian dipanggil |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Indexes:**
- `idx_loket_status` on (loket_id, status)
- `idx_status` on (status)

---

## Implementation Examples

### Express.js + MySQL

```javascript
const express = require('express');
const mysql = require('mysql2/promise');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// Database connection
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'antrian_db',
  waitForConnections: true,
  connectionLimit: 10
});

// Middleware auth (optional)
const authMiddleware = (req, res, next) => {
  const token = req.headers.authorization?.replace('Bearer ', '');
  if (!token || token !== process.env.API_TOKEN) {
    return res.status(401).json({
      success: false,
      message: 'Unauthorized'
    });
  }
  next();
};

// GET /api/antrian/display
app.get('/api/antrian/display', async (req, res) => {
  try {
    const [rows] = await pool.query(`
      SELECT loket_id, nomor_antrian, nama_pasien, jenis_layanan, waktu_panggil
      FROM antrian
      WHERE status = 'dipanggil'
      ORDER BY updated_at DESC
    `);

    // Group by loket
    const data = {
      loket1: null,
      loket2: null,
      loket3: null,
      loket4: null,
      loket5: null,
      current_queue: null
    };

    rows.forEach(row => {
      const loketKey = `loket${row.loket_id}`;
      if (!data[loketKey]) {
        data[loketKey] = row.nomor_antrian;
      }
      if (row.loket_id === 1 && !data.current_queue) {
        data.current_queue = row;
      }
    });

    // Set default values jika tidak ada data
    data.loket1 = data.loket1 || 'A 145';
    data.loket2 = data.loket2 || 'A 146';
    data.loket3 = data.loket3 || 'A 144';
    data.loket4 = data.loket4 || 'B 143';
    data.loket5 = data.loket5 || 'B 098';

    res.json({
      success: true,
      data: data
    });

  } catch (error) {
    console.error('Error:', error);
    res.status(500).json({
      success: false,
      message: error.message,
      data: null
    });
  }
});

// GET /api/antrian/loket/:id
app.get('/api/antrian/loket/:id', async (req, res) => {
  try {
    const loketId = req.params.id;
    
    const [rows] = await pool.query(`
      SELECT *
      FROM antrian
      WHERE loket_id = ? AND status = 'dipanggil'
      ORDER BY updated_at DESC
      LIMIT 1
    `, [loketId]);

    res.json({
      success: true,
      data: rows[0] || null
    });

  } catch (error) {
    res.status(500).json({
      success: false,
      message: error.message,
      data: null
    });
  }
});

// GET /api/antrian/current
app.get('/api/antrian/current', async (req, res) => {
  try {
    const [rows] = await pool.query(`
      SELECT *
      FROM antrian
      WHERE status = 'dipanggil'
      ORDER BY updated_at DESC
      LIMIT 1
    `);

    res.json({
      success: true,
      data: rows[0] || null
    });

  } catch (error) {
    res.status(500).json({
      success: false,
      message: error.message,
      data: null
    });
  }
});

const PORT = process.env.PORT || 8080;
app.listen(PORT, () => {
  console.log(`API Server running on port ${PORT}`);
});
```

### Laravel

```php
// routes/api.php
Route::prefix('antrian')->group(function () {
    Route::get('/display', [AntrianController::class, 'display']);
    Route::get('/loket/{id}', [AntrianController::class, 'loket']);
    Route::get('/current', [AntrianController::class, 'current']);
});

// app/Http/Controllers/AntrianController.php
namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function display()
    {
        try {
            $antrian = Antrian::where('status', 'dipanggil')
                ->orderBy('updated_at', 'desc')
                ->get()
                ->groupBy('loket_id');

            $data = [
                'loket1' => $antrian->get(1)?->first()?->nomor_antrian ?? 'A 145',
                'loket2' => $antrian->get(2)?->first()?->nomor_antrian ?? 'A 146',
                'loket3' => $antrian->get(3)?->first()?->nomor_antrian ?? 'A 144',
                'loket4' => $antrian->get(4)?->first()?->nomor_antrian ?? 'B 143',
                'loket5' => $antrian->get(5)?->first()?->nomor_antrian ?? 'B 098',
                'current_queue' => $antrian->get(1)?->first(),
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function loket($id)
    {
        try {
            $antrian = Antrian::where('loket_id', $id)
                ->where('status', 'dipanggil')
                ->orderBy('updated_at', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'data' => $antrian
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function current()
    {
        try {
            $antrian = Antrian::where('status', 'dipanggil')
                ->orderBy('updated_at', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'data' => $antrian
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
```

---

## Testing

### Manual Testing dengan cURL

```bash
# Test endpoint display
curl -X GET http://localhost:8080/api/antrian/display \
  -H "Accept: application/json"

# Test dengan authentication
curl -X GET http://localhost:8080/api/antrian/display \
  -H "Accept: application/json" \
  -H "Authorization: Bearer your_token"

# Test endpoint loket
curl -X GET http://localhost:8080/api/antrian/loket/1 \
  -H "Accept: application/json"
```

### Expected Response

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
      "jenis_layanan": "Pendaftaran",
      "waktu_panggil": "2024-01-01 10:30:00"
    }
  }
}
```

---

## Performance Considerations

1. **Caching:** Implementasi caching untuk mengurangi query database
2. **Indexing:** Pastikan ada index pada kolom `status` dan `loket_id`
3. **Connection Pooling:** Gunakan connection pooling untuk database
4. **Response Time:** Target < 200ms per request
5. **Rate Limiting:** Implementasi rate limiting untuk mencegah abuse

---

## Deployment Checklist

- [ ] CORS configured properly
- [ ] Database indexes created
- [ ] Environment variables set
- [ ] Authentication implemented (if needed)
- [ ] Error logging configured
- [ ] API documentation ready
- [ ] Test all endpoints
- [ ] Monitor response time
- [ ] Setup SSL/HTTPS for production

---

## Contact & Support

Jika ada pertanyaan tentang format response atau requirement lainnya, silakan koordinasi dengan frontend developer.

**Frontend akan melakukan request setiap 3 detik**, jadi pastikan API cukup cepat dan efficient.
