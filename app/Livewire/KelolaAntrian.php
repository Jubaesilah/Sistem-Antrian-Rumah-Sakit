<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class KelolaAntrian extends Component
{
    public $counterId;
    public $counterName = '';
    public $search = '';
    public $sortBy = 'queue_number';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $pollingInterval = 3; // Auto-refresh every 3 seconds
    public $isLoading = false;
    public $lastUpdate;

    // API Data
    public $currentlyCalled = null;
    public $queues = [];
    public $pagination = [];
    public $apiError = null;

    protected $listeners = ['refreshAntrian' => 'loadQueues'];

    public function mount()
    {
        // Set polling interval dari config atau default 5 detik
        $this->pollingInterval = config('api.polling_interval', 5);

        // Get counter_id from logged in user
        $user = AuthHelper::getUser();
        $this->counterId = $user['counter_id'] ?? null;

        if (!$this->counterId) {
            $this->apiError = 'User tidak memiliki counter yang ditugaskan';
            return;
        }

        $this->loadCounter();
        $this->loadQueues();
    }

    public function loadCounter()
    {
        if (!$this->counterId) {
            return;
        }

        try {
            $response = AuthHelper::apiRequest('GET', '/api/counters/' . $this->counterId);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success']) {
                    $this->counterName = $data['data']['counter_name'] ?? '';
                } else {
                    Log::warning('Failed to load counter: ' . ($data['message'] ?? 'Unknown error'));
                }
            } else {
                Log::error('Failed to fetch counter', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('Exception in loadCounter: ' . $e->getMessage());
        }
    }

    public function loadQueues()
    {
        if (!$this->counterId) {
            return;
        }

        $this->isLoading = true;

        try {
            $response = AuthHelper::apiRequest('GET', '/api/queues', [
                'counter_id' => $this->counterId,
                'per_page' => $this->perPage,
                'page' => $this->pagination['current_page'] ?? 1,
                'search' => $this->search,
                'sort_by' => $this->sortBy,
                'sort_order' => $this->sortDirection
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success']) {
                    $this->currentlyCalled = $data['data']['currently_called'];
                    $this->queues = $data['data']['queues'];
                    $this->pagination = $data['data']['pagination'];
                    $this->apiError = null;
                } else {
                    $this->apiError = $data['message'] ?? 'Gagal memuat data antrian';
                }
            } else {
                $this->apiError = 'Gagal terhubung ke server';
                Log::error('Failed to load queues', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            $this->apiError = 'Terjadi kesalahan: ' . $e->getMessage();
            Log::error('Exception in loadQueues: ' . $e->getMessage());
        }

        $this->lastUpdate = now()->format('H:i:s');
        $this->isLoading = false;
    }

    public function updatingSearch()
    {
        $this->loadQueues();
    }

    public function updatedPerPage()
    {
        $this->loadQueues();
    }

    public function sortByField($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }

        $this->loadQueues();
    }

    public function gotoPage($page)
    {
        $this->pagination['current_page'] = $page;
        $this->loadQueues();
    }

    public function callQueue($queueId)
    {
        try {
            $response = AuthHelper::apiRequest('PATCH', '/api/queues/' . $queueId, [
                'status' => 'called'
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success']) {
                    $this->loadQueues();

                    // Dispatch event untuk notifikasi suara
                    $queue = $data['data'];
                    $this->dispatch('queue-called', [
                        'queue_number' => $queue['queue_number'],
                        'counter_name' => $queue['counter']['counter_name'] ?? ''
                    ]);

                    $this->dispatch('queue-call-success', [
                        'message' => 'Antrian berhasil dipanggil'
                    ]);
                } else {
                    $this->dispatch('queue-call-failed', [
                        'message' => $data['message'] ?? 'Gagal memanggil antrian'
                    ]);
                }
            } else {
                $this->dispatch('queue-call-failed', [
                    'message' => 'Gagal terhubung ke server'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('queue-call-failed', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            Log::error('Exception in callQueue: ' . $e->getMessage());
        }
    }

    public function completeQueue($queueId)
    {
        try {
            $response = AuthHelper::apiRequest('PATCH', '/api/queues/' . $queueId, [
                'status' => 'done'
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success']) {
                    $this->loadQueues();
                    $this->dispatch('queue-complete-success', [
                        'message' => 'Antrian berhasil diselesaikan'
                    ]);
                } else {
                    $this->dispatch('queue-complete-failed', [
                        'message' => $data['message'] ?? 'Gagal menyelesaikan antrian'
                    ]);
                }
            } else {
                $this->dispatch('queue-complete-failed', [
                    'message' => 'Gagal terhubung ke server'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('queue-complete-failed', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            Log::error('Exception in completeQueue: ' . $e->getMessage());
        }
    }


    /**
     * Method untuk di-trigger oleh wire:poll
     * Akan dipanggil otomatis setiap X detik
     */
    public function refreshQueue()
    {
        $this->loadQueues();
    }

    /**
     * Method untuk manual refresh (jika diperlukan)
     */
    public function manualRefresh()
    {
        $this->loadQueues();
        $this->dispatch('queue-refreshed');
    }

    public function render()
    {
        return view('livewire.kelola-antrian');
    }
}
