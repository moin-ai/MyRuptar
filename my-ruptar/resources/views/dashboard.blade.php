<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Warden Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Overview Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Students -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500/10 dark:bg-blue-500/20">
                                <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</h3>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $overview['totalStudents'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500/10 dark:bg-green-500/20">
                                <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tasks</h3>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $overview['totalTasks'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500/10 dark:bg-purple-500/20">
                                <svg class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Tasks</h3>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $overview['completedTasks'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Completion Trends Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800 dark:text-gray-200">Task Completion Trends</h3>
                    <div class="h-80">
                        <canvas id="completionTrendsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Student Performance Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800 dark:text-gray-200">Student Performance</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Assigned
                                    </th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Completed
                                    </th>
                                    <th scope="col" class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Completion Rate
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
    @foreach($studentPerformance as $student)
        <tr class="group hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-150">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                    {{ $student->name }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600/75 dark:group-hover:text-blue-300">
                    {{ $student->total_assigned }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600/75 dark:group-hover:text-blue-300">
                    {{ $student->completed_tasks }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600/75 dark:group-hover:text-blue-300">
                        {{ $student->completion_rate }}%
                    </div>
                    <div class="ml-2 w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full group-hover:bg-blue-500" 
                             style="width: {{ $student->completion_rate }}%">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const trendsCtx = document.getElementById('completionTrendsChart').getContext('2d');
        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($completionTrends)) !!},
                datasets: [{
                    label: 'Completed Tasks',
                    data: {!! json_encode(array_values($completionTrends)) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#9CA3AF'
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
