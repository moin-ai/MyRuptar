<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight, ">
            {{ __('Manage Tasks') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Task List</h3>
                    <ul class="space-y-2">
                        <li class="p-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm">
                            Task 1: Complete dashboard design
                        </li>
                        <li class="p-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm">
                            Task 2: Implement user authentication
                        </li>
                        <li class="p-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm">
                            Task 3: Review PR #42
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
