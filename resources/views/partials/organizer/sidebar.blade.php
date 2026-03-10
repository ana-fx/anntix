<div class="w-64 bg-gradient-to-b from-primary to-[#108c8d] text-white min-h-screen flex flex-col shadow-xl relative"
    x-data>
    <!-- Modern Creative Toggle Button (Desktop Only) -->
    <button @click="sidebarOpen = false"
        class="absolute left-full top-1/2 transform -translate-y-1/2 focus:outline-none z-50 group hidden lg:block"
        title="Collapse Sidebar">
        <div
            class="flex items-center justify-center w-4 h-12 bg-white text-gray-300 rounded-r-xl shadow-[4px_0_24px_rgba(0,0,0,0.1)] border-y border-r border-gray-100 group-hover:w-8 group-hover:text-primary transition-all duration-300 ease-out">
            <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
            </svg>
        </div>
    </button>

    <!-- Branding -->
    <div class="h-24 flex items-center justify-between px-6 md:px-8 border-b border-white/10">
        <div class="flex items-center gap-3">
            <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3">
                @if(isset($global_settings['site_logo_white']))
                    <img src="{{ asset('storage/' . $global_settings['site_logo_white']) }}" class="h-8 w-auto">
                @elseif(isset($global_settings['site_logo']))
                    <img src="{{ asset('storage/' . $global_settings['site_logo']) }}"
                        class="h-8 w-auto brightness-0 invert">
                @else
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <div class="w-2.5 h-2.5 bg-primary rounded-full"></div>
                    </div>
                    <span
                        class="text-lg font-bold tracking-wider uppercase">{{ $global_settings['site_name'] ?? 'ANTIX' }}</span>
                @endif
            </a>
        </div>

        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-white/70 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-8 px-4 flex flex-col gap-2 overflow-y-auto">
        <a href="{{ route('organizer.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.dashboard') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-teal-50 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('organizer.dashboard') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Dashboard
        </a>

        <!-- My Events (Dropdown) -->
        <div
            x-data="{ open: {{ request()->routeIs('organizer.events.*') || request()->routeIs('organizer.scanners.*') || request()->routeIs('organizer.resellers.*') || request()->routeIs('organizer.tickets.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.events.*') || request()->routeIs('organizer.scanners.*') || request()->routeIs('organizer.resellers.*') || request()->routeIs('organizer.tickets.*') ? 'bg-white/10 text-white font-semibold shadow-inner border border-white/10' : 'text-teal-50 hover:bg-white/10 font-medium' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('organizer.events.*') || request()->routeIs('organizer.scanners.*') || request()->routeIs('organizer.resellers.*') || request()->routeIs('organizer.tickets.*') ? 'opacity-100' : 'opacity-70' }}"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                    My Events
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
                <a href="{{ route('organizer.events.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.events.index') ? 'bg-white/10 text-white font-semibold' : 'text-teal-100 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('organizer.events.index') ? 'bg-white' : 'bg-teal-300/50' }}"></span>
                    Event
                </a>
                <a href="{{ route('organizer.tickets.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.tickets.index') ? 'bg-white/10 text-white font-semibold' : 'text-teal-100 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('organizer.tickets.index') ? 'bg-white' : 'bg-teal-300/50' }}"></span>
                    Ticket
                </a>
            </div>
        </div>

        <a href="{{ route('organizer.withdrawals.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.withdrawals.*') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-teal-50 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('organizer.withdrawals.*') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                <path fill-rule="evenodd"
                    d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                    clip-rule="evenodd" />
            </svg>
            Withdrawals
        </a>

        <!-- Reseller (Dropdown) -->
        <div
            x-data="{ open: {{ request()->routeIs('organizer.resellers.*') || request()->routeIs('organizer.reseller-management.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.resellers.*') || request()->routeIs('organizer.reseller-management.*') ? 'bg-white/10 text-white font-semibold shadow-inner border border-white/10' : 'text-teal-50 hover:bg-white/10 font-medium' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('organizer.resellers.*') || request()->routeIs('organizer.reseller-management.*') ? 'opacity-100' : 'opacity-70' }}"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Reseller
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
                <a href="{{ route('organizer.resellers.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.resellers.*') ? 'bg-white/10 text-white font-semibold' : 'text-teal-100 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('organizer.resellers.*') ? 'bg-white' : 'bg-teal-300/50' }}"></span>
                    Reseller Account
                </a>
                <a href="{{ route('organizer.reseller-management.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.reseller-management.index') ? 'bg-white/10 text-white font-semibold' : 'text-teal-100 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('organizer.reseller-management.index') ? 'bg-white' : 'bg-teal-300/50' }}"></span>
                    Reseller Management
                </a>
            </div>
        </div>

        <!-- Reports (Dropdown) -->
        <div x-data="{ open: {{ request()->routeIs('organizer.reports.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.reports.*') ? 'bg-white/10 text-white font-semibold' : 'text-teal-50 hover:bg-white/10 font-medium' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('organizer.reports.*') ? 'opacity-100' : 'opacity-70' }}"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    </svg>
                    Reports
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
                <a href="{{ route('organizer.reports.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.reports.index') ? 'bg-white/10 text-white font-semibold' : 'text-teal-100 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('organizer.reports.index') ? 'bg-white' : 'bg-teal-300/50' }}"></span>
                    General Report
                </a>

                <a href="{{ route('organizer.reports.transactions') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.reports.transactions') || request()->routeIs('organizer.reports.show') ? 'bg-white/10 text-white font-semibold' : 'text-teal-100 hover:text-white hover:bg-white/5' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('organizer.reports.transactions') || request()->routeIs('organizer.reports.show') ? 'bg-white' : 'bg-teal-300/50' }}"></span>
                    Transactions
                </a>

            </div>
        </div>

        <!-- My Profile -->
        <a href="{{ route('organizer.profile') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors {{ request()->routeIs('organizer.profile') ? 'bg-white/10 shadow-inner border border-white/10 font-semibold text-white' : 'text-teal-50 hover:bg-white/10 font-medium' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('organizer.profile') ? 'opacity-100' : 'opacity-70' }}"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            My Profile
        </a>

    </nav>

    <!-- User Section / Logout -->
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 px-4 py-3 mb-2">
            <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center font-black text-sm">
                {{ Auth::user()->initials() }}
            </div>
            <div class="min-w-0">
                <p class="text-white font-bold text-sm leading-none truncate">{{ Auth::user()->name }}</p>
                <p class="text-teal-100/50 text-xs font-bold mt-1 uppercase tracking-widest">Organizer</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-teal-50 hover:bg-white/10 hover:text-white transition-colors">
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