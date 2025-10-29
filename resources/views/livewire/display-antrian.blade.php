<div>
@section('title', 'Display Antrian')

{{-- Wire Poll: Auto refresh setiap 3 detik --}}
<div class="min-h-screen bg-gray-900 flex flex-col" 
     wire:poll.{{ $pollingInterval }}s="refreshQueue"
     wire:loading.class="opacity-95">
    <div class="w-full bg-white shadow-lg overflow-hidden">
        <!-- Header Component -->
        <x-header :currentTime="$currentTime" 
                  :currentDate="$currentDate" 
                  :showStatusIndicators="true"
                  :useDummyData="$useDummyData"
                  :isLoading="$isLoading"
                  :lastUpdate="$lastUpdate"
                  :apiError="$apiError" />

        <!-- Main Content -->
        <div class="p-8 bg-gray-50">
            <div class="max-w-full mx-auto">
                <div class="w-full">
                    <!-- Current Queue Section - Full Width -->
                    <div class="space-y-6 max-w-2xl mx-auto">
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
                        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-gray-900 px-8 py-16 rounded-lg shadow-2xl border-4 border-yellow-600">
                            <div class="text-center">
                                <div class="text-9xl font-black tracking-wider" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                                    {{ $loket1 ?? 'A 145' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bottom Section - Queue List for All Lokets (8 Columns Horizontal) -->
        <div class="px-8 pb-6 mb-2 bg-white">
            <div class="max-w-full mx-auto">
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
        <div class=" text-white py-4 overflow-hidden relative">
            <div class="marquee-container">
                <div class="marquee-content">
                    <span class="text-lg font-semibold whitespace-nowrap text-gray-900">
                        Selamat datang di Rumah Sakit Sehat Selalu • Mohon menunggu nomor antrian Anda dipanggil • Terima kasih atas kunjungan Anda • 
                    </span>
                </div>
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

@push('scripts')
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
@endpush
