<?php

namespace App\Livewire;

use Livewire\Component;

class AmbilAntrian extends Component
{
    public $lokets = [];
    public $selectedLoket = null;
    public $nomorAntrian = null;
    public $showTicket = false;
    public $isLoading = false;
    public $printLoading = false;
    
    public function mount()
    {
        // Data loket/poli (dalam implementasi sebenarnya akan diambil dari database)
        $this->lokets = [
            [
                'id' => 1,
                'kode' => 'A',
                'nama' => 'Poli Anak',
                'deskripsi' => 'Layanan kesehatan untuk anak-anak dan konsultasi tumbuh kembang',
                'icon' => 'child',
                'warna' => 'blue'
            ],
            [
                'id' => 2,
                'kode' => 'B',
                'nama' => 'Poli Gigi',
                'deskripsi' => 'Loket pendaftaran layanan kesehatan gigi dan mulut',
                'icon' => 'tooth',
                'warna' => 'cyan'
            ],
            [
                'id' => 3,
                'kode' => 'C',
                'nama' => 'Poli Umum',
                'deskripsi' => 'Layanan pemeriksaan kesehatan umum dan konsultasi dokter',
                'icon' => 'medical',
                'warna' => 'green'
            ]
        ];
    }
    
    public function ambilNomor($loketId)
    {
        $this->isLoading = true;
        
        // Cari loket yang dipilih
        $loket = collect($this->lokets)->firstWhere('id', $loketId);
        $this->selectedLoket = $loket;
        
        // Generate nomor antrian (dalam implementasi sebenarnya akan menggunakan API atau database)
        $nomorUrut = rand(1, 100); // Simulasi nomor urut
        $this->nomorAntrian = [
            'kode' => $loket['kode'],
            'nomor' => $nomorUrut,
            'formatted' => $loket['kode'] . ' ' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT),
            'estimasi' => rand(10, 60), // Estimasi waktu dalam menit
            'tanggal' => now()->format('d M Y'),
            'waktu' => now()->format('H:i'),
        ];
        
        // Simulasi loading
        $this->dispatch('showTicket');
    }
    
    public function printTicket()
    {
        $this->printLoading = true;
        
        // Simulasi print (dalam implementasi sebenarnya akan memanggil fungsi print)
        $this->dispatch('printTicket');
        
        // Reset setelah 2 detik
        $this->dispatch('resetAfterPrint');
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
