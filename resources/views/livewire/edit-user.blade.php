<x-layouts.sidebar title="Edit User - Rumah Sakit Sehat Selalu">
    <div class="flex-grow flex flex-col">
        <div class="flex-grow px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('kelola.user') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi pengguna</p>
                    </div>
                </div>
            </div>

            @if($loading)
                <!-- Loading State -->
                <div class="bg-white shadow-md rounded-lg p-12">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="animate-spin h-12 w-12 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600">Memuat data user...</p>
                    </div>
                </div>
            @elseif($notFound)
                <!-- Not Found State -->
                <div class="bg-white shadow-md rounded-lg p-12">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="h-16 w-16 text-red-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">User Tidak Ditemukan</h3>
                        <p class="text-gray-600 mb-6">User yang Anda cari tidak ditemukan atau sudah dihapus.</p>
                        <a 
                            href="{{ route('kelola.user') }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Daftar User
                        </a>
                    </div>
                </div>
            @else
                <!-- Flash Messages -->
                @if (session()->has('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Warning Box -->
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Perubahan email akan memerlukan verifikasi ulang</li>
                                    <li>Perubahan role akan mempengaruhi akses user ke sistem</li>
                                    <li>Pastikan data yang dimasukkan sudah benar</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <form wire:submit.prevent="update">
                        <div class="p-6 space-y-6">
                            <!-- User ID (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    User ID
                                </label>
                                <div class="mt-1 block w-full border border-gray-200 rounded-md shadow-sm py-2 px-3 bg-gray-50 text-gray-600 sm:text-sm">
                                    {{ $user_id }}
                                </div>
                                <p class="mt-2 text-sm text-gray-500">ID unik user (tidak dapat diubah)</p>
                            </div>

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    wire:model="full_name" 
                                    type="text" 
                                    id="full_name" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('full_name') border-red-300 @enderror" 
                                    placeholder="Masukkan nama lengkap">
                                @error('full_name') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    wire:model="email" 
                                    type="email" 
                                    id="email" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror" 
                                    placeholder="user@example.com">
                                @error('email') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="role" 
                                    id="role" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('role') border-red-300 @enderror">
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="petugas">Petugas</option>
                                </select>
                                @error('role') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    <strong>Admin:</strong> Akses penuh ke semua fitur sistem<br>
                                    <strong>Petugas:</strong> Akses terbatas untuk mengelola antrian di counter
                                </p>
                            </div>

                            <!-- Counter -->
                            <div>
                                <label for="counter_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Counter <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="counter_id" 
                                    id="counter_id" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('counter_id') border-red-300 @enderror">
                                    <option value="">Pilih Counter</option>
                                    @foreach($counters as $counter)
                                        <option value="{{ $counter['counter_id'] }}">{{ $counter['counter_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('counter_id') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">
                                    Counter yang akan ditugaskan kepada user ini
                                </p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                            <a 
                                href="{{ route('kelola.user') }}" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                wire:loading.attr="disabled">
                                <svg wire:loading.remove class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg wire:loading class="animate-spin mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove>Perbarui User</span>
                                <span wire:loading>Memperbarui...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif
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
</x-layouts.sidebar>
