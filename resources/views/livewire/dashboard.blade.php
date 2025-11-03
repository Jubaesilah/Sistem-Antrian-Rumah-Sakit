<x-layouts.sidebar title="Dashboard - Rumah Sakit Sehat Selalu">
    <div class="flex-grow flex flex-col">
        <div class="flex-grow px-4 sm:px-6 lg:px-8 py-8 w-full">
            <!-- Page Title -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    @if ($user)
                        <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ $user['name'] ?? 'User' }}</p>
                    @endif
                </div>
                <div class="flex gap-3 items-center">
                    <!-- Filter Dropdown -->
                </div>
            </div>

            <!-- API Error Alert -->
            @if ($apiError)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Tidak dapat terhubung ke API. Menampilkan data dummy.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-8">
                <!-- Total Antrian Hari Ini -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Antrian Hari Ini
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $totalAntrian }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <div class="font-medium text-blue-600 hover:text-blue-500">
                                Rata-rata {{ round($totalAntrian / $totalLoket) }} per loket
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Loket -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Loket
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $totalLoket }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <div class="font-medium text-indigo-600 hover:text-indigo-500">
                                Semua loket aktif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total User -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total User
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $totalUser }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <div class="font-medium text-green-600 hover:text-green-500">
                                {{ $totalUser - 2 }} staff aktif hari ini
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Waktu Tunggu -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Rata-rata Waktu Tunggu
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            {{ $rataRataWaktuTunggu }} menit
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <div class="font-medium text-red-600 hover:text-red-500">
                                @if ($rataRataWaktuTunggu < 15)
                                    Waktu tunggu optimal
                                @elseif($rataRataWaktuTunggu < 25)
                                    Waktu tunggu normal
                                @else
                                    Waktu tunggu di atas rata-rata
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-5 xl:grid-cols-2 mb-8">
                <!-- Traffic Chart -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Traffic Antrian</h3>

                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div id="trafficChart" class="h-64" data-traffic='@json($trafficHarian)'
                            wire:key="traffic-chart-{{ md5(json_encode($trafficHarian)) }}"></div>
                    </div>
                </div>

                <!-- Antrian per Loket -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Antrian per Loket</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="space-y-4">
                            @foreach ($antrianPerLoket as $loket)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-700">{{ $loket['nama'] }}
                                                ({{ $loket['kode'] }})
                                            </span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $loket['total'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-{{ $loket['warna'] }}-500 h-2.5 rounded-full"
                                            style="width: {{ ($loket['total'] / 60) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Distribution Section -->
            @if (count($statusDistribution) > 0)
                <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Status Antrian per Loket Hari Ini</h3>
                        <p class="mt-1 text-sm text-gray-500">Distribusi status antrian (waiting, called, done) untuk
                            setiap loket</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        @foreach ($statusDistribution as $loket)
                            <div>
                                <div class="mb-4 text-base font-semibold">
                                    {{ $loket['counter_name'] ?? 'Loket' }}
                                </div>
                                <div id="statusDonutChart-{{ $loket['counter_id'] }}" class="h-72"
                                    data-status='@json($loket)'
                                    data-counter="{{ $loket['counter_id'] }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

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

    <script>
        (function() {
            // ------ TRAFFIC CHART tetap seperti biasa ------
            let trafficChartInstance = null;
            let lastTrafficDataHash = null;

            function initTrafficChart() {
                const chartDom = document.getElementById('trafficChart');
                if (!chartDom || !window.echarts) return;
                const trafficDataStr = chartDom.getAttribute('data-traffic');
                if (!trafficDataStr) return;
                const currentHash = btoa(trafficDataStr).substring(0, 16);
                if (currentHash === lastTrafficDataHash && trafficChartInstance) {
                    return;
                }
                lastTrafficDataHash = currentHash;
                const trafficData = JSON.parse(trafficDataStr);
                if (!trafficData || trafficData.length === 0) return;
                if (trafficChartInstance) {
                    trafficChartInstance.dispose();
                }
                trafficChartInstance = window.echarts.init(chartDom);
                const days = trafficData.map(item => item.hari && item.hari.length > 7 ? item.hari.substring(0, 3) : (
                    item.hari || ''));
                const values = trafficData.map(item => item.total || 0);
                const option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: days,
                        axisLabel: {
                            rotate: 0
                        }
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        name: 'Total Antrian',
                        type: 'bar',
                        data: values,
                        itemStyle: {
                            color: new window.echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                offset: 0,
                                color: '#3b82f6'
                            }, {
                                offset: 1,
                                color: '#2563eb'
                            }])
                        },
                        emphasis: {
                            itemStyle: {
                                color: new window.echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: '#2563eb'
                                }, {
                                    offset: 1,
                                    color: '#1d4ed8'
                                }])
                            }
                        }
                    }]
                };
                trafficChartInstance.setOption(option);
                window.addEventListener('resize', () => trafficChartInstance && trafficChartInstance.resize());
            }

            // ------ CHART DONAT PER-LOKET ------
            function initStatusDonutChartsPerLoket() {
                document.querySelectorAll('[id^="statusDonutChart-"]').forEach(function(chartEl) {
                    if (!window.echarts) return;
                    const statusDataRaw = chartEl.getAttribute('data-status');
                    if (!statusDataRaw) return;
                    let loketObj;
                    try {
                        loketObj = JSON.parse(statusDataRaw);
                    } catch (e) {
                        loketObj = statusDataRaw;
                    }
                    if (!loketObj || typeof loketObj !== 'object') return;
                    const seriesData = [];
                    if ((loketObj.waiting ?? 0) > 0) {
                        seriesData.push({
                            value: loketObj.waiting,
                            name: 'Waiting',
                            itemStyle: {
                                color: '#fbbf24'
                            }
                        })
                    }
                    if ((loketObj.called ?? 0) > 0) {
                        seriesData.push({
                            value: loketObj.called,
                            name: 'Called',
                            itemStyle: {
                                color: '#3b82f6'
                            }
                        })
                    }
                    if ((loketObj.done ?? 0) > 0) {
                        seriesData.push({
                            value: loketObj.done,
                            name: 'Done',
                            itemStyle: {
                                color: '#10b981'
                            }
                        })
                    }
                    if (seriesData.length === 0) {
                        // Jika semua 0, tetap tampilkan donat kosong (optional: tampilkan chart kosong/teks?)
                        chartEl.innerHTML = '<div class="text-center text-gray-400 mt-16">Tidak ada data</div>';
                        return;
                    }
                    // Init chart
                    const chart = window.echarts.init(chartEl);
                    chart.setOption({
                        tooltip: {
                            trigger: 'item',
                            formatter: '{a} <br/>{b}: {c} ({d}%)'
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'left',
                            type: 'scroll',
                            itemHeight: 14,
                            itemWidth: 14,
                            textStyle: {
                                fontSize: 12
                            }
                        },
                        series: [{
                            name: 'Status Antrian',
                            type: 'pie',
                            radius: ['45%', '75%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                borderRadius: 8,
                                borderColor: '#fff',
                                borderWidth: 2
                            },
                            label: {
                                show: true,
                                formatter: '{b}: {c}\n({d}%)',
                                fontSize: 11
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: 12,
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: true
                            },
                            data: seriesData
                        }]
                    });
                    window.addEventListener('resize', () => chart.resize());
                });
            }

            // ------ INISIALISASI ------
            function setupAllCharts() {
                initTrafficChart();
                initStatusDonutChartsPerLoket();
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => setupAllCharts());
            } else {
                setupAllCharts();
            }
            document.addEventListener('livewire:update', () => setTimeout(setupAllCharts, 100));
            document.addEventListener('livewire:navigated', () => setTimeout(setupAllCharts, 100));
            // Tidak perlu lagi fungsi chart donat tunggal/lamanya!
        })();
    </script>
</x-layouts.sidebar>
