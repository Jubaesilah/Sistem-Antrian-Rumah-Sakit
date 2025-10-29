<div>
    @section('title', $title ?? 'Rumah Sakit Sehat Selalu')

    <div class="min-h-screen flex flex-col">

        
        <!-- Main Content with Sidebar -->
        <div class="flex-grow flex">
            <!-- Sidebar Component -->
            <div class="bg-gray-800 text-white w-64 h-screen flex flex-col fixed left-0 top-0 z-10">
                <!-- Sidebar Header -->
                <div class="p-4 border-b border-gray-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">RS Sehat Selalu</h2>
                            <p class="text-xs text-gray-400">Admin Panel</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7zm0 0V5a2 2 0 012-2h6l2 2h6a2 2 0 012 2v2M7 13h10M7 17h10"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Display Antrian -->
                    <a href="{{ route('display.antrian') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('display.antrian') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Display Antrian
                    </a>

                    <!-- Ambil Antrian -->
                    <a href="{{ route('ambil.antrian') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('ambil.antrian') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Ambil Antrian
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-700 my-4"></div>

                    <!-- Loket Management -->
                    <a href="{{ route('kelola.loket') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('kelola.loket') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Kelola Loket
                    </a>

                    <!-- User Management -->
                    <a href="{{ route('kelola.user') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('kelola.user') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Kelola User
                    </a>

                     <!-- Queue Management -->
                    <a href="{{ route('kelola.antrian') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('kelola.antrian') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Kelola Antrian
                    </a>
                </nav>

                <!-- User Profile & Logout -->
                <div class="p-4 border-t border-gray-700">
                    <!-- User Profile -->
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">Admin User</p>
                            <p class="text-xs text-gray-400">admin@rs-sehat.com</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <button 
                        onclick="if(confirm('Apakah Anda yakin ingin logout?')) { window.location.href = '{{ route('login') }}'; }"
                        class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 text-gray-300 hover:bg-red-600 hover:text-white">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
            
            <!-- Main Content Area (Slot) -->
            <div class="flex-grow bg-gray-50 flex flex-col ml-64">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
