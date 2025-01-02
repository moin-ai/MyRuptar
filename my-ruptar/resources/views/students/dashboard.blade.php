<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Task Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <!-- Total Tasks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500/10 dark:bg-blue-500/20">
                                <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tasks</h3>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $taskOverview['totalAssigned'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500/10 dark:bg-green-500/20">
                                <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed</h3>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $taskOverview['completed'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completion Rate -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500/10 dark:bg-purple-500/20">
                                <svg class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Completion Rate</h3>
                                <p class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $taskOverview['completionRate'] }}%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800 dark:text-gray-200">My Tasks</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Task</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($tasks as $task)
                                    <tr class="group hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-150">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $task->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $task->description }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($task->completed_at)
                                                <span class="text-sm text-green-600 dark:text-green-300">
                                                    Completed
                                                </span>
                                            @elseif($task->is_overdue)
                                                <span class="text-sm text-red-600 dark:text-red-600">
                                                    Overdue
                                                </span>
                                            @else
                                                <span class="text-sm text-red-600 dark:text-red-600">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(!$task->completed_at && !$task->is_overdue)
                                                <form action="{{ route('tasks.complete', $task->assignment_id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 text-sm bg-blue-500 text-white dark:bg-blue-600 dark:text-white rounded-md hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors duration-150">
                                                        Mark Complete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No tasks found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
