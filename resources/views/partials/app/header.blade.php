<nav class="fixed w-full z-[100] transition-all duration-500 bg-white/80 backdrop-blur-2xl border-b border-gray-100/50"
     x-data="{ 
        mobileMenuOpen: false, 
        scrolled: false,
        activeLink: '{{ request()->url() }}'
     }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     :class="{ 'py-2 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)]': scrolled, 'py-5': !scrolled }">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="flex justify-between items-center">
            
            <!-- Logo area -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <div class="relative w-10 h-10 flex items-center justify-center bg-dark text-white rounded-2xl group-hover:bg-primary transition-all duration-500 group-hover:rotate-[15deg]">
                        @if(isset($global_settings['site_logo']))
                            <img src="{{ asset('storage/' . $global_settings['site_logo']) }}" class="w-6 h-6 object-contain">
                        @else
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        @endif
                    </div>
                    <span class="font-heading font-black text-2xl tracking-tighter text-dark">{{ $global_settings['site_name'] ?? 'Anntix' }}<span class="text-primary">.</span></span>
                </a>
            </div>

            <!-- Desktop Navigation: Clean Editorial Style -->
            <div class="hidden md:flex items-center gap-12">
                <div class="flex items-center gap-10">
                    @php
                        $navLinks = [
                            ['name' => 'Home', 'route' => 'home'],
                            ['name' => 'Events', 'route' => 'events.index'],
                            ['name' => 'Schedule', 'route' => 'schedule.index'],
                            ['name' => 'Contact', 'route' => 'contact.index']
                        ];
                    @endphp

                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="relative py-2 text-[11px] font-black uppercase tracking-[0.3em] transition-all duration-500 group text-dark/60 hover:text-dark"
                           :class="{ 'text-primary': '{{ route($link['route']) }}' === activeLink }">
                            {{ $link['name'] }}
                            <!-- Editorial Underline -->
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-500 group-hover:w-full"
                                  :class="{ 'w-full': '{{ route($link['route']) }}' === activeLink }"></span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Right: Dynamic Auth/Action -->
            <div class="hidden md:flex items-center gap-8">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" 
                                class="flex items-center gap-3 py-1 group focus:outline-none">
                            <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center border-2 border-transparent group-hover:border-primary/30 transition-all duration-500">
                                <span class="font-black text-xs text-primary">{{ Auth::user()->initials() }}</span>
                            </div>
                            <div class="text-left">
                                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">Account</p>
                                <p class="text-xs font-black text-dark">{{ Str::limit(Auth::user()->name, 12) }}</p>
                            </div>
                        </button>

                        <!-- Premium Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 mt-4 w-56 bg-white rounded-[2rem] shadow-2xl py-6 border border-gray-100 z-50 overflow-hidden">
                            
                            <div class="px-8 mb-4">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Signed in as</p>
                                <p class="text-xs font-black text-dark truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="space-y-1">
                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-8 py-3 text-xs font-bold text-dark hover:bg-gray-50 hover:text-primary transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                
                                @if(Auth::user()->role === 'scanner')
                                    <a href="{{ route('scanner.index') }}" class="flex items-center gap-3 px-8 py-3 text-xs font-bold text-dark hover:bg-gray-50 hover:text-primary transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                        Scan Tickets
                                    </a>
                                @endif

                                <div class="h-px bg-gray-50 mx-8 my-2"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-8 py-3 text-xs font-bold text-red-500 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('contact.index') }}" 
                       class="px-8 py-3 bg-dark text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-primary transition-all duration-500 shadow-xl hover:-translate-y-1">
                        Get In Touch
                    </a>
                @endauth
            </div>

            <!-- Mobile: Minimalist Trigger -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-3 bg-gray-50 rounded-2xl text-dark hover:text-primary transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M4 16h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="md:hidden absolute top-24 inset-x-6 z-50">
        
        <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden p-8">
            <div class="space-y-6">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" 
                       class="block text-3xl font-black text-dark tracking-tighter hover:text-primary transition-colors">
                        {{ $link['name'] }}<span class="text-primary text-sm">.</span>
                    </a>
                @endforeach
                
                <div class="h-px bg-gray-100 my-8"></div>
                
                @auth
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black">
                            {{ Auth::user()->initials() }}
                        </div>
                        <div>
                            <p class="text-lg font-black text-dark">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-medium text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                @endauth

                <a href="{{ route('contact.index') }}" 
                   class="block w-full py-5 bg-dark text-white text-center font-black rounded-[1.5rem] tracking-widest text-sm uppercase">
                    Contact Us
                </a>

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full mt-4 py-4 text-center font-bold text-red-500">
                            Sign Out
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>