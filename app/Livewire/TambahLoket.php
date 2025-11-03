<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class TambahLoket extends Component
{
    public $counter_name = '';
    public $description = '';

    protected $rules = [
        'counter_name' => 'required|min:3',
        'description' => 'nullable|min:10'
    ];

    protected $messages = [
        'counter_name.required' => 'Nama counter harus diisi',
        'counter_name.min' => 'Nama counter minimal 3 karakter',
        'description.min' => 'Deskripsi minimal 10 karakter'
    ];

    public function save()
    {
        $this->validate();

        try {
            $response = AuthHelper::apiRequest('POST', '/api/counters', [
                'counter_name' => $this->counter_name,
                'description' => $this->description
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    session()->flash('message', 'Counter berhasil ditambahkan!');
                    return redirect()->route('kelola.loket');
                } else {
                    session()->flash('error', $data['message'] ?? 'Gagal menambahkan counter');
                }
            } else {
                $errorData = $response->json();
                if (isset($errorData['errors'])) {
                    // Handle validation errors from API
                    foreach ($errorData['errors'] as $field => $messages) {
                        $this->addError($field, is_array($messages) ? $messages[0] : $messages);
                    }
                } else {
                    session()->flash('error', 'Gagal terhubung ke server: ' . $response->status());
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Exception in TambahLoket save: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('kelola.loket');
    }

    public function render()
    {
        return view('livewire.tambah-loket');
    }
}
