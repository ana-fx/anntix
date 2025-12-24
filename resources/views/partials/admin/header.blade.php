<header class="bg-white border-b border-gray-100 h-24 flex items-center justify-between px-4 md:px-8 sticky top-0 z-20">
    <!-- Left: Branding or Breadcrumb (Optional) -->
    <div></div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-4">
        <!-- Notifications -->
        <button class="relative p-3 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
            <!-- Badge dot -->
            <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
        </button>

        <!-- Divider -->
        <div class="h-8 w-px bg-gray-100"></div>

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-700 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 mt-1 leading-none">{{ auth()->user()->role }}</p>
                </div>
                <div
                    class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold ring-2 ring-white shadow-sm">
                    {{ auth()->user()->initials() ?? 'A' }}
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">

                <div class="px-4 py-3 border-b border-gray-50 md:hidden">
                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('admin.profile') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">Profile</a>


                <div class="border-t border-gray-50 my-1"></div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>