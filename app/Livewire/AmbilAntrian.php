<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AmbilAntrian extends Component
{
    public $lokets = [];
    public $selectedLoket = null;
    public $nomorAntrian = null;
    public $showTicket = false;
    public $isLoading = false;
    public $printLoading = false;
    public $apiError = false;
    
    // Bearer token for API authentication
    protected $bearerToken = '11|lcGFis1StBkbRKXpISZe75jscWmMhpiSXzPxEbMD34e75610';
    
    // API base URL
    protected $baseUrl = 'http://localhost:8000';
    
    public function mount()
    {
        $this->loadCounters();
    }
    
    public function loadCounters()
    {
        try {
            // Get data from cache if available
            $cachedData = Cache::get('counters_list');
            
            if ($cachedData) {
                $this->processCountersData($cachedData);
                return;
            }
            
            // Make direct API request with Bearer token
            $endpoint = $this->baseUrl . '/api/counters/list';
            
            $response = Http::timeout(30)
                ->withToken($this->bearerToken)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($endpoint);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Cache the response for 5 minutes
                Cache::put('counters_list', $data, now()->addMinutes(5));
                
                // Process the response
                $this->processCountersData($data);
            } else {
                // Handle error response
                $this->useFallbackData();
                $this->apiError = true;
            }
        } catch (\Exception $e) {
            // Handle exceptions
            $this->useFallbackData();
            $this->apiError = true;
        }
    }
    
    private function processCountersData($data)
    {
        // Extract counters from API response
        $counters = $data['data'] ?? [];
        
        // Map API data to lokets format with icons and colors
        $this->lokets = collect($counters)->map(function($counter, $index) {
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
        })->toArray();
        
        $this->apiError = false;
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
            
            // Make API request to create queue
            $endpoint = $this->baseUrl . '/api/queues';
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, [
                    'counter_id' => $loketId
                ]);
            
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
