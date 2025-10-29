<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class KelolaLoket extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'nama';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Modal states
    public $showModal = false;
    public $modalMode = 'create'; // 'create' or 'edit'
    public $selectedLoketId = null;

    // Form fields
    public $nama = '';
    public $kode = '';
    public $deskripsi = '';
    public $status = 'aktif';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalMode = 'create';
        $this->showModal = true;
    }

    public function openEditModal($loketId)
    {
        $this->selectedLoketId = $loketId;
        $this->modalMode = 'edit';
        
        // Load data (dummy data for now)
        $loket = $this->getDummyLokets()->where('id', $loketId)->first();
        if ($loket) {
            $this->nama = $loket['nama'];
            $this->kode = $loket['kode'];
            $this->deskripsi = $loket['deskripsi'];
            $this->status = $loket['status'];
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required|min:3',
            'kode' => 'required|min:1',
            'deskripsi' => 'required|min:10',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        // Simulate save (replace with actual database operations)
        if ($this->modalMode === 'create') {
            session()->flash('message', 'Loket berhasil ditambahkan!');
        } else {
            session()->flash('message', 'Loket berhasil diperbarui!');
        }

        $this->closeModal();
    }

    public function delete($loketId)
    {
        // Simulate delete (replace with actual database operations)
        session()->flash('message', 'Loket berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->nama = '';
        $this->kode = '';
        $this->deskripsi = '';
        $this->status = 'aktif';
        $this->selectedLoketId = null;
    }

    private function getDummyLokets()
    {
        return collect([
            [
                'id' => 1,
                
                'nama' => 'Poli Anak',
                'deskripsi' => 'Layanan kesehatan untuk anak-anak dan balita dengan dokter spesialis anak berpengalaman',
                
                'antrian_hari_ini' => 26,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 2,
               
                'nama' => 'Poli Gigi',
                'deskripsi' => 'Layanan kesehatan gigi dan mulut dengan peralatan modern dan dokter gigi berpengalaman',
                
                'antrian_hari_ini' => 21,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 3,
                
                'nama' => 'Poli Umum',
                'deskripsi' => 'Layanan kesehatan umum untuk berbagai keluhan dan pemeriksaan rutin',
                
                'antrian_hari_ini' => 30,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 4,
                
                'nama' => 'Poli Mata',
                'deskripsi' => 'Layanan kesehatan mata dengan dokter spesialis mata dan peralatan canggih',
                
                'antrian_hari_ini' => 16,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 5,
               
                'nama' => 'Poli Jantung',
                'deskripsi' => 'Layanan kesehatan jantung dan pembuluh darah dengan teknologi terdepan',
                
                'antrian_hari_ini' => 8,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 6,
                
                'nama' => 'Poli Kandungan',
                'deskripsi' => 'Layanan kesehatan kandungan dan kebidanan untuk ibu hamil',
                
                'antrian_hari_ini' => 0,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 7,
                
                'nama' => 'Poli THT',
                'deskripsi' => 'Layanan kesehatan telinga, hidung, dan tenggorokan',
                
                'antrian_hari_ini' => 12,
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 8,
                
                'nama' => 'Poli Kulit',
                'deskripsi' => 'Layanan kesehatan kulit dan kelamin dengan dokter spesialis dermatologi',
                
                'antrian_hari_ini' => 19,
                'created_at' => '2024-01-15 08:00:00'
            ]
        ]);
    }

    public function render()
    {
        $lokets = $this->getDummyLokets()
            ->when($this->search, function ($collection) {
                return $collection->filter(function ($loket) {
                    return stripos($loket['nama'], $this->search) !== false ||
                           
                           stripos($loket['deskripsi'], $this->search) !== false;
                });
            })
            ->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc')
            ->values();

        // Simple pagination simulation
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $this->perPage;
        $paginatedLokets = $lokets->slice($offset, $this->perPage);
        $total = $lokets->count();
        $hasPages = $total > $this->perPage;

        return view('livewire.kelola-loket', [
            'lokets' => $paginatedLokets,
            'total' => $total,
            'hasPages' => $hasPages,
            'currentPage' => $currentPage,
            'perPage' => $this->perPage
        ]);
    }
}
