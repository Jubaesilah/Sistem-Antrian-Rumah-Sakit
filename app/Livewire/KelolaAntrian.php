<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class KelolaAntrian extends Component
{
    use WithPagination;

    public $loketId = 1;
    public $loket;
    public $search = '';
    public $antrianDipanggil = null;
    public $lokets = [];
    public $antrians = [];
    public $perPage = 10;
    public $currentPage = 1;
    
    protected $listeners = ['refreshAntrian' => '$refresh'];
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Data dummy loket
        $this->lokets = [
            [
                'id' => 1,
                'kode' => 'A',
                'nama' => 'Poli Anak',
                'deskripsi' => 'Layanan kesehatan untuk anak-anak dan konsultasi tumbuh kembang',
                'status' => 'aktif'
            ],
            [
                'id' => 2,
                'kode' => 'B',
                'nama' => 'Poli Gigi',
                'deskripsi' => 'Loket pendaftaran layanan kesehatan gigi dan mulut',
                'status' => 'aktif'
            ],
            [
                'id' => 3,
                'kode' => 'C',
                'nama' => 'Poli Umum',
                'deskripsi' => 'Layanan pemeriksaan kesehatan umum dan konsultasi dokter',
                'status' => 'aktif'
            ]
        ];
        
        // Set loket default
        $this->loket = collect($this->lokets)->firstWhere('id', $this->loketId);
        
        // Data dummy antrian
        $this->generateDummyAntrian();
    }

    private function generateDummyAntrian()
    {
        $this->antrians = [];
        
        // Generate antrian untuk setiap loket
        foreach ($this->lokets as $loket) {
            $kode = $loket['kode'];
            
            // Antrian menunggu
            for ($i = 1; $i <= 15; $i++) {
                $this->antrians[] = [
                    'id' => $kode . $i,
                    'nomor_antrian' => $kode . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'loket_id' => $loket['id'],
                    'status' => 'menunggu',
                    'nama_pasien' => $this->generateRandomName(),
                    'jenis_layanan' => $this->getRandomLayanan($loket['nama']),
                    'created_at' => now()->subMinutes(rand(5, 120)),
                    'waktu_panggil' => null,
                    'waktu_selesai' => null
                ];
            }
            
            // Antrian dipanggil (1 per loket)
            if ($loket['id'] == $this->loketId) {
                $this->antrianDipanggil = [
                    'id' => $kode . '100',
                    'nomor_antrian' => $kode . '100',
                    'loket_id' => $loket['id'],
                    'status' => 'dipanggil',
                    'nama_pasien' => $this->generateRandomName(),
                    'jenis_layanan' => $this->getRandomLayanan($loket['nama']),
                    'created_at' => now()->subMinutes(30),
                    'waktu_panggil' => now()->subMinutes(5),
                    'waktu_selesai' => null
                ];
            }
        }
    }
    
    private function generateRandomName()
    {
        $firstNames = ['Ahmad', 'Budi', 'Cindy', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hana', 'Irfan', 'Joko', 'Kartika', 'Lina'];
        $lastNames = ['Saputra', 'Wijaya', 'Susanto', 'Hartono', 'Pratama', 'Sari', 'Putra', 'Santoso', 'Wati', 'Hidayat'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }
    
    private function getRandomLayanan($poliName)
    {
        $layanan = [
            'Poli Anak' => ['Imunisasi', 'Konsultasi Tumbuh Kembang', 'Pemeriksaan Rutin', 'Konsultasi Gizi Anak'],
            'Poli Gigi' => ['Pembersihan Karang Gigi', 'Tambal Gigi', 'Cabut Gigi', 'Konsultasi Gigi'],
            'Poli Umum' => ['Pemeriksaan Umum', 'Medical Check-up', 'Konsultasi Kesehatan', 'Pemeriksaan Tekanan Darah']
        ];
        
        $availableLayanan = $layanan[$poliName] ?? ['Pemeriksaan Umum'];
        return $availableLayanan[array_rand($availableLayanan)];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function panggilAntrian($antrianId)
    {
        // Cari antrian berdasarkan ID
        $index = collect($this->antrians)->search(function($antrian) use ($antrianId) {
            return $antrian['id'] == $antrianId;
        });
        
        if ($index !== false) {
            // Simpan antrian yang akan dipanggil
            $antrian = $this->antrians[$index];
            
            // Update status antrian menjadi dipanggil
            $antrian['status'] = 'dipanggil';
            $antrian['waktu_panggil'] = now();
            
            // Hapus dari array antrian
            unset($this->antrians[$index]);
            
            // Set sebagai antrian yang sedang dipanggil
            $this->antrianDipanggil = $antrian;
            
            // Dispatch event untuk notifikasi suara
            $this->dispatch('antrianDipanggil', [
                'nomor' => $antrian['nomor_antrian'],
                'loket' => $this->loket['nama']
            ]);
        }
    }

    public function selesaikanAntrian()
    {
        if ($this->antrianDipanggil) {
            // Update status antrian menjadi selesai
            $this->antrianDipanggil['status'] = 'selesai';
            $this->antrianDipanggil['waktu_selesai'] = now();
            
            // Hapus dari antrian yang sedang dipanggil
            $this->antrianDipanggil = null;
        }
    }

    public function pilihLoket($loketId)
    {
        $this->loketId = $loketId;
        $this->loket = collect($this->lokets)->firstWhere('id', (int)$loketId);
        $this->resetPage();
        
        // Reset antrian yang sedang dipanggil
        $this->antrianDipanggil = null;
        
        // Generate ulang data dummy untuk loket baru
        $this->generateDummyAntrian();
    }
    
    private function getAntrianMenunggu()
    {
        // Filter antrian menunggu untuk loket yang dipilih
        $filtered = collect($this->antrians)->filter(function($antrian) {
            return $antrian['status'] === 'menunggu' && 
                  $antrian['loket_id'] === $this->loketId &&
                  (empty($this->search) || 
                   stripos($antrian['nomor_antrian'], $this->search) !== false ||
                   stripos($antrian['nama_pasien'], $this->search) !== false);
        })->sortBy('created_at')->values();
        
        // Buat paginator manual
        $page = $this->currentPage;
        $perPage = $this->perPage;
        $items = $filtered->slice(($page - 1) * $perPage, $perPage)->values();
        
        return new LengthAwarePaginator(
            $items,
            $filtered->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function render()
    {
        $antrianMenunggu = $this->getAntrianMenunggu();
        
        return view('livewire.kelola-antrian', [
            'antrianDipanggil' => $this->antrianDipanggil,
            'antrianMenunggu' => $antrianMenunggu,
            'lokets' => $this->lokets
        ]);
    }
}
