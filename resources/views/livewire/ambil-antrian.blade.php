<x-layouts.sidebar title="Ambil Nomor Antrian">
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
                                        @if($loket['icon'] === 'child')
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @elseif($loket['icon'] === 'tooth')
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        @elseif($loket['icon'] === 'medical')
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        @elseif($loket['icon'] === 'eye')
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        @elseif($loket['icon'] === 'heart')
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        @elseif($loket['icon'] === 'baby')
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-{{ $loket['warna'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
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
                                    wire:click="ambilNomor({{ $loket['id'] }})" 
                                    wire:loading.attr="disabled"
                                    wire:target="ambilNomor({{ $loket['id'] }})"
                                    class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150"
                                >
                                    <span wire:loading.remove wire:target="ambilNomor({{ $loket['id'] }})">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                        Ambil Nomor Antrian
                                    </span>
                                    <span wire:loading wire:target="ambilNomor({{ $loket['id'] }})">
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
    <div 
        x-data="{ 
            showTicket: false,
            printLoading: false,
            init() {
                window.addEventListener('showTicket', () => {
                    this.showTicket = true;
                });
                window.addEventListener('printTicket', () => {
                    this.printLoading = true;
                    setTimeout(() => {
                        window.print();
                    }, 500);
                });
                window.addEventListener('resetAfterPrint', () => {
                    setTimeout(() => {
                        this.printLoading = false;
                    }, 2000);
                });
            }
        }" 
        x-show="showTicket" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <!-- Modal content -->
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .ticket-container, .ticket-container * {
                visibility: visible;
            }
            .ticket-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }
        }
        
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Line Clamp Styles */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <!-- Alpine.js for Modal -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-layouts.sidebar>