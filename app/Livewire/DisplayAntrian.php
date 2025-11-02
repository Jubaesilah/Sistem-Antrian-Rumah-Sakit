<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DisplayAntrian extends Component
{
    public $calledQueues = [];
    public $waitingQueues = [];
    public $totalWaiting = 0;
    public $currentTime;
    public $currentDate;
    public $apiError = false;
    public $fromCache = false;
    public $isLoading = false;
    public $lastUpdate;
    public $pollingInterval = 3; // dalam detik
    public $previousCalledQueue = null; // Track previous called queue for speech
    
    // Bearer token for API authentication
    protected $bearerToken = '11|lcGFis1StBkbRKXpISZe75jscWmMhpiSXzPxEbMD34e75610';
    
    // API base URL
    protected $baseUrl = 'http://localhost:8000';

    public function mount()
    {
        // Set polling interval dari config atau default 3 detik
        $this->pollingInterval = config('api.polling_interval', 3);
        
        $this->loadQueueData();
    }

    public function loadQueueData()
    {
        $this->isLoading = true;
        
        try {
            // Get data from cache if available (to reduce API calls)
            $cachedData = Cache::get('antrian_display_data');
            
            if ($cachedData) {
                $this->processApiResponse($cachedData, true);
                
                // Update timestamps even when using cached data
                $this->currentTime = now()->format('H:i:s');
                $this->currentDate = now()->locale('id')->isoFormat('DD MMMM YYYY');
                $this->lastUpdate = now()->format('H:i:s');
                $this->isLoading = false;
                return;
            }
            
            // Make direct API request with Bearer token
            $endpoint = $this->baseUrl . '/api/queues/display';
            
            $response = Http::timeout(30) // 30 seconds timeout
                ->withToken($this->bearerToken)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($endpoint);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Cache the response for 2 seconds
                Cache::put('antrian_display_data', $data, now()->addSeconds(2));
                
                // Process the response
                $this->processApiResponse($data);
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
        
        $this->currentTime = now()->format('H:i:s');
        $this->currentDate = now()->locale('id')->isoFormat('DD MMMM YYYY');
        $this->lastUpdate = now()->format('H:i:s');
        $this->isLoading = false;
    }
    
    /**
     * Process the API response data
     */
    private function processApiResponse($data, $fromCache = false)
    {
        // Check if data is nested in 'data' key
        $queueData = $data['data'] ?? $data;
        
        // Extract queue data
        $newCalledQueues = $queueData['called_queues'] ?? [];
        $this->waitingQueues = $queueData['waiting_queues'] ?? [];
        $this->totalWaiting = $queueData['total_waiting'] ?? 0;
        
        // Check if there's a new called queue (for speech synthesis)
        if (!empty($newCalledQueues)) {
            $currentCalledQueue = $newCalledQueues[0]['queue_number'] ?? null;
            
            // If there's a new queue number different from previous, trigger speech
            if ($currentCalledQueue && $currentCalledQueue !== $this->previousCalledQueue) {
                $counterName = $newCalledQueues[0]['counter']['counter_name'] ?? 'Loket';
                
                // Dispatch browser event for speech synthesis
                $this->dispatch('speakQueue', [
                    'queueNumber' => $currentCalledQueue,
                    'counterName' => $counterName
                ]);
                
                // Update previous queue
                $this->previousCalledQueue = $currentCalledQueue;
            }
        }
        
        $this->calledQueues = $newCalledQueues;
        $this->apiError = false;
        $this->fromCache = $fromCache;
    }


    /**
     * Gunakan data fallback jika API tidak tersedia
     */
    private function useFallbackData()
    {
        // Set empty arrays for fallback data
        $this->calledQueues = [];
        $this->waitingQueues = [];
        $this->totalWaiting = 0;
    }

    public function render()
    {
        // Set the title in the view data
        return view('livewire.display-antrian', [
            'title' => 'Display Antrian'
        ]);
    }

    /**
     * Method untuk di-trigger oleh wire:poll
     * Akan dipanggil otomatis setiap X detik
     */
    public function refreshQueue()
    {
        $this->loadQueueData();
    }

    /**
     * Method untuk manual refresh (jika diperlukan)
     */
    public function manualRefresh()
    {
        $this->loadQueueData();
        $this->dispatch('queue-refreshed');
    }
}
