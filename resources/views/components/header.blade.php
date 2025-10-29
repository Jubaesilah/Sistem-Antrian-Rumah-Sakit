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
        <div class="text-3xl font-bold" id="clock">{{ $currentTime ?? now()->format('H:i:s') }}</div>
        <div class="text-sm opacity-90">{{ $currentDate ?? now()->locale('id')->isoFormat('DD MMMM YYYY') }}</div>
        
        {{-- Loading & Status Indicator --}}
        @if(isset($showStatusIndicators) && $showStatusIndicators)
        <div class="flex items-center justify-end gap-2 mt-2">

            
            @if(isset($isLoading) && $isLoading)
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
            
            @if(isset($lastUpdate))
                <span class="text-xs opacity-75">Last: {{ $lastUpdate }}</span>
            @endif
            
            @if(isset($apiError) && $apiError && (!isset($useDummyData) || !$useDummyData))
                <span class="text-xs bg-red-500 px-2 py-1 rounded">API Offline</span>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Update clock every second
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        setTimeout(updateClock, 1000);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        updateClock();
    });
</script>
@endpush
