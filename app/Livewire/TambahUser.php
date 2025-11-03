<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class TambahUser extends Component
{
    public $full_name = '';
    public $email = '';
    public $role = 'petugas';
    public $counter_id = '';
    
    // Counter list for dropdown
    public $counters = [];

    protected $rules = [
        'full_name' => 'required|min:3',
        'email' => 'required|email',
        'role' => 'required|in:admin,petugas',
        'counter_id' => 'required'
    ];

    protected $messages = [
        'full_name.required' => 'Nama lengkap harus diisi',
        'full_name.min' => 'Nama lengkap minimal 3 karakter',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'role.required' => 'Role harus dipilih',
        'role.in' => 'Role tidak valid',
        'counter_id.required' => 'Counter harus dipilih'
    ];

    public function mount()
    {
        $this->loadCounters();
    }

    public function loadCounters()
    {
        try {
            $response = AuthHelper::apiRequest('GET', '/api/counters/list');
            
            if ($response->successful()) {
                $data = $response->json();
                if ($data['success'] && isset($data['data'])) {
                    $this->counters = $data['data'];
                }
            }
        } catch (\Exception $e) {
            Log::error('Exception in loadCounters: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $response = AuthHelper::apiRequest('POST', '/api/users', [
                'full_name' => $this->full_name,
                'email' => $this->email,
                'role' => $this->role,
                'counter_id' => $this->counter_id
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success']) {
                    session()->flash('message', 'User berhasil ditambahkan! Email verifikasi telah dikirim.');
                    return redirect()->route('kelola.user');
                } else {
                    session()->flash('error', $data['message'] ?? 'Gagal menambahkan user');
                }
            } else {
                // Handle validation errors from API
                $errorData = $response->json();
                
                if (isset($errorData['errors'])) {
                    foreach ($errorData['errors'] as $field => $messages) {
                        $this->addError($field, is_array($messages) ? $messages[0] : $messages);
                    }
                } else {
                    session()->flash('error', $errorData['message'] ?? 'Gagal menambahkan user');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Exception in save: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.tambah-user');
    }
}
