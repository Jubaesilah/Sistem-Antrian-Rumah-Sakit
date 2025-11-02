<div>
<div class="min-h-screen bg-gray-50 flex flex-col">
    <div class="w-full bg-white shadow-lg overflow-hidden">
        <!-- Header Component -->
        <x-header :currentTime="now()->format('H:i:s')" 
                  :currentDate="now()->locale('id')->isoFormat('DD MMMM YYYY')" />
    </div>
    
    <!-- Error/Success Messages -->
    @if(session()->has('error'))
    <div class="mx-8 mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
        <p class="font-bold">Error</p>
        <p>{{ session('error') }}</p>
    </div>
    @endif
    
    @if(session()->has('success'))
    <div class="mx-8 mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p class="font-bold">Berhasil</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    @if($apiError)
    <div class="mx-8 mt-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">Perhatian</p>
        <p>Menggunakan data fallback karena API tidak tersedia</p>
    </div>
    @endif
    
    <!-- Main Content - White Background for Full Height -->
    <div class="flex-grow bg-white flex flex-col">
        <div class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
                <!-- Page Title -->
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Ambil Nomor Antrian</h1>
                    <p class="mt-3 text-lg text-gray-500">Silahkan pilih loket sesuai dengan kebutuhan Anda</p>
                </div>

                <!-- Loket Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-12">
                @foreach($lokets as $loket)
                    <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl hover:shadow-md transition-shadow duration-300">
                        <div class="p-6 flex flex-col h-full">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-{{ $loket['warna'] }}-100">
                                        <!-- Medical/Hospital Icon -->
                                        <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $loket['nama'] }}</h3>
                                </div>
                            </div>
                            
                            <div class="flex-grow mb-6">
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $loket['deskripsi'] }}</p>
                            </div>
                            
                            <div class="mt-auto">
                                <button 
                                    wire:click="ambilNomor('{{ $loket['id'] }}')" 
                                    wire:loading.attr="disabled"
                                    wire:target="ambilNomor"
                                    class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span wire:loading.remove wire:target="ambilNomor" class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                        Ambil Nomor Antrian
                                    </span>
                                    <span wire:loading wire:target="ambilNomor" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div class="mt-auto py-6 bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} Rumah Sakit Sehat Selalu. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Modal -->    
    @if($showTicket && $nomorAntrian)
    <div 
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal Panel -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <!-- Ticket Container -->
                <div class="ticket-container bg-white px-6 py-8">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Nomor Antrian Anda</h3>
                        <p class="mt-2 text-sm text-gray-500">Silakan tunggu nomor Anda dipanggil</p>
                    </div>

                    <!-- Queue Number -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-8 mb-6">
                        <div class="text-center">
                            <div class="text-6xl font-black text-white mb-2">
                                {{ $nomorAntrian['formatted'] }}
                            </div>
                            <div class="text-white text-sm opacity-90">
                                {{ $nomorAntrian['loket'] ?? $selectedLoket['nama'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tanggal:</span>
                            <span class="font-medium text-gray-900">{{ $nomorAntrian['tanggal'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Waktu:</span>
                            <span class="font-medium text-gray-900">{{ $nomorAntrian['waktu'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Estimasi Tunggu:</span>
                            <span class="font-medium text-gray-900">{{ $nomorAntrian['estimasi'] }} menit</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button 
                            wire:click="closeTicket"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            OK, Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        /* Line Clamp Styles */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>
</div>