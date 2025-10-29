<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Backend Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk koneksi ke API backend yang menyediakan data antrian.
    | Sesuaikan base_url dengan URL backend yang dibuat oleh teman Anda.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Use Dummy Data
    |--------------------------------------------------------------------------
    |
    | Set true untuk menggunakan dummy data (tanpa API backend).
    | Set false untuk menggunakan API backend yang sebenarnya.
    | Berguna untuk development/preview sebelum backend ready.
    |
    */

    'use_dummy_data' => env('API_USE_DUMMY_DATA', true),

    'base_url' => env('API_BASE_URL', 'http://localhost:8080'),

    /*
    |--------------------------------------------------------------------------
    | API Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout untuk request ke API dalam detik.
    |
    */

    'timeout' => env('API_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | Polling Interval
    |--------------------------------------------------------------------------
    |
    | Interval waktu untuk auto-refresh display antrian (dalam detik).
    | Livewire akan otomatis refresh data setiap X detik.
    |
    */

    'polling_interval' => env('API_POLLING_INTERVAL', 3),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | Daftar endpoint yang digunakan untuk mengambil data antrian.
    |
    */

    'endpoints' => [
        'display' => '/api/antrian/display',
        'loket' => '/api/antrian/loket',
        'current' => '/api/antrian/current',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Authentication
    |--------------------------------------------------------------------------
    |
    | Jika API memerlukan authentication, set token di sini.
    |
    */

    'auth' => [
        'type' => env('API_AUTH_TYPE', 'bearer'), // bearer, basic, api_key
        'token' => env('API_AUTH_TOKEN', null),
        'api_key' => env('API_KEY', null),
    ],

];
