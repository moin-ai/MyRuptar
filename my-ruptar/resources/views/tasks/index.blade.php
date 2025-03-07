<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight, ">
            {{ __('Manage Tasks') }}
        </h1>
    </x-slot>

 <!-- Search and Action Bar -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="flex justify-between items-center gap-4">
        <!-- Search Form -->
        <form action="{{ route('tasks.index') }}" method="GET" class="flex-1">
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="search"
                        class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Search tasks..."
                        value="{{ request('search') }}"
                    />
                    <!--  -->
                </div>
            </div>
        </form>

        <!-- Create Task Button -->
        <div class="flex items-center gap-3">
            @if(request('search'))
                <a href="{{ route('tasks.index') }}" 
                   class="px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200 flex items-center gap-2">
                    <span>Clear</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
            <button id="createTaskButton" 
    class="group px-6 py-3 bg-gradient-to-br from-emerald-400 to-green-500 text-white rounded-xl hover:from-emerald-500 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:ring-offset-2 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-green-500/30 flex items-center gap-3">
    <svg class="w-5 h-5 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    <span class="font-medium">Create New Task</span>
</button>

        </div>
    </div>
</div>



  <!-- Task Creation Form -->
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
            type="date" 
            name="due_date" 
            class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50" 
            required 
        />
        @error('due_date')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Attachment -->
    <div class="mt-4">
        <label for="attachment" class="block font-medium text-gray-700 dark:text-gray-300">
            {{ __('Attachment') }}
        </label>
        <input 
            id="attachment" 
            type="file" 
            name="attachment" 
            class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50"
        />
        @error('attachment')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Assign Students -->
    <div class="mt-4">
        <label class="block font-medium text-gray-700 dark:text-gray-300">
            {{ __('Assign to Students') }}
        </label>

        <!-- Mass Assign Checkbox -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="massAssign" name="massAssign" class="h-5 w-5 text-blue-500">
            <label for="massAssign" class="text-gray-700 dark:text-gray-300">{{ __('Assign to All Students') }}</label>
        </div>

        <!-- Select Specific Students -->
        <div id="studentSelectContainer" class="overflow-x-auto border border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="py-2 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-200">{{ __('Select') }}</th>
                    <th class="py-2 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-200">{{ __('Name') }}</th>
                    <th class="py-2 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-200">{{ __('Student ID') }}</th>
                    <th class="py-2 px-4 text-left text-sm font-medium text-gray-600 dark:text-gray-200">{{ __('Contact Number') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-600">
                @foreach($students as $student)
                    <tr>
                        <td class="py-2 px-4">
                            <input type="checkbox" name="selected_students[]" value="{{ $student->id }}" class="h-5 w-5 text-blue-500">
                        </td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $student->name }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $student->student_id }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $student->contact_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @error('selected_students')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
    </div>

    <!-- Submit Button -->
    <div class="flex items-center justify-end mt-6 space-x-4">
        <button id="closeTaskForm" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
            {{ __('Close') }}
        </button>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
            {{ __('Submit Task') }}
        </button>
    </div>
</form>
</div>

<script>
    document.getElementById('massAssign').addEventListener('change', function() {
        document.getElementById('studentSelectContainer').style.display = this.checked ? 'none' : 'block';
    });
</script>

<!-- Tasks Grid -->
<div id="taskGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
    @forelse ($tasks as $task)
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
        <div class="space-y-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                    {{ $task->name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $task->description }}
                </p>
            </div>

            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y h:i A') }}
            </div>

            @if($task->attachment)
            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank" class="hover:underline">
                    View Attachment
                </a>
            </div>
            @endif
        </div>

        <div class="mt-4">
            <strong class="text-center text-gray-700 dark:text-gray-300 ">Assigned To:</strong>
            <table class="w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-lg">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-left">Student ID</th>
                        <th class="px-4 py-2 text-left">Student Name</th>
                        <th class="px-4 py-2 text-left">Assigned At</th>
                        <th class="px-4 py-2 text-left">Completion Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @foreach ($task->assignedStudents as $student) 
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $student->student_id }}</td>
                            <td class="px-4 py-2">{{ $student->name }}</td>
                            <td class="px-4 py-2">{{ $student->pivot->assigned_at ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $student->pivot->completion_status ?? 'Pending' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button onclick="openTaskDetailsModal({{ json_encode($task) }})" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7 1.274 4.057-2.515 9-7 9-4.479 0-8.269-4.943-9.542-9z" />
                </svg>
                View Details
            </button>

            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" onsubmit="return confirm('Are you sure you want to delete this task?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400 rounded-xl">
        No tasks found.
    </div>
    @endforelse
</div>




<!-- Task Details Modal -->
<div id="taskDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200" id="modalTaskName"></h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2" id="modalTaskDescription"></p>
        
        <div class="mt-4">
            <strong class="text-gray-700 dark:text-gray-300">Assigned To:</strong>
            <ul id="modalTaskStudents" class="mt-1 space-y-1"></ul>
        </div>

        <div class="mt-4">
            <strong class="text-gray-700 dark:text-gray-300">Assigned At:</strong>
            <p id="modalTaskAssignedAt" class="text-gray-600 dark:text-gray-400"></p>
        </div>

        <div class="mt-4">
            <strong class="text-gray-700 dark:text-gray-300">Attachments:</strong>
            <ul id="modalTaskAttachments" class="mt-1 space-y-1"></ul>
        </div>

        <button onclick="closeTaskModal()" class="mt-6 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            Close
        </button>
    </div>
</div>

@push('scripts')
    <script>
        // Get references to the modal and form elements
        const openTaskFormButton = document.getElementById('createTaskButton');
        const closeTaskFormButton = document.getElementById('closeTaskForm');
        const taskFormContainer = document.getElementById('taskFormContainer');

        // Event listener for opening the modal
        openTaskFormButton.addEventListener('click', () => {
            taskFormContainer.classList.remove('hidden');
        });

        // Event listener for closing the modal
        closeTaskFormButton.addEventListener('click', () => {
            taskFormContainer.classList.add('hidden');
        });
    </script>
    @endpush

<script>
    function openTaskDetails(task) {
        document.getElementById('modalTaskName').innerText = task.name;
        document.getElementById('modalTaskDescription').innerText = task.description;
        document.getElementById('modalTaskAssignedAt').innerText = new Date(task.created_at).toLocaleString();

        let studentsHtml = '';
        task.students.forEach(student => {
            studentsHtml += `<li class="text-gray-600 dark:text-gray-400">• ${student.name} (${student.pivot.status === 'completed' ? '✅ Completed' : '❌ Pending'})</li>`;
        });
        document.getElementById('modalTaskStudents').innerHTML = studentsHtml;

        let attachmentsHtml = '';
        task.attachments.forEach(attachment => {
            attachmentsHtml += `<li><a href="/storage/${attachment.file_path}" target="_blank" class="text-blue-500 hover:underline">📎 ${attachment.file_name}</a></li>`;
        });
        document.getElementById('modalTaskAttachments').innerHTML = attachmentsHtml;

        document.getElementById('taskDetailsModal').classList.remove('hidden');
    }

    function closeTaskModal() {
        document.getElementById('taskDetailsModal').classList.add('hidden');
    }
</script>



<!-- Load More Button -->
<div class="text-center mt-6 mb-8">
    @if ($tasks->hasMorePages())
        <button id="loadMoreButton" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all hover:scale-105 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-indigo-800">
            <span>Load More</span>
            <svg class="w-5 h-5 ml-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </button>
    @endif
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
        minDate: "today"
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


<!-- Edit Task Modal -->
<div id="editTaskModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-6 rounded-md shadow-lg w-96">
            <h2 class="text-lg font-bold mb-4">Edit Task</h2>
            <form id="editTaskForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Task Name -->
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                    <input type="text" id="editName" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300" required>
                </div>

                <!-- Task Description -->
                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                    <textarea id="editDescription" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300" required></textarea>
                </div>

                <!-- Task Due Date -->
                <div class="mb-4">
                    <label for="editDueDate" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Due Date</label>
                    <input type="datetime-local" id="editDueDate" name="due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300" required>
                </div>

                <!-- Attachment -->
                <div class="mb-4">
                    <label for="editAttachment" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Attachment</label>
                    <input type="file" id="editAttachment" name="attachment" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300">
                </div>

                <!-- Student Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Reassign Students</label>
                    <div class="mt-2 space-y-2">
                        @if(isset($students))
                        @foreach($students as $student)
                        <div class="flex items-center">
                            <input type="checkbox" name="selected_students[]" value="{{ $student->id }}" id="editStudent_{{ $student->id }}" class="rounded border-gray-300 text-blue-500 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-blue-400">
                            <label for="editStudent_{{ $student->id }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $student->name }}</label>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditTaskModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Initialize Flatpickr for Edit Due Date
    flatpickr("#editDueDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
    });
</script>


<script>
 document.addEventListener('DOMContentLoaded', function () {
    // Task Creation Modal
    const openTaskFormButton = document.getElementById('openTaskFormButton');
    const closeTaskFormButton = document.getElementById('closeTaskFormButton');
    const taskFormModal = document.getElementById('taskFormModal');

    // Edit Task Modal
    const editTaskModal = document.getElementById('editTaskModal');
    const editTaskForm = document.getElementById('editTaskForm');
    const editNameInput = document.getElementById('editName');
    const editDescriptionTextarea = document.getElementById('editDescription');
    const editDueDateInput = document.getElementById('editDueDate');

    // Open task form modal
    openTaskFormButton.addEventListener('click', function () {
        taskFormModal.classList.remove('hidden');
    });

    // Close task form modal
    closeTaskFormButton.addEventListener('click', function () {
        taskFormModal.classList.add('hidden');
    });

    // Function to open edit task modal and populate data
    window.openEditTaskModal = function (task) {
        editNameInput.value = task.name;
        editDescriptionTextarea.value = task.description;
        editDueDateInput.value = task.due_date;

        // Set the action URL for the edit form
        editTaskForm.action = `/tasks/${task.id}`; // Assumes your route is /tasks/{task}

        editTaskModal.classList.remove('hidden');
    };

    // Function to close edit task modal
    window.closeEditTaskModal = function () {
        editTaskModal.classList.add('hidden');
    };
});
</script>

<script>
    document.getElementById('loadMoreButton')?.addEventListener('click', function() {
        let page = {{ $tasks->currentPage() }};
        let nextPage = page + 1;

        fetch(`?page=${nextPage}`, { method: 'GET' })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTasks = doc.querySelector('#taskGrid').innerHTML;
                document.querySelector('#taskGrid').innerHTML += newTasks;

                // Remove Load More button if there are no more pages
                if (!doc.querySelector('#loadMoreButton')) {
                    document.getElementById('loadMoreButton').remove();
                }
            })
            .catch(error => console.error('Error loading more tasks:', error));
    });
</script>


</x-app-layout>
