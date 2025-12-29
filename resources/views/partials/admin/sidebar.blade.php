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

        <!-- Banners -->
        <a href="{{ route('admin.banners.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.banners.*') ? 'opacity-100' : 'opacity-70' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Banners
        </a>

        <!-- User Management (Dropdown) -->
        <div
            x-data="{ open: {{ request()->routeIs('admin.scanners.*') || request()->routeIs('admin.admins.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.scanners.*') || request()->routeIs('admin.admins.*') ? 'bg-white/10 text-white font-semibold' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.scanners.*') || request()->routeIs('admin.admins.*') ? 'opacity-100' : 'opacity-70' }}"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    User Management
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95" class="pl-4 space-y-1 mt-1">

                <!-- System Admins -->
                <a href="{{ route('admin.admins.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.admins.*') ? 'bg-white/10 text-white font-semibold' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admins.*') ? 'bg-white' : 'bg-blue-300' }}"></span>
                    System Admins
                </a>

                <!-- Scanners -->
                <a href="{{ route('admin.scanners.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.scanners.*') ? 'bg-white/10 text-white font-semibold' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.scanners.*') ? 'bg-white' : 'bg-blue-300' }}"></span>
                    Scanners
                </a>
            </div>
        </div>

        <!-- Global Settings -->
        <a href="{{ route('admin.settings.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.settings.*') ? 'opacity-100' : 'opacity-70' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Global Settings
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

        <!-- Messages/Inbox -->
        <a href="{{ route('admin.contacts.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-blue-100 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.contacts.*') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            Inbox
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