<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class EditLoket extends Component
{
    public $counter_id;
    public $counter_name = '';
    public $description = '';
    public $loading = true;
    public $notFound = false;

    protected $rules = [
        'counter_name' => 'required|min:3',
        'description' => 'nullable|min:10'
    ];

    protected $messages = [
        'counter_name.required' => 'Nama counter harus diisi',
        'counter_name.min' => 'Nama counter minimal 3 karakter',
        'description.min' => 'Deskripsi minimal 10 karakter'
    ];

    public function mount($id)
    {
        $this->counter_id = $id;
        $this->loadCounter();
    }

    public function loadCounter()
    {
        try {
            $response = AuthHelper::apiRequest('GET', '/api/counters/' . $this->counter_id);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success'] && isset($data['data'])) {
                    $counter = $data['data'];
                    $this->counter_name = $counter['counter_name'];
                    $this->description = $counter['description'] ?? '';
                    $this->loading = false;
                } else {
                    $this->notFound = true;
                    $this->loading = false;
                }
            } else {
                session()->flash('error', 'Gagal mengambil data counter');
                $this->notFound = true;
                $this->loading = false;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Exception in EditLoket loadCounter: ' . $e->getMessage());
            $this->notFound = true;
            $this->loading = false;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $response = AuthHelper::apiRequest('PUT', '/api/counters/' . $this->counter_id, [
                'counter_name' => $this->counter_name,
                'description' => $this->description
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    session()->flash('message', 'Counter berhasil diperbarui!');
                    return redirect()->route('kelola.loket');
                } else {
                    session()->flash('error', $data['message'] ?? 'Gagal memperbarui counter');
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
            Log::error('Exception in EditLoket save: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('kelola.loket');
    }

    public function render()
    {
        return view('livewire.edit-loket');
    }
}
