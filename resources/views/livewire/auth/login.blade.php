<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative w-full max-w-md px-6 py-8">
        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('redirect-to-google', () => {
                    setTimeout(() => {
                        window.location.href = '{{ route("auth.google") }}';
                    }, 1000);
                });
            });
        </script>

        <!-- Logo Section with Animation -->
        <div class="text-center mb-8 animate-fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/50 transform hover:scale-110 transition-transform duration-300 mb-4">
                <svg class="w-11 h-11 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">
                Selamat Datang
            </h1>
            <p class="text-gray-600 text-lg">
                Sistem Antrian Rumah Sakit
            </p>
            <p class="text-gray-500 text-sm mt-1">
                Login untuk mengelola antrian Anda
            </p>
        </div>
        
        <!-- Main Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl shadow-gray-300/50 p-8 border border-white/20 animate-fade-in-up">
            <!-- Benefits Section -->
            <div class="mb-8">
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Pendaftaran cepat & mudah</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Pantau antrian real-time</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Aman & terpercaya</span>
                    </div>
                </div>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500 font-medium">Login dengan</span>
                </div>
            </div>
            
            <!-- Google Login Button -->
            <button 
                wire:click="loginWithGoogle" 
                wire:loading.attr="disabled"
                class="group relative w-full flex items-center justify-center gap-3 py-4 px-6 bg-white border-2 border-gray-200 rounded-xl shadow-md hover:shadow-xl hover:border-blue-300 hover:-translate-y-0.5 active:translate-y-0 text-gray-800 font-semibold text-base focus:outline-none focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:translate-y-0 overflow-hidden"
            >
                <!-- Hover Effect Background -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <!-- Google Logo -->
                <span class="relative z-10 flex-shrink-0" wire:loading.remove>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                        <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                        <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                        <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                    </svg>
                </span>
                
                <span class="relative z-10" wire:loading.remove>
                    Lanjutkan dengan Google
                </span>

                <!-- Loading State -->
                <span wire:loading class="relative z-10 flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menghubungkan ke Google...
                </span>

                <!-- Arrow Icon -->
                <svg wire:loading.remove class="relative z-10 w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>

            <!-- Info Text -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 leading-relaxed">
                    Dengan login, Anda menyetujui 
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium hover:underline">Syarat & Ketentuan</a> 
                    dan 
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium hover:underline">Kebijakan Privasi</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center animate-fade-in">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full border-2 border-white"></div>
                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full border-2 border-white"></div>
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full border-2 border-white"></div>
                </div>
                <p class="text-sm text-gray-600 font-medium">Dipercaya oleh 10,000+ pasien</p>
            </div>
            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Rumah Sakit Sehat Selalu. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Custom Animations -->
    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.6s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out 0.2s both;
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out 0.4s both;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</div>