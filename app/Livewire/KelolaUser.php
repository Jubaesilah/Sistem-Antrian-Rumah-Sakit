<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class KelolaUser extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    // API data
    public $users = [];
    public $pagination = [];
    public $apiError = null;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->loadUsers();
    }

    public function updatingSearch()
    {
        $this->loadUsers();
    }

    public function updatingPerPage()
    {
        $this->loadUsers();
    }
    
    public function updatingSortBy()
    {
        $this->loadUsers();
    }
    
    public function updatingSortDirection()
    {
        $this->loadUsers();
    }

    public function sortByField($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->loadUsers();
    }
    
    public function loadUsers()
    {
        try {
            $page = request()->get('page', 1);
            
            $response = AuthHelper::apiRequest('GET', '/api/users', [
                'per_page' => $this->perPage,
                'page' => $page,
                'search' => $this->search,
                'sort_by' => $this->sortBy,
                'sort_order' => $this->sortDirection
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success'] && isset($data['data'])) {
                    $this->users = $data['data']['users'];
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
            Log::error('Exception in loadUsers: ' . $e->getMessage());
        }
    }


    public function delete($userId)
    {
        try {
            Log::info('Attempting to delete user: ' . $userId);
            
            $response = AuthHelper::apiRequest('DELETE', '/api/users/' . $userId);
            
            Log::info('Delete response status: ' . $response->status());
            Log::info('Delete response body: ' . $response->body());
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    // Reload data from API
                    $this->loadUsers();
                    
                    // Flash success message
                    session()->flash('message', 'User berhasil dihapus!');
                    
                    // Dispatch browser event to show notification
                    $this->dispatch('user-deleted');
                    
                    Log::info('User deleted successfully: ' . $userId);
                } else {
                    $errorMsg = $data['message'] ?? 'Gagal menghapus user';
                    session()->flash('error', $errorMsg);
                    $this->dispatch('user-delete-failed', message: $errorMsg);
                    Log::error('Delete failed: ' . $errorMsg);
                }
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Gagal terhubung ke server: ' . $response->status();
                session()->flash('error', $errorMessage);
                $this->dispatch('user-delete-failed', message: $errorMessage);
                Log::error('Delete API Error - Status: ' . $response->status() . ', Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
            $this->dispatch('user-delete-failed', message: $errorMessage);
            Log::error('Exception in delete: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    public function gotoPage($page)
    {
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.kelola-user');
    }
}
