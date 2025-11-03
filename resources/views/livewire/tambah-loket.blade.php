<x-layouts.sidebar title="Tambah Counter - Rumah Sakit Sehat Selalu">
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
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Counter Baru</h1>
                        <p class="mt-2 text-sm text-gray-600">Tambahkan counter pelayanan baru untuk rumah sakit</p>
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

            <!-- Form Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <form wire:submit.prevent="save">
                    <div class="px-6 py-6 space-y-6">
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
                            Simpan Counter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Nama counter harus unik dan mudah dikenali</li>
                                <li>Deskripsi membantu pasien memahami layanan yang tersedia</li>
                                <li>Counter yang dibuat akan langsung tersedia untuk sistem antrian</li>
                            </ul>
                        </div>
                    </div>
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
</x-layouts.sidebar>
