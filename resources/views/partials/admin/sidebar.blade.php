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
        <button @click="sidebarOpen = false"
            class="p-2 rounded-lg hover:bg-white/10 text-white transition-colors focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-8 px-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Dashboard
        </a>

        <!-- Messages -->
        <a href="{{ route('admin.contacts.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.contacts.*') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            Inbox
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.reports.*') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
            </svg>
            Reports
        </a>

        <!-- Scanners -->
        <a href="{{ route('admin.scanners.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.scanners.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.scanners.*') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z"
                    clip-rule="evenodd" />
                <path
                    d="M11 4a1 1 0 10-2 0v1a1 1 0 002 0V4zM10 7a1 1 0 011 1v1h2a1 1 0 110 2h-3a1 1 0 01-1-1V8a1 1 0 011-1zM16 9a1 1 0 100 2 1 1 0 000-2zM9 13a1 1 0 011-1h1a1 1 0 110 2v2a1 1 0 11-2 0v-3zM7 11a1 1 0 100-2H4a1 1 0 100 2h3zM17 13a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM16 17a1 1 0 100-2h-3a1 1 0 100 2h3z" />
            </svg>
            Scanners
        </a>

        <!-- Placeholder Links -->

        <!-- Management Group -->
        <!-- Events -->
        <a href="{{ route('admin.events.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.events.*') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    clip-rule="evenodd" />
            </svg>
            Events
        </a>

    </nav>

    <!-- User Section / Logout -->
    <div class="p-4 border-t border-blue-400/30">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-blue-100 hover:bg-white/10 hover:text-white transition-colors">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                        clip-rule="evenodd" />
                </svg>
                Logout
            </button>
        </form>
    </div>

</div>