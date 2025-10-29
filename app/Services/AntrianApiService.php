<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AntrianApiService
{
    protected $baseUrl;
    protected $timeout;
    protected $authType;
    protected $authToken;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url');
        $this->timeout = config('api.timeout', 5);
        $this->authType = config('api.auth.type');
        $this->authToken = config('api.auth.token');
    }

    /**
     * Get display data untuk semua loket
     */
    public function getDisplayData()
    {
        try {
            $endpoint = config('api.endpoints.display', '/api/antrian/display');
            
            $response = $this->makeRequest('GET', $endpoint);

            if ($response->successful()) {
                $data = $response->json();
                
                // Cache data selama 2 detik untuk mengurangi load
                Cache::put('antrian_display_data', $data, now()->addSeconds(2));
                
                return [
                    'success' => true,
                    'data' => $data['data'] ?? $data,
                ];
            }

            return $this->getErrorResponse($response);

        } catch (\Exception $e) {
            Log::error('AntrianApiService Error: ' . $e->getMessage());
            
            // Coba ambil dari cache jika ada
            $cachedData = Cache::get('antrian_display_data');
            if ($cachedData) {
                return [
                    'success' => true,
                    'data' => $cachedData['data'] ?? $cachedData,
                    'from_cache' => true,
                ];
            }

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Get data antrian untuk loket tertentu
     */
    public function getLoketData($loketId)
    {
        try {
            $endpoint = config('api.endpoints.loket', '/api/antrian/loket');
            
            $response = $this->makeRequest('GET', "{$endpoint}/{$loketId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return $this->getErrorResponse($response);

        } catch (\Exception $e) {
            Log::error('AntrianApiService Error (Loket): ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Get current queue yang sedang dipanggil
     */
    public function getCurrentQueue()
    {
        try {
            $endpoint = config('api.endpoints.current', '/api/antrian/current');
            
            $response = $this->makeRequest('GET', $endpoint);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return $this->getErrorResponse($response);

        } catch (\Exception $e) {
            Log::error('AntrianApiService Error (Current): ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Make HTTP request dengan authentication
     */
    private function makeRequest($method, $endpoint, $data = [])
    {
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
        
        $request = Http::timeout($this->timeout)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

        // Add authentication jika ada
        if ($this->authToken) {
            if ($this->authType === 'bearer') {
                $request = $request->withToken($this->authToken);
            } elseif ($this->authType === 'api_key') {
                $request = $request->withHeaders([
                    'X-API-Key' => $this->authToken,
                ]);
            }
        }

        return match(strtoupper($method)) {
            'GET' => $request->get($url, $data),
            'POST' => $request->post($url, $data),
            'PUT' => $request->put($url, $data),
            'DELETE' => $request->delete($url, $data),
            default => $request->get($url, $data),
        };
    }

    /**
     * Get error response
     */
    private function getErrorResponse($response)
    {
        return [
            'success' => false,
            'message' => 'API Error: ' . $response->status(),
            'data' => null,
        ];
    }
}
