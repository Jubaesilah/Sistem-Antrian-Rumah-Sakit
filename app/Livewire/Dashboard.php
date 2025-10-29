<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    // Dummy data untuk dashboard
    public $totalAntrian = 0;
    public $totalLoket = 0;
    public $totalUser = 0;
    public $trafficHarian = [];
    public $antrianPerLoket = [];
    public $rataRataWaktuTunggu = 0;
    public $isLoading = false;
    
    public function mount()
    {
        $this->loadDummyData();
    }
    
    public function loadDummyData()
    {
        $this->isLoading = true;
        
        // Simulasi delay loading data
        usleep(500000); // 0.5 detik
        
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
        
        $this->isLoading = false;
    }
    
    public function refreshData()
    {
        $this->loadDummyData();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
