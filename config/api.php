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


    'base_url' => env('API_BASE_URL', 'http://localhost:8000'),

    /*
    |--------------------------------------------------------------------------
    | API Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout untuk request ke API dalam detik.
    |
    */

    'timeout' => env('API_TIMEOUT', 30), // Increased to 30 seconds

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
        'display' => '/api/queues/display',
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
        'token' => env('API_AUTH_TOKEN', '11|lcGFis1StBkbRKXpISZe75jscWmMhpiSXzPxEbMD34e75610'),
        'api_key' => env('API_KEY', null),
    ],

];
