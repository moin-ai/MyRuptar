<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex justify-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('warden.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                        {{ __('Tasks') }}
                    </x-nav-link>
                    <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.index')">
                        {{ __('Students') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notification Button -->
                <div class="relative" x-data="{ notificationOpen: false }">
                    <!-- <button @click="notificationOpen = !notificationOpen" class="relative p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V9a6 6 0 10-12 0v5c0 .386-.149.735-.395 1L4 17h5m6 0a3.5 3.5 0 01-7 0" />
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button> -->

                    <!-- Notification Dropdown -->
                    <!-- Notification Dropdown -->
<div class="relative" x-data="{ notificationOpen: false }">
    <button @click="notificationOpen = !notificationOpen" class="relative p-1.5 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
        <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V9a6 6 0 10-12 0v5c0 .386-.149.735-.395 1L4 17h5m6 0a3.5 3.5 0 01-7 0" />
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 dark:bg-red-600 rounded-full">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="notificationOpen" 
         @click.away="notificationOpen = false"
         class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Notifications</h3>
        </div>
        <div class="max-h-[400px] overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <div class="p-4 hover:bg-gray-50/70 dark:hover:bg-gray-700/50 transition-all duration-200">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $notification->data['title'] }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        {{ $notification->data['message'] }}
                    </p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                        </span>
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-green-600 dark:text-green-400 hover:text-white-800 dark:hover:text-white-300 font-medium">
                                Mark as read
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">No new notifications</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Keep your existing responsive menu code -->
    </div>
</nav>
