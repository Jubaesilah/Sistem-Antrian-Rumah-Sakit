<x-layouts.sidebar title="Edit Counter - Rumah Sakit Sehat Selalu">
    <div class="flex-grow flex flex-col">
        <div class="flex-grow px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('kelola.loket') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Counter</h1>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi counter pelayanan</p>
                    </div>
                </div>
            </div>

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

            @if($loading)
                <!-- Loading State -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="px-6 py-12 text-center">
                        <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600">Memuat data counter...</p>
                    </div>
                </div>
            @elseif($notFound)
                <!-- Not Found State -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="px-6 py-12 text-center">
                        <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Counter Tidak Ditemukan</h3>
                        <p class="text-gray-600 mb-6">Counter yang Anda cari tidak ditemukan atau telah dihapus.</p>
                        <a href="{{ route('kelola.loket') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Kembali ke Daftar Counter
                        </a>
                    </div>
                </div>
            @else
                <!-- Form Card -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <form wire:submit.prevent="save">
                        <div class="px-6 py-6 space-y-6">
                            <!-- Counter ID Info -->
                            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Counter ID</p>
                                <p class="mt-1 text-sm font-mono text-gray-900">{{ $counter_id }}</p>
                            </div>

                            <!-- Nama Counter -->
                            <div>
                                <label for="counter_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Counter <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    wire:model="counter_name" 
                                    type="text" 
                                    id="counter_name" 
                                    class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('counter_name') border-red-500 @enderror" 
                                    placeholder="Contoh: Poli Anak, Poli Gigi, Loket Umum">
                                @error('counter_name') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal 3 karakter</p>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea 
                                    wire:model="description" 
                                    id="description" 
                                    rows="4" 
                                    class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-500 @enderror" 
                                    placeholder="Deskripsi layanan counter..."></textarea>
                                @error('description') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal 10 karakter (opsional)</p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-200">
                            <button 
                                type="button"
                                wire:click="cancel"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </button>
                            <button 
                                type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Warning Box -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Perubahan pada counter akan mempengaruhi sistem antrian yang sedang berjalan. Pastikan informasi yang dimasukkan sudah benar.</p>
                            </div>
                        </div>
                    </div>
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
