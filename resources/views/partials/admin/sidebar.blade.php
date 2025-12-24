<div class="w-64 bg-gradient-to-b from-blue-600 to-blue-500 text-white min-h-screen flex flex-col shadow-xl">
    <!-- Branding -->
    <div class="h-24 flex items-center justify-between px-8 border-b border-blue-400/30">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                <div class="w-2.5 h-2.5 bg-blue-600 rounded-full"></div>
            </div>
            <span class="text-lg font-bold tracking-wider uppercase">ANNTIX</span>
        </div>

        <!-- Close Button -->
        <button @click="sidebarOpen = false" class="p-2 rounded-lg hover:bg-white/10 text-white transition-colors focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-8 px-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'opacity-100' : 'opacity-70' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            Dashboard
        </a>

        <!-- Placeholder Links -->

        <!-- Management Group -->
        <div
            x-data="{ open: {{ request()->routeIs('admin.events.*') || request()->routeIs('admin.tickets.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.events.*') || request()->routeIs('admin.tickets.*') ? 'text-white font-semibold' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.events.*') || request()->routeIs('admin.tickets.*') ? 'opacity-100' : 'opacity-70' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Events
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Submenu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="pl-11 pr-4 space-y-1 mt-1">

                <a href="{{ route('admin.events.index') }}"
                    class="block py-2 px-3 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.events.*') && !request()->routeIs('admin.events.tickets.*') ? 'text-white bg-white/10 font-medium' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                    Event List
                </a>

                <a href="{{ route('admin.tickets.index') }}"
                    class="block py-2 px-3 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.tickets.*') ? 'text-white bg-white/10 font-medium' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                    Ticket List
                </a>
            </div>
        </div>

    </nav>

    <!-- User Section / Logout -->
    <div class="p-4 border-t border-blue-400/30">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-blue-100 hover:bg-white/10 hover:text-white transition-colors">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </div>

</div>