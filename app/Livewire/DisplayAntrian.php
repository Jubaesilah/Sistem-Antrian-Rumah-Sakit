<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AntrianApiService;

class DisplayAntrian extends Component
{
    public $currentQueue;
    public $loket1;
    public $loket2;
    public $loket3;
    public $loket4;
    public $loket5;
    public $loket6;
    public $loket7;
    public $loket8;
    public $currentTime;
    public $currentDate;
    public $apiError = false;
    public $fromCache = false;
    public $isLoading = false;
    public $lastUpdate;
    public $pollingInterval = 3; // dalam detik
    public $useDummyData = true; // Set false jika API sudah ready

    protected $apiService;

    public function boot(AntrianApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function mount()
    {
        // Set polling interval dari config atau default 3 detik
        $this->pollingInterval = config('api.polling_interval', 3);
        
        // Check apakah menggunakan dummy data dari config
        $this->useDummyData = config('api.use_dummy_data', true);
        
        $this->loadQueueData();
    }

    public function loadQueueData()
    {
        $this->isLoading = true;
        
        // MODE DUMMY DATA - Untuk development/preview tanpa backend
        if ($this->useDummyData) {
            $this->loadDummyData();
            $this->apiError = false;
        } 
        // MODE API - Uncomment saat backend sudah ready
        else {
            // Ambil data dari API menggunakan service
            $result = $this->apiService->getDisplayData();

            if ($result['success']) {
                $queueData = $result['data'];
                
                // Parse data dari API
                // Format expected: 
                // {
                //   "loket1": "A 145",
                //   "loket2": "A 146",
                //   "loket3": "A 144",
                //   "loket4": "B 143",
                //   "loket5": "B 098",
                //   "loket6": "C 120",
                //   "loket7": "C 121",
                //   "loket8": "C 122",
                //   "current_queue": {...}
                // }
                
                $this->loket1 = $queueData['loket1'] ?? 'A 145';
                $this->loket2 = $queueData['loket2'] ?? 'A 146';
                $this->loket3 = $queueData['loket3'] ?? 'A 144';
                $this->loket4 = $queueData['loket4'] ?? 'B 143';
                $this->loket5 = $queueData['loket5'] ?? 'B 098';
                $this->loket6 = $queueData['loket6'] ?? 'C 120';
                $this->loket7 = $queueData['loket7'] ?? 'C 121';
                $this->loket8 = $queueData['loket8'] ?? 'C 122';
                
                $this->currentQueue = $queueData['current_queue'] ?? null;
                
                $this->apiError = false;
                $this->fromCache = $result['from_cache'] ?? false;
            } else {
                // Jika API error, gunakan data fallback
                $this->useFallbackData();
                $this->apiError = true;
            }
        }

        $this->currentTime = now()->format('H:i:s');
        $this->currentDate = now()->locale('id')->isoFormat('DD MMMM YYYY');
        $this->lastUpdate = now()->format('H:i:s');
        $this->isLoading = false;
    }

    /**
     * Load dummy data untuk preview/development
     * Data akan berubah setiap refresh untuk simulasi real-time
     */
    private function loadDummyData()
    {
        // Simulasi data yang berubah-ubah
        $prefixes = ['A', 'B', 'C'];
        $currentMinute = now()->minute;
        
        // Generate nomor antrian yang berubah setiap menit
        $baseNumber = 100 + $currentMinute;
        
        $this->loket1 = $prefixes[0] . ' ' . ($baseNumber + rand(0, 5));
        $this->loket2 = $prefixes[0] . ' ' . ($baseNumber + rand(6, 10));
        $this->loket3 = $prefixes[0] . ' ' . ($baseNumber - rand(1, 5));
        $this->loket4 = $prefixes[1] . ' ' . ($baseNumber + rand(0, 10));
        $this->loket5 = $prefixes[1] . ' ' . ($baseNumber - rand(10, 20));
        $this->loket6 = $prefixes[2] . ' ' . ($baseNumber + rand(15, 25));
        $this->loket7 = $prefixes[2] . ' ' . ($baseNumber + rand(26, 35));
        $this->loket8 = $prefixes[2] . ' ' . ($baseNumber + rand(36, 45));
        
        // Dummy current queue
        $this->currentQueue = [
            'nomor_antrian' => $this->loket1,
            'loket_id' => 1,
            'nama_pasien' => 'John Doe',
            'jenis_layanan' => 'Pendaftaran',
        ];
    }

    /**
     * Gunakan data fallback jika API tidak tersedia
     */
    private function useFallbackData()
    {
        $this->loket1 = $this->loket1 ?? 'A 145';
        $this->loket2 = $this->loket2 ?? 'A 146';
        $this->loket3 = $this->loket3 ?? 'A 144';
        $this->loket4 = $this->loket4 ?? 'B 143';
        $this->loket5 = $this->loket5 ?? 'B 098';
        $this->loket6 = $this->loket6 ?? 'C 120';
        $this->loket7 = $this->loket7 ?? 'C 121';
        $this->loket8 = $this->loket8 ?? 'C 122';
    }

    public function render()
    {
        return view('livewire.display-antrian');
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
