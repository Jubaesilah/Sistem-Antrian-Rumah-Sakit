<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    @if($token && !$error)
        <script>
            // Auto redirect after 2 seconds if login successful
            setTimeout(() => {
                window.location.href = '{{ route("dashboard") }}';
            }, 2000);
        </script>
    @endif
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('login-success', () => {
                setTimeout(() => {
                    window.location.href = '{{ route("dashboard") }}';
                }, 2000);
            });
        });
    </script>

    <div class="relative w-full max-w-md px-6 py-8">
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl shadow-gray-300/50 p-8 border border-white/20">
            
            @if($isProcessing && !$error)
                <!-- Processing State -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/50 mb-6 animate-pulse">
                        <svg class="w-11 h-11 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Memproses Login...
                    </h2>
                    <p class="text-gray-600">
                        Mohon tunggu sebentar
                    </p>
                </div>
            @elseif($token && !$error)
                <!-- Success State -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg shadow-green-500/50 mb-6">
                        <svg class="w-11 h-11 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Login Berhasil!
                    </h2>
                    <p class="text-gray-600 mb-4">
                        Selamat datang, {{ $user['name'] ?? 'User' }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Mengalihkan ke dashboard...
                    </p>
                </div>
            @else
                <!-- Error State -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg shadow-red-500/50 mb-6">
                        <svg class="w-11 h-11 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Login Gagal
                    </h2>
                    
                    @if($error === 'email_not_registered')
                        <p class="text-gray-600 mb-4">
                            Email <strong>{{ $email }}</strong> belum terdaftar di sistem.
                        </p>
                        <p class="text-sm text-gray-500 mb-6">
                            Silakan hubungi admin untuk mendaftarkan akun Anda.
                        </p>
                    @elseif($error === 'email_not_verified')
                        <p class="text-gray-600 mb-4">
                            Email <strong>{{ $email }}</strong> belum diverifikasi.
                        </p>
                        <p class="text-sm text-gray-500 mb-6">
                            Silakan cek email Anda untuk verifikasi.
                        </p>
                    @else
                        <p class="text-gray-600 mb-4">
                            {{ $errorMessage ?? 'Terjadi kesalahan saat login' }}
                        </p>
                    @endif
                    
                    <button 
                        wire:click="retryLogin"
                        class="w-full py-3 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300"
                    >
                        Coba Lagi
                    </button>
                </div>
            @endif
            
        </div>
    </div>
</div>
