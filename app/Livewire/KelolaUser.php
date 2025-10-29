<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class KelolaUser extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'nama';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Modal states
    public $showModal = false;
    public $modalMode = 'create'; // 'create' or 'edit'
    public $selectedUserId = null;

    // Form fields
    public $nama = '';
    public $email = '';
    public $role = 'staff';
    public $telepon = '';
    public $terverifikasi = false;
    public $loket_ditugaskan = '';

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

    public function openEditModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->modalMode = 'edit';
        
        // Load data (dummy data for now)
        $user = $this->getDummyUsers()->where('id', $userId)->first();
        if ($user) {
            $this->nama = $user['nama'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            $this->telepon = $user['telepon'];
            $this->terverifikasi = $user['terverifikasi'];
            $this->loket_ditugaskan = $user['loket_ditugaskan'];
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
            'email' => 'required|email',
            'role' => 'required|in:admin,staff,dokter',
            'telepon' => 'required|min:10',
            'loket_ditugaskan' => 'nullable'
        ]);

        // Simulate save (replace with actual database operations)
        if ($this->modalMode === 'create') {
            session()->flash('message', 'User berhasil ditambahkan!');
        } else {
            session()->flash('message', 'User berhasil diperbarui!');
        }

        $this->closeModal();
    }

    public function delete($userId)
    {
        // Simulate delete (replace with actual database operations)
        session()->flash('message', 'User berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->nama = '';
        $this->email = '';
        $this->role = 'staff';
        $this->telepon = '';
        $this->terverifikasi = false;
        $this->loket_ditugaskan = '';
        $this->selectedUserId = null;
    }

    private function getDummyUsers()
    {
        return collect([
            [
                'id' => 1,
                'nama' => 'Dr. Ahmad Wijaya',
                'email' => 'ahmad.wijaya@rs-sehat.com',
                'role' => 'dokter',
                'telepon' => '081234567890',
                'terverifikasi' => true,
                'loket_ditugaskan' => 'Poli Anak',
                'created_at' => '2024-01-15 08:00:00'
            ],
            [
                'id' => 2,
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@rs-sehat.com',
                'role' => 'staff',
                'telepon' => '081234567891',
                'terverifikasi' => true,
                'loket_ditugaskan' => 'Poli Gigi',
                'created_at' => '2024-01-16 08:00:00'
            ],
            [
                'id' => 3,
                'nama' => 'Dr. Rina Wulandari',
                'email' => 'rina.wulandari@rs-sehat.com',
                'role' => 'dokter',
                'telepon' => '081234567892',
                'created_at' => '2024-01-17 08:00:00'
            ],
            [
                'id' => 4,
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@rs-sehat.com',
                'role' => 'admin',
                'telepon' => '081234567893',
                'created_at' => '2024-01-18 08:00:00'
            ],
            [
                'id' => 5,
                'nama' => 'Dr. Maya Sari',
                'email' => 'maya.sari@rs-sehat.com',
                'role' => 'dokter',
                'telepon' => '081234567894',
                'created_at' => '2024-01-19 08:00:00'
            ],
            [
                'id' => 6,
                'nama' => 'Andi Pratama',
                'email' => 'andi.pratama@rs-sehat.com',
                'role' => 'staff',
                'telepon' => '081234567895',
                'created_at' => '2024-01-20 08:00:00'
            ],
            [
                'id' => 7,
                'nama' => 'Dr. Indra Gunawan',
                'email' => 'indra.gunawan@rs-sehat.com',
                'role' => 'dokter',
                'telepon' => '081234567896',
                'created_at' => '2024-01-21 08:00:00'
            ],
            [
                'id' => 8,
                'nama' => 'Lisa Permata',
                'email' => 'lisa.permata@rs-sehat.com',
                'role' => 'staff',
                'telepon' => '081234567897',
                'created_at' => '2024-01-22 08:00:00'
            ],
            [
                'id' => 9,
                'nama' => 'Dr. Fajar Ramadhan',
                'email' => 'fajar.ramadhan@rs-sehat.com',
                'role' => 'dokter',
                'telepon' => '081234567898',
                'created_at' => '2024-01-23 08:00:00'
            ],
            [
                'id' => 10,
                'nama' => 'Dewi Kartika',
                'email' => 'dewi.kartika@rs-sehat.com',
                'role' => 'admin',
                'telepon' => '081234567899',
                'created_at' => '2024-01-24 08:00:00'
            ]
        ]);
    }

    public function render()
    {
        $users = $this->getDummyUsers()
            ->when($this->search, function ($collection) {
                return $collection->filter(function ($user) {
                    return stripos($user['nama'], $this->search) !== false ||
                           stripos($user['email'], $this->search) !== false ||
                           stripos($user['role'], $this->search) !== false;
                });
            })
            ->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc')
            ->values();

        // Simple pagination simulation
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $this->perPage;
        $paginatedUsers = $users->slice($offset, $this->perPage);
        $total = $users->count();
        $hasPages = $total > $this->perPage;

        return view('livewire.kelola-user', [
            'users' => $paginatedUsers,
            'total' => $total,
            'hasPages' => $hasPages,
            'currentPage' => $currentPage,
            'perPage' => $this->perPage
        ]);
    }
}
