<x-app-layout>
<x-slot name="header">
        <h1 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight, ">
            {{ __('Manage Students') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-28">
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded-md shadow-md">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-500 text-white p-4 mb-4 rounded-md shadow-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search bar -->
            <!-- <div class="mb-4">
                <form action="{{ route('students.index') }}" method="GET">
                    <input
                        type="text"
                        name="search"
                        class="px-4 py-2 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Search by ID, Name, or Contact Number"
                        value="{{ request()->get('search') }}"
                    />
                </form>
            </div> -->

            <!-- Display total number of students -->
            <div class="mb-4">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    Total number of students: <span class="text-xl">{{ $students->count() }}</span>
                </p>
            </div>

            <div class="overflow-hidden shadow-xl sm:rounded-lg bg-white dark:bg-gray-800">
                <div class="overflow-x-auto max-h-96">
                <table class="min-w-full table-auto border-separate border-spacing-0">
                        <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Student ID</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Contact Number</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach ($students as $student)
                                <tr>
                                    <td class="border-t px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $student->id }}</td>
                                    <td class="border-t px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $student->name }}</td>
                                    <td class="border-t px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $student->email }}</td>
                                    <td class="border-t px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $student->student_id }}</td>
                                    <td class="border-t px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $student->contact_number }}</td>
                                    <td class="border-t px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 focus:outline-none">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
