<x-layouts.sidebar title="Kelola Antrian - Rumah Sakit Sehat Selalu">
    <div class="flex-grow flex flex-col" 
         wire:loading.class="opacity-95">
        <div class="flex-grow px-4 sm:px-6 lg:px-8 py-8 w-full">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Kelola Antrian</h1>
                        <p class="mt-2 text-sm text-gray-600">Kelola antrian pasien untuk loket yang aktif</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Last Update -->
                        @if($lastUpdate)
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Update terakhir:</span> {{ $lastUpdate }}
                            </div>
                        @endif
                        
                        <!-- Manual Refresh Button -->
                        <button 
                            wire:click="manualRefresh"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- API Error Message -->
            @if($apiError)
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ $apiError }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Counter Info -->
            @if($counterName)
                <div class="mb-6 bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $counterName }}</h2>
                            <p class="text-sm text-gray-500">Counter tempat Anda bertugas</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Antrian Sedang Dipanggil -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Sedang Dipanggil</h2>
                
                @if($currentlyCalled)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="mb-4 sm:mb-0">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Nomor Antrian</p>
                                        <p class="text-3xl font-bold text-blue-800">{{ $currentlyCalled['queue_number'] }}</p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Status: <span class="font-semibold">{{ ucfirst($currentlyCalled['status']) }}</span>
                                        </p>
                                        @if($currentlyCalled['called_at'])
                                            <p class="text-xs text-gray-400 mt-1">
                                                Dipanggil: {{ \Carbon\Carbon::parse($currentlyCalled['called_at'])->format('H:i:s') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button 
                                    wire:click="completeQueue('{{ $currentlyCalled['queue_id'] }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="completeQueue('{{ $currentlyCalled['queue_id'] }}')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span wire:loading.remove wire:target="completeQueue('{{ $currentlyCalled['queue_id'] }}')">Selesai</span>
                                    <span wire:loading wire:target="completeQueue('{{ $currentlyCalled['queue_id'] }}')">Memproses...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada antrian yang sedang dipanggil</p>
                    </div>
                @endif
            </div>

            <!-- Daftar Antrian Menunggu -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Antrian Menunggu</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Antrian yang sedang menunggu untuk dipanggil</p>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                wire:model.live.debounce.300ms="search"
                                type="text" 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                placeholder="Cari antrian...">
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200">
                    @if(!empty($queues) && count($queues) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. Antrian
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pasien
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Counter
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu Daftar
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($queues as $queue)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">{{ $queue['queue_number'] }}</div>
                                                    @if($queue['status'] === 'called')
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            Dipanggil
                                                        </span>
                                                    @else
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Menunggu
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">-</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $queue['counter']['counter_name'] ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($queue['created_at'])->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($queue['status'] === 'waiting')
                                                    <button 
                                                        wire:click="callQueue('{{ $queue['queue_id'] }}')"
                                                        wire:loading.attr="disabled"
                                                        wire:target="callQueue('{{ $queue['queue_id'] }}')"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                                        </svg>
                                                        <span wire:loading.remove wire:target="callQueue('{{ $queue['queue_id'] }}')">Panggil</span>
                                                        <span wire:loading wire:target="callQueue('{{ $queue['queue_id'] }}')">Memanggil...</span>
                                                    </button>
                                                @else
                                                    <span class="text-gray-400 text-xs">Sedang dipanggil</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if(!empty($pagination) && $pagination['total'] > $pagination['per_page'])
                            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing <span class="font-medium">{{ $pagination['from'] ?? 0 }}</span> to <span class="font-medium">{{ $pagination['to'] ?? 0 }}</span> of <span class="font-medium">{{ $pagination['total'] ?? 0 }}</span> results
                                        </p>
                                    </div>
                                    <div>
                                        @php
                                            $currentPage = $pagination['current_page'] ?? 1;
                                            $lastPage = $pagination['last_page'] ?? 1;
                                        @endphp
                                        
                                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                            @if($currentPage > 1)
                                                <button wire:click="gotoPage({{ $currentPage - 1 }})" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    Previous
                                                </button>
                                            @endif
                                            
                                            @for($page = 1; $page <= $lastPage; $page++)
                                                @if($page == $currentPage)
                                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-600 text-sm font-medium text-white">{{ $page }}</span>
                                                @else
                                                    <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ $page }}</button>
                                                @endif
                                            @endfor
                                            
                                            @if($currentPage < $lastPage)
                                                <button wire:click="gotoPage({{ $currentPage + 1 }})" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    Next
                                                </button>
                                            @endif
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada antrian yang menunggu</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-auto py-6 bg-white border-t border-gray-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} Rumah Sakit Sehat Selalu. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Play sound when a queue is called
        window.addEventListener('queue-called', (event) => {
            // Buat suara notifikasi
            const audio = new Audio('/sounds/notification.mp3');
            audio.play().catch(e => console.log('Audio play failed:', e));
            
            // Tampilkan notifikasi
            const queueNumber = event.detail.queue_number;
            const counterName = event.detail.counter_name;
            
            // Notifikasi browser jika diizinkan
            if (Notification.permission === 'granted') {
                new Notification('Panggilan Antrian', {
                    body: `Nomor antrian ${queueNumber} silahkan ke ${counterName}`,
                    icon: '/images/logo.png'
                });
            }
        });
        
        // Success/Error handlers
        window.addEventListener('queue-call-success', (event) => {
            console.log('Queue called successfully:', event.detail.message);
        });
        
        window.addEventListener('queue-call-failed', (event) => {
            alert('Error: ' + event.detail.message);
        });
        
        window.addEventListener('queue-complete-success', (event) => {
            console.log('Queue completed successfully:', event.detail.message);
        });
        
        window.addEventListener('queue-complete-failed', (event) => {
            alert('Error: ' + event.detail.message);
        });
        });

        // Minta izin notifikasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                Notification.requestPermission();
            }
        });
    </script>
    @endpush
</x-layouts.sidebar>
