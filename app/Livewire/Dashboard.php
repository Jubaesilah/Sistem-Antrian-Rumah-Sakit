<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;

class Dashboard extends Component
{
    public $user;
    public $totalAntrian = 0;
    public $totalLoket = 0;
    public $totalUser = 0;
    public $trafficHarian = [];
    public $antrianPerLoket = [];
    public $statusDistribution = [];
    public $rataRataWaktuTunggu = 0;
    public $isLoading = false;
    public $apiError = false;

    public function mount()
    {
        // Get authenticated user
        $this->user = AuthHelper::getUser();

        // Load dashboard data from API
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->isLoading = true;

        try {
            // 1. Get dashboard statistics
            $statsResponse = AuthHelper::apiRequest('GET', '/api/dashboard/stats');

            if ($statsResponse->successful()) {
                $statsData = $statsResponse->json();
                $stats = $statsData['data'] ?? [];

                // Update stats
                $this->totalAntrian = $stats['total_queues_today'] ?? 0;
                $this->totalLoket = $stats['total_counters'] ?? 0;
                $this->totalUser = $stats['total_users'] ?? 0;

                // Average waiting time
                $avgTime = $stats['average_waiting_time'] ?? [];
                $this->rataRataWaktuTunggu = $avgTime['value'] ?? 0;

                $this->apiError = false;
            } else {
                $this->loadDummyStats();
                $this->apiError = true;
            }

            // 2. Get charts data, tidak perlu lagi filter
            $chartsResponse = AuthHelper::apiRequest('GET', '/api/dashboard/charts');

            if ($chartsResponse->successful()) {
                $chartsData = $chartsResponse->json();
                $charts = $chartsData['data'] ?? [];

                // Traffic chart
                $this->trafficHarian = $this->formatTrafficChart($charts['traffic_chart'] ?? []);

                // Queue per counter chart
                $this->antrianPerLoket = $this->formatQueuePerCounter($charts['queue_per_counter_chart'] ?? []);
            } else {
                $this->trafficHarian = $this->getDummyTrafficData();
                $this->antrianPerLoket = $this->getDummyQueuePerCounter();
            }

            // 3. Get status distribution
            $statusResponse = AuthHelper::apiRequest('GET', '/api/dashboard/status-distribution');

            if ($statusResponse->successful()) {
                $statusData = $statusResponse->json();
                $this->statusDistribution = $statusData['data'] ?? [];
            }
        } catch (\Exception $e) {
            // If exception, use dummy data
            $this->loadDummyStats();
            $this->trafficHarian = $this->getDummyTrafficData();
            $this->antrianPerLoket = $this->getDummyQueuePerCounter();
            $this->apiError = true;
        }

        $this->isLoading = false;
    }

    private function formatTrafficChart($data)
    {
        // Format traffic chart data based on filter
        return collect($data)->map(function ($item) {
            return [
                'hari' => $item['period'],
                'total' => $item['total']
            ];
        })->toArray();
    }

    private function formatQueuePerCounter($data)
    {
        $colors = ['blue', 'indigo', 'green', 'purple', 'red', 'pink', 'yellow', 'orange'];

        return collect($data)->map(function ($item, $index) use ($colors) {
            // Extract kode from counter name (e.g., "Poli Anak" -> "A")
            $kode = chr(65 + $index); // A, B, C, etc.

            return [
                'nama' => $item['counter_name'],
                'kode' => $kode,
                'total' => $item['total'],
                'warna' => $colors[$index % count($colors)]
            ];
        })->toArray();
    }

    private function loadDummyStats()
    {
        $this->totalAntrian = rand(120, 250);
        $this->totalLoket = 8;
        $this->totalUser = rand(15, 25);
        $this->rataRataWaktuTunggu = rand(10, 30);
    }

    private function loadDummyData()
    {
        // Total antrian hari ini
        $this->totalAntrian = rand(120, 250);

        // Total loket aktif
        $this->totalLoket = 8;

        // Total user (staff)
        $this->totalUser = rand(15, 25);

        // Data traffic harian (7 hari terakhir)
        $this->trafficHarian = [
            ['hari' => 'Senin', 'total' => rand(100, 200)],
            ['hari' => 'Selasa', 'total' => rand(100, 200)],
            ['hari' => 'Rabu', 'total' => rand(100, 200)],
            ['hari' => 'Kamis', 'total' => rand(100, 200)],
            ['hari' => 'Jumat', 'total' => rand(100, 200)],
            ['hari' => 'Sabtu', 'total' => rand(50, 100)],
            ['hari' => 'Minggu', 'total' => rand(30, 80)],
        ];

        // Data antrian per loket
        $this->antrianPerLoket = [
            ['nama' => 'Poli Anak', 'kode' => 'A', 'total' => rand(20, 50), 'warna' => 'blue'],
            ['nama' => 'Poli Gigi', 'kode' => 'B', 'total' => rand(15, 40), 'warna' => 'indigo'],
            ['nama' => 'Poli Umum', 'kode' => 'C', 'total' => rand(30, 60), 'warna' => 'green'],
            ['nama' => 'Poli Mata', 'kode' => 'D', 'total' => rand(10, 30), 'warna' => 'purple'],
            ['nama' => 'Poli Jantung', 'kode' => 'E', 'total' => rand(5, 25), 'warna' => 'red'],
            ['nama' => 'Poli Kandungan', 'kode' => 'F', 'total' => rand(15, 35), 'warna' => 'pink'],
            ['nama' => 'Poli THT', 'kode' => 'G', 'total' => rand(10, 30), 'warna' => 'yellow'],
            ['nama' => 'Poli Kulit', 'kode' => 'H', 'total' => rand(15, 35), 'warna' => 'orange'],
        ];

        // Rata-rata waktu tunggu (dalam menit)
        $this->rataRataWaktuTunggu = rand(10, 30);

        // Set traffic and queue data
        $this->trafficHarian = $this->getDummyTrafficData();
        $this->antrianPerLoket = $this->getDummyQueuePerCounter();
    }

    private function getDummyTrafficData()
    {
        return [
            ['hari' => 'Senin', 'total' => rand(100, 200)],
            ['hari' => 'Selasa', 'total' => rand(100, 200)],
            ['hari' => 'Rabu', 'total' => rand(100, 200)],
            ['hari' => 'Kamis', 'total' => rand(100, 200)],
            ['hari' => 'Jumat', 'total' => rand(100, 200)],
            ['hari' => 'Sabtu', 'total' => rand(50, 100)],
            ['hari' => 'Minggu', 'total' => rand(30, 80)],
        ];
    }

    private function getDummyQueuePerCounter()
    {
        return [
            ['nama' => 'Poli Anak', 'kode' => 'A', 'total' => rand(20, 50), 'warna' => 'blue'],
            ['nama' => 'Poli Gigi', 'kode' => 'B', 'total' => rand(15, 40), 'warna' => 'indigo'],
            ['nama' => 'Poli Umum', 'kode' => 'C', 'total' => rand(30, 60), 'warna' => 'green'],
            ['nama' => 'Poli Mata', 'kode' => 'D', 'total' => rand(10, 30), 'warna' => 'purple'],
            ['nama' => 'Poli Jantung', 'kode' => 'E', 'total' => rand(5, 25), 'warna' => 'red'],
            ['nama' => 'Poli Kandungan', 'kode' => 'F', 'total' => rand(15, 35), 'warna' => 'pink'],
            ['nama' => 'Poli THT', 'kode' => 'G', 'total' => rand(10, 30), 'warna' => 'yellow'],
            ['nama' => 'Poli Kulit', 'kode' => 'H', 'total' => rand(15, 35), 'warna' => 'orange'],
        ];
    }

    public function refreshData()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
