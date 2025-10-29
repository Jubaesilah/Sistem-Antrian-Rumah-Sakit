<x-layouts.sidebar title="Kelola Antrian - Rumah Sakit Sehat Selalu">
    <div class="flex-grow flex flex-col">
        <div class="flex-grow px-4 sm:px-6 lg:px-8 py-8 w-full">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Kelola Antrian</h1>
                <p class="mt-2 text-sm text-gray-600">Kelola antrian pasien untuk loket yang aktif</p>
            </div>

            <!-- Loket Selector -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Loket Aktif: {{ $loket['nama'] }}</h2>
                        <p class="text-sm text-gray-500">{{ $loket['deskripsi'] }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <select 
                                wire:model.live="loketId" 
                                wire:change="pilihLoket($event.target.value)"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                @foreach($lokets as $loketItem)
                                    <option value="{{ $loketItem['id'] }}">{{ $loketItem['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Antrian Sedang Dipanggil -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Sedang Dipanggil</h2>
                
                @if($antrianDipanggil)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="mb-4 sm:mb-0">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Nomor Antrian</p>
                                        <p class="text-3xl font-bold text-blue-800">{{ $antrianDipanggil['nomor_antrian'] }}</p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $antrianDipanggil['nama_pasien'] ?? 'Pasien' }} - 
                                            {{ $antrianDipanggil['jenis_layanan'] ?? 'Umum' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Dipanggil: {{ \Carbon\Carbon::parse($antrianDipanggil['waktu_panggil'])->format('H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button 
                                    wire:click="selesaikanAntrian()"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Selesai
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada antrian yang sedang dipanggil</p>
                    </div>
                @endif
            </div>

            <!-- Daftar Antrian Menunggu -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Antrian Menunggu</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Antrian yang sedang menunggu untuk dipanggil</p>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                wire:model.live.debounce.300ms="search"
                                type="text" 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                placeholder="Cari antrian...">
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200">
                    @if($antrianMenunggu->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. Antrian
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Pasien
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis Layanan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu Daftar
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($antrianMenunggu as $antrian)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $antrian['nomor_antrian'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $antrian['nama_pasien'] ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $antrian['jenis_layanan'] ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($antrian['created_at'])->format('H:i:s') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button 
                                                    wire:click="panggilAntrian('{{ $antrian['id'] }}')"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                                    </svg>
                                                    Panggil
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                            {{ $antrianMenunggu->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada antrian yang menunggu</p>
                        </div>
                    @endif
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

    @push('scripts')
    <script>
        // Auto refresh setiap 30 detik
        let refreshInterval = setInterval(() => {
            @this.call('$refresh');
        }, 30000);

        // Cleanup interval when component is unmounted
        document.addEventListener('livewire:unload', () => {
            clearInterval(refreshInterval);
        });

        // Play sound when an antrian is called
        window.addEventListener('antrianDipanggil', (event) => {
            // Buat suara notifikasi
            const audio = new Audio('/sounds/notification.mp3');
            audio.play().catch(e => console.log('Audio play failed:', e));
            
            // Tampilkan notifikasi
            const nomor = event.detail.nomor;
            const loket = event.detail.loket;
            
            // Notifikasi browser jika diizinkan
            if (Notification.permission === 'granted') {
                new Notification('Panggilan Antrian', {
                    body: `Nomor antrian ${nomor} silahkan ke ${loket}`,
                    icon: '/images/logo.png'
                });
            }
        });

        // Minta izin notifikasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                Notification.requestPermission();
            }
        });
    </script>
    @endpush
</x-layouts.sidebar>
