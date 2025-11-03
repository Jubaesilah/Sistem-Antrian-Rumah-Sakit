<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class AmbilAntrian extends Component
{
    public $lokets = [];
    public $selectedLoket = null;
    public $nomorAntrian = null;
    public $showTicket = false;
    public $isLoading = false;
    public $printLoading = false;
    public $apiError = false;

    public function mount()
    {
        $this->loadCounters();
    }

    public function loadCounters()
    {
        try {
            // Make API request using AuthHelper (public endpoint)
            $response = AuthHelper::apiRequest('GET', '/api/counters/list', [], false);

            if ($response->successful()) {
                $data = $response->json();

                // Log untuk debugging
                Log::info('AmbilAntrian: API response received', [
                    'status' => $response->status(),
                    'has_success' => isset($data['success']),
                    'has_data' => isset($data['data']),
                    'data_count' => isset($data['data']) ? count($data['data']) : 0
                ]);

                // Validate response structure - format: {status_code, success, message, data}
                if (isset($data['success']) && $data['success'] === true && isset($data['data']) && is_array($data['data'])) {
                    // Process the response
                    $this->processCountersData($data);

                    // Only set error if no counters found
                    if (empty($this->lokets)) {
                        Log::warning('AmbilAntrian: API response successful but no counters found', ['response' => $data]);
                        $this->apiError = false; // Don't show error if valid response but empty
                    } else {
                        $this->apiError = false;
                    }
                } else {
                    // Response format tidak sesuai
                    Log::error('AmbilAntrian: Invalid API response format', [
                        'status' => $response->status(),
                        'response' => $data,
                        'expected_format' => '{success: true, data: [...]}'
                    ]);
                    $this->useFallbackData();
                    $this->apiError = true;
                }
            } else {
                // Handle error response
                $status = $response->status();
                $body = $response->body();
                Log::error('AmbilAntrian: API request failed', [
                    'status' => $status,
                    'endpoint' => '/api/counters/list',
                    'response' => $body
                ]);
                $this->useFallbackData();
                $this->apiError = true;
            }
        } catch (\Exception $e) {
            // Handle exceptions
            Log::error('AmbilAntrian: Exception in loadCounters', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->useFallbackData();
            $this->apiError = true;
        }
    }

    private function processCountersData($data)
    {
        try {
            // Extract counters from API response
            $counters = $data['data'] ?? [];

            // Validate counters is an array
            if (!is_array($counters)) {
                Log::warning('AmbilAntrian: Counters data is not an array', ['data' => $counters]);
                $counters = [];
            }

            // Map API data to lokets format with icons and colors
            $this->lokets = collect($counters)->filter(function ($counter) {
                // Validate required fields
                return isset($counter['counter_id']) && isset($counter['counter_name']);
            })->map(function ($counter, $index) {
                // Assign icons and colors based on counter name or index
                $icons = ['child', 'tooth', 'medical', 'eye', 'heart', 'baby'];
                $colors = ['blue', 'cyan', 'green', 'purple', 'red', 'pink'];

                return [
                    'id' => $counter['counter_id'],
                    'kode' => chr(65 + $index), // A, B, C, etc.
                    'nama' => $counter['counter_name'],
                    'deskripsi' => $counter['description'] ?? 'Layanan kesehatan',
                    'icon' => $icons[$index % count($icons)],
                    'warna' => $colors[$index % count($colors)]
                ];
            })->values()->toArray(); // values() untuk re-index array setelah filter

            // Reset error state if data processed successfully
            $this->apiError = false;
        } catch (\Exception $e) {
            Log::error('AmbilAntrian: Error processing counters data', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            // Set empty array instead of fallback to allow retry
            $this->lokets = [];
            $this->apiError = true;
        }
    }

    private function useFallbackData()
    {
        // Fallback data if API is not available
        $this->lokets = [
            [
                'id' => 'fallback-1',
                'kode' => 'A',
                'nama' => 'Loket Umum',
                'deskripsi' => 'Layanan umum (Data fallback)',
                'icon' => 'medical',
                'warna' => 'blue'
            ]
        ];
    }

    public function ambilNomor($loketId)
    {
        $this->isLoading = true;

        try {
            // Cari loket yang dipilih
            $loket = collect($this->lokets)->firstWhere('id', $loketId);
            $this->selectedLoket = $loket;

            // Make API request to create queue using AuthHelper (public endpoint)
            $response = AuthHelper::apiRequest('POST', '/api/queues', [
                'counter_id' => $loketId
            ], false);

            if ($response->successful()) {
                $data = $response->json();

                // Extract queue data from response
                $queueData = $data['data'] ?? [];

                // Format nomor antrian
                $this->nomorAntrian = [
                    'queue_id' => $queueData['queue_id'] ?? null,
                    'counter_id' => $queueData['counter_id'] ?? null,
                    'kode' => $loket['kode'],
                    'nomor' => $queueData['queue_number'] ?? 'N/A',
                    'formatted' => $queueData['queue_number'] ?? 'N/A',
                    'estimasi' => rand(10, 60), // Estimasi waktu dalam menit
                    'tanggal' => now()->format('d M Y'),
                    'waktu' => now()->format('H:i'),
                    'loket' => $queueData['counter']['counter_name'] ?? $loket['nama'],
                    'status' => $queueData['status'] ?? 'waiting',
                ];

                // Show ticket modal by setting property to true
                $this->showTicket = true;

                // Show success message
                session()->flash('success', 'Nomor antrian berhasil dibuat: ' . $queueData['queue_number']);
            } else {
                // Handle error
                session()->flash('error', 'Gagal mengambil nomor antrian. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            // Handle exception
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function closeTicket()
    {
        $this->showTicket = false;
        $this->selectedLoket = null;
        $this->nomorAntrian = null;
    }

    public function render()
    {
        return view('livewire.ambil-antrian');
    }
}
