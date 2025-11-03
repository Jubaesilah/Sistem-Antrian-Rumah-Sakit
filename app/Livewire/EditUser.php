<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class EditUser extends Component
{
    public $user_id;
    public $full_name = '';
    public $email = '';
    public $role = 'petugas';
    public $counter_id = '';
    
    // Counter list for dropdown
    public $counters = [];
    
    // Loading states
    public $loading = true;
    public $notFound = false;

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

    public function mount($id)
    {
        $this->user_id = $id;
        $this->loadCounters();
        $this->loadUser();
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

    public function loadUser()
    {
        try {
            $response = AuthHelper::apiRequest('GET', '/api/users/' . $this->user_id);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success'] && isset($data['data'])) {
                    $user = $data['data'];
                    $this->full_name = $user['full_name'];
                    $this->email = $user['email'];
                    $this->role = $user['role'];
                    $this->counter_id = $user['counter_id'];
                    $this->loading = false;
                } else {
                    $this->notFound = true;
                    $this->loading = false;
                }
            } else {
                $this->notFound = true;
                $this->loading = false;
            }
        } catch (\Exception $e) {
            $this->notFound = true;
            $this->loading = false;
            Log::error('Exception in loadUser: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $response = AuthHelper::apiRequest('PUT', '/api/users/' . $this->user_id, [
                'full_name' => $this->full_name,
                'email' => $this->email,
                'role' => $this->role,
                'counter_id' => $this->counter_id
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success']) {
                    session()->flash('message', 'User berhasil diperbarui!');
                    return redirect()->route('kelola.user');
                } else {
                    session()->flash('error', $data['message'] ?? 'Gagal memperbarui user');
                }
            } else {
                // Handle validation errors from API
                $errorData = $response->json();
                
                if (isset($errorData['errors'])) {
                    foreach ($errorData['errors'] as $field => $messages) {
                        $this->addError($field, is_array($messages) ? $messages[0] : $messages);
                    }
                } else {
                    session()->flash('error', $errorData['message'] ?? 'Gagal memperbarui user');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Exception in update: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.edit-user');
    }
}
