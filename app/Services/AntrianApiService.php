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
        $this->timeout = config('api.timeout', 30);
        $this->authType = config('api.auth.type');
        $this->authToken = config('api.auth.token');
    }

    /**
     * Get display data untuk semua loket
     */
    public function getDisplayData()
    {
        try {
            // Use the correct endpoint from the Postman collection
            $endpoint = '/api/queues/display';
            
            $response = $this->makeRequest('GET', $endpoint);

            if ($response->successful()) {
                $data = $response->json();
                
                // Cache data for 2 seconds to reduce load
                Cache::put('antrian_display_data', $data, now()->addSeconds(2));
                
                // Verifikasi format response sesuai dengan API baru
                if (isset($data['success']) && $data['success'] === true && isset($data['data'])) {
                    // This is the expected format from the API you showed
                    return [
                        'success' => true,
                        'data' => $data['data'],
                        'message' => $data['message'] ?? 'Success',
                    ];
                }
                
                // Fallback for other API formats
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
                Log::info('Using cached data due to API error');
                return [
                    'success' => true,
                    'data' => $cachedData['data'] ?? $cachedData,
                    'from_cache' => true,
                ];
            }
            
            // If no cache, provide mock data for testing
            Log::info('No cache available, using mock data');
            return [
                'success' => true,
                'from_cache' => false,
                'is_mock' => true,
                'data' => [
                    'called_queues' => [
                        [
                            'queue_id' => 'mock-01',
                            'counter_id' => 'counter-01',
                            'queue_number' => 'A001',
                            'status' => 'called',
                            'called_at' => now()->toISOString(),
                            'called_by' => [
                                'user_id' => 'user-01',
                                'full_name' => 'Operator'
                            ],
                            'created_at' => now()->toISOString(),
                            'updated_at' => now()->toISOString(),
                            'counter' => [
                                'counter_id' => 'counter-01',
                                'counter_name' => 'Loket 1'
                            ]
                        ]
                    ],
                    'waiting_queues' => [
                        [
                            'queue_id' => 'mock-02',
                            'counter_id' => 'counter-01',
                            'queue_number' => 'A002',
                            'status' => 'waiting',
                            'called_at' => null,
                            'called_by' => null,
                            'created_at' => now()->toISOString(),
                            'updated_at' => now()->toISOString(),
                            'counter' => [
                                'counter_id' => 'counter-01',
                                'counter_name' => 'Loket 1'
                            ]
                        ]
                    ],
                    'total_waiting' => 1
                ],
                'message' => 'Using mock data due to API error: ' . $e->getMessage(),
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
        
        try {
            $request = Http::timeout($this->timeout)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]);
    
            // Always use Bearer token authentication
            $token = '11|lcGFis1StBkbRKXpISZe75jscWmMhpiSXzPxEbMD34e75610';
            $request = $request->withToken($token);
    
            $response = match(strtoupper($method)) {
                'GET' => $request->get($url, $data),
                'POST' => $request->post($url, $data),
                'PUT' => $request->put($url, $data),
                'DELETE' => $request->delete($url, $data),
                default => $request->get($url, $data),
            };
            
            return $response;
        } catch (\Exception $e) {
            throw $e; // Re-throw to be caught by the calling method
        }
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
