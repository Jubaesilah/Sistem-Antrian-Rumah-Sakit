<div>
@section('title', 'Display Antrian')

{{-- Wire Poll: Auto refresh setiap 3 detik --}}
<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4" 
     wire:poll.{{ $pollingInterval }}s="refreshQueue"
     wire:loading.class="opacity-95">
    <div class="w-full max-w-7xl bg-white rounded-lg shadow-2xl overflow-hidden">
        <!-- Header dengan Logo dan Waktu -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                    </svg>
                </div>
                <div class="text-white">
                    <h1 class="text-2xl font-bold">Rumah Sakit Sehat Selalu</h1>
                    <p class="text-sm opacity-90">Sistem Antrian Rumah Sakit</p>
                </div>
            </div>
            <div class="text-right text-white">
                <div class="text-3xl font-bold" id="clock">{{ $currentTime }}</div>
                <div class="text-sm opacity-90">{{ $currentDate }}</div>
                
                {{-- Loading & Status Indicator --}}
                <div class="flex items-center justify-end gap-2 mt-2">
                    {{-- Mode Indicator --}}
                    @if($useDummyData)
                        <span class="text-xs bg-yellow-500 text-gray-900 px-2 py-1 rounded font-semibold">DEMO MODE</span>
                    @endif
                    
                    @if($isLoading)
                        <div class="flex items-center gap-1">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs">Updating...</span>
                        </div>
                    @else
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-xs">Live</span>
                        </div>
                    @endif
                    
                    @if($lastUpdate)
                        <span class="text-xs opacity-75">Last: {{ $lastUpdate }}</span>
                    @endif
                    
                    @if($apiError && !$useDummyData)
                        <span class="text-xs bg-red-500 px-2 py-1 rounded">API Offline</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-3 gap-6 p-8">
            <!-- Left Section - Current Queue -->
            <div class="col-span-1 space-y-4">
                <!-- Loket Badge -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-4 rounded-lg shadow-lg">
                    <div class="text-center">
                        <div class="text-4xl font-bold">LOKET 1</div>
                    </div>
                </div>

                <!-- Nomor Antrian Label -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-6 py-3 rounded-lg shadow-lg">
                    <div class="text-center text-xl font-semibold tracking-wider">
                        NOMOR ANTRIAN
                    </div>
                </div>

                <!-- Current Queue Number -->
                <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-gray-900 px-6 py-12 rounded-lg shadow-2xl border-4 border-yellow-600">
                    <div class="text-center">
                        <div class="text-8xl font-black tracking-wider" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                            {{ $loket1 ?? 'A 145' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Image Only -->
            <div class="col-span-2">
                <!-- Scenic Image -->
                <div class="rounded-lg overflow-hidden shadow-xl h-90">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=400&fit=crop" 
                         alt="Scenic View" 
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Bottom Section - Queue List for All Lokets (8 Columns Horizontal) -->
        <div class="px-8 pb-6 mb-2">
            <div class="flex gap-2 justify-between">
                <!-- Loket 1 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 1</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket1 ?? 'A 145' }}</div>
                    </div>
                </div>

                <!-- Loket 2 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 2</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket2 ?? 'A 146' }}</div>
                    </div>
                </div>

                <!-- Loket 3 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 3</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket3 ?? 'A 144' }}</div>
                    </div>
                </div>

                <!-- Loket 4 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 4</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket4 ?? 'B 143' }}</div>
                    </div>
                </div>

                <!-- Loket 5 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 5</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket5 ?? 'B 098' }}</div>
                    </div>
                </div>

                <!-- Loket 6 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 6</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket6 ?? 'C 120' }}</div>
                    </div>
                </div>

                <!-- Loket 7 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 7</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket7 ?? 'C 121' }}</div>
                    </div>
                </div>

                <!-- Loket 8 -->
                <div class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-700 px-3 py-2 text-center">
                        <div class="text-xs font-semibold">LOKET 8</div>
                    </div>
                    <div class="px-3 py-4 text-center">
                        <div class="text-2xl font-bold">{{ $loket8 ?? 'C 122' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer - Running Text -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-4 overflow-hidden relative">
            <div class="marquee-container">
                <div class="marquee-content">
                    <span class="text-lg font-semibold whitespace-nowrap">
                        Selamat datang di Rumah Sakit Sehat Selalu • Mohon menunggu nomor antrian Anda dipanggil • Terima kasih atas kunjungan Anda • 
                    </span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Running Text Animation */
        .marquee-container {
            width: 100%;
            overflow: hidden;
        }

        .marquee-content {
            display: flex;
            animation: scroll-left 40s linear infinite;
        }

        .marquee-content span {
            padding-right: 50px;
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        /* Pause animation on hover */
        .marquee-container:hover .marquee-content {
            animation-play-state: paused;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(250, 204, 21, 0.5); }
            50% { box-shadow: 0 0 40px rgba(250, 204, 21, 0.8); }
        }
    </style>

    <script>
        // Update clock every second
        setInterval(function() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const clockElement = document.getElementById('clock');
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }, 1000);
    </script>
</div>
</div>
