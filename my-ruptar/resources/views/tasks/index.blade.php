<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight, ">
            {{ __('Manage Tasks') }}
        </h1>
    </x-slot>

    <!-- Button to show the form -->
    <div class="text-center my-4">
        <x-primary-button id="createTaskButton">
            {{ __('Create a Task') }}
        </x-primary-button>
    </div>

    <!-- Task Creation Form -->
    <div id="taskFormContainer" class="hidden bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mx-auto relative pt-6" style="max-width: 50%; width: 50%;">

    <!-- Form Title -->
    <h1 class="text-xl font-bold text-center mb-4 text-gray-900 dark:text-gray-100">
        {{ __('Create a Task') }}
    </h1>

    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-gray-700 dark:text-gray-300">
                {{ __('Task Name') }}
            </label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50" 
                :value="old('name')" 
                required 
                autofocus 
            />
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description -->
        <div class="mt-4">
            <label for="description" class="block font-medium text-gray-700 dark:text-gray-300">
                {{ __('Description') }}
            </label>
            <textarea 
                id="description" 
                name="description" 
                rows="4" 
                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50" 
                required>{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Due Date -->
        <div class="mt-4">
            <label for="due_date" class="block font-medium text-gray-700 dark:text-gray-300">
                {{ __('Due Date') }}
            </label>
            <input 
                id="due_date" 
                type="text" 
                name="due_date" 
                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50" 
                required 
            />
            @error('due_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mt-4">
            <label for="image" class="block font-medium text-gray-700 dark:text-gray-300">
                {{ __('Upload Image') }}
            </label>
            <input 
                id="image" 
                type="file" 
                name="image" 
                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50" 
                accept="image/*" 
            />
            @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>



        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-6 space-x-4">
    <!-- Close Button -->
    <button id="closeTaskForm" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
        {{ __('Close') }}
    </button>

    <!-- Submit Button -->
    <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
        {{ __('Submit Task') }}
    </button>
</div>

    </form>
</div>


    <!-- Toggle Form Visibility Script -->
    <script>
        document.getElementById('createTaskButton').addEventListener('click', function () {
            const taskFormContainer = document.getElementById('taskFormContainer');
            taskFormContainer.classList.toggle('hidden');
        });
    </script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    // Initialize Flatpickr for Due Date
    flatpickr("#due_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
    });

    // Close Form
    document.getElementById('closeTaskForm').addEventListener('click', () => {
        document.getElementById('taskFormContainer').classList.add('hidden');
    });

    // Show Toast Notifications for Success or Error
    @if(session('success'))
        Toastify({
            text: "{{ session('success') }}",
            backgroundColor: "green",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right"
        }).showToast();
    @endif

    @if(session('error'))
        Toastify({
            text: "{{ session('error') }}",
            backgroundColor: "red",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right"
        }).showToast();
    @endif
</script>

</x-app-layout>
