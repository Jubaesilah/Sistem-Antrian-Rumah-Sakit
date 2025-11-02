<div>
{{-- Wire Poll: Auto refresh setiap 3 detik --}}
<div class="min-h-screen bg-gray-900 flex flex-col" 
     wire:poll.{{ $pollingInterval }}s="refreshQueue"
     wire:loading.class="opacity-95">

    @if(session()->has('warning'))
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
        <p class="font-bold">Perhatian</p>
        <p>{{ session('warning') }}</p>
    </div>
    @endif
    <div class="w-full bg-white shadow-lg overflow-hidden">
        <!-- Header Component -->
        <x-header :currentTime="$currentTime" 
                  :currentDate="$currentDate" 
                  :showStatusIndicators="true"
                  :isLoading="$isLoading"
                  :lastUpdate="$lastUpdate"
                  :apiError="$apiError" />

        <!-- Main Content - Two Column Layout -->
        <div class="p-8 bg-gray-50">
            <div class="max-w-full mx-auto">
                <!-- Two Column Grid -->
                <div class="flex gap-8">
                    <!-- Left Column - Currently Called Queue -->
                    <div class="w-1/2">
                        <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">Antrian Dipanggil</h2>
                        <div class="space-y-6">
                            @if(count($calledQueues) > 0)
                            <!-- Loket Badge -->
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-4 rounded-lg shadow-lg">
                                <div class="text-center">
                                    <div class="text-4xl font-bold">{{ $calledQueues[0]['counter']['counter_name'] }}</div>
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
                                        {{ $calledQueues[0]['queue_number'] }}
                                    </div>
                                </div>
                            </div>
                            @else
                            <!-- No Queue Available -->
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-4 rounded-lg shadow-lg">
                                <div class="text-center">
                                    <div class="text-4xl font-bold">ANTRIAN</div>
                                </div>
                            </div>

                            <!-- Nomor Antrian Label -->
                            <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-6 py-3 rounded-lg shadow-lg">
                                <div class="text-center text-xl font-semibold tracking-wider">
                                    NOMOR ANTRIAN
                                </div>
                            </div>

                            <!-- Empty Queue Number -->
                            <div class="bg-gradient-to-br from-gray-300 to-gray-400 text-gray-700 px-8 py-16 rounded-lg shadow-2xl border-4 border-gray-500">
                                <div class="text-center">
                                    <div class="text-5xl font-black tracking-wider" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                                        BELUM ADA ANTRIAN
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Right Column - Waiting Queues in 4x2 Grid -->
                    <div class="w-1/2">
                        <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">Antrian Menunggu</h2>
                        
                        <!-- 4x2 Grid for Waiting Queues -->
                        <div class="grid grid-cols-2 gap-4">
                            @forelse($waitingQueues as $index => $queue)
                                @if($index < 8) <!-- Limit to 8 waiting queues -->
                                <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-lg overflow-hidden">
                                    <div class="bg-green-700 px-3 py-2 text-center">
                                        <div class="text-xs font-semibold">{{ $queue['counter']['counter_name'] }}</div>
                                    </div>
                                    <div class="px-3 py-4 text-center">
                                        <div class="text-2xl font-bold">{{ $queue['queue_number'] }}</div>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <!-- Placeholder when no waiting queues are available -->
                                <div class="col-span-2 text-center py-4 text-gray-500">
                                    Tidak ada antrian yang sedang menunggu
                                </div>
                            @endforelse
                            
                            <!-- Add empty placeholders if we have fewer than 8 waiting queues -->
                            @for($i = count($waitingQueues); $i < 8; $i++)
                            <div class="bg-gradient-to-br from-gray-400 to-gray-500 text-white rounded-lg shadow-lg overflow-hidden opacity-50">
                                <div class="bg-gray-600 px-3 py-2 text-center">
                                    <div class="text-xs font-semibold">LOKET {{ $i + 1 }}</div>
                                </div>
                                <div class="px-3 py-4 text-center">
                                    <div class="text-2xl font-bold">-</div>
                                </div>
                            </div>
                            @endfor
                        </div>
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
    
    <script>
        // Speech Synthesis for Queue Announcements
        document.addEventListener('livewire:initialized', () => {
            // Check if browser supports Speech Synthesis
            if ('speechSynthesis' in window) {
                console.log('Speech Synthesis supported');
                
                // Listen for speakQueue event from Livewire
                Livewire.on('speakQueue', (event) => {
                    const data = event[0] || event;
                    const queueNumber = data.queueNumber;
                    const counterName = data.counterName;
                    
                    console.log('Speaking queue:', queueNumber, 'at', counterName);
                    
                    // Cancel any ongoing speech
                    window.speechSynthesis.cancel();
                    
                    // Create speech text in Indonesian
                    const speechText = `Nomor antrian ${queueNumber}, silakan menuju ${counterName}`;
                    
                    // Create utterance
                    const utterance = new SpeechSynthesisUtterance(speechText);
                    
                    // Set voice properties
                    utterance.lang = 'id-ID'; // Indonesian language
                    utterance.rate = 0.9; // Slightly slower for clarity
                    utterance.pitch = 1.0;
                    utterance.volume = 1.0;
                    
                    // Try to use Indonesian voice if available
                    const voices = window.speechSynthesis.getVoices();
                    const indonesianVoice = voices.find(voice => 
                        voice.lang.includes('id') || voice.lang.includes('ID')
                    );
                    
                    if (indonesianVoice) {
                        utterance.voice = indonesianVoice;
                    }
                    
                    // Speak the text
                    window.speechSynthesis.speak(utterance);
                    
                    // Log when speech ends
                    utterance.onend = () => {
                        console.log('Speech finished');
                    };
                    
                    utterance.onerror = (error) => {
                        console.error('Speech error:', error);
                    };
                });
                
                // Load voices (some browsers need this)
                window.speechSynthesis.getVoices();
                
                // Some browsers fire voiceschanged event when voices are loaded
                if (speechSynthesis.onvoiceschanged !== undefined) {
                    speechSynthesis.onvoiceschanged = () => {
                        window.speechSynthesis.getVoices();
                    };
                }
            } else {
                console.warn('Speech Synthesis not supported in this browser');
            }
        });
    </script>
    @endpush
</div>
