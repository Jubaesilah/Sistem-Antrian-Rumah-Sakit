<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class KelolaLoket extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    // API data
    public $counters = [];
    public $pagination = [];
    public $apiError = null;


    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->loadCounters();
    }

    public function updatingSearch()
    {
        $this->loadCounters();
    }

    public function updatingPerPage()
    {
        $this->loadCounters();
    }
    
    public function updatingSortBy()
    {
        $this->loadCounters();
    }
    
    public function updatingSortDirection()
    {
        $this->loadCounters();
    }

    public function sortByField($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->loadCounters();
    }
    
    public function loadCounters()
    {
        try {
            $page = request()->get('page', 1);
            
            $response = AuthHelper::apiRequest('GET', '/api/counters', [
                'per_page' => $this->perPage,
                'page' => $page,
                'search' => $this->search,
                'sort_by' => $this->sortBy,
                'sort_order' => $this->sortDirection
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success'] && isset($data['data'])) {
                    $this->counters = $data['data']['counters'];
                    $this->pagination = $data['data']['pagination'];
                    $this->apiError = null;
                } else {
                    $this->apiError = $data['message'] ?? 'Gagal mengambil data';
                }
            } else {
                $this->apiError = 'Gagal terhubung ke server: ' . $response->status();
                Log::error('API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            $this->apiError = 'Terjadi kesalahan: ' . $e->getMessage();
            Log::error('Exception in loadCounters: ' . $e->getMessage());
        }
    }


    public function delete($counterId)
    {
        try {
            Log::info('Attempting to delete counter: ' . $counterId);
            
            $response = AuthHelper::apiRequest('DELETE', '/api/counters/' . $counterId);
            
            Log::info('Delete response status: ' . $response->status());
            Log::info('Delete response body: ' . $response->body());
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    // Reload data from API
                    $this->loadCounters();
                    
                    // Flash success message
                    session()->flash('message', 'Counter berhasil dihapus!');
                    
                    // Dispatch browser event to show notification
                    $this->dispatch('counter-deleted');
                    
                    Log::info('Counter deleted successfully: ' . $counterId);
                } else {
                    $errorMsg = $data['message'] ?? 'Gagal menghapus counter';
                    session()->flash('error', $errorMsg);
                    $this->dispatch('counter-delete-failed', message: $errorMsg);
                    Log::error('Delete failed: ' . $errorMsg);
                }
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Gagal terhubung ke server: ' . $response->status();
                session()->flash('error', $errorMessage);
                $this->dispatch('counter-delete-failed', message: $errorMessage);
                Log::error('Delete API Error - Status: ' . $response->status() . ', Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
            $this->dispatch('counter-delete-failed', message: $errorMessage);
            Log::error('Exception in delete: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    public function gotoPage($page)
    {
        $this->loadCounters();
    }

    public function render()
    {
        return view('livewire.kelola-loket');
    }
}
