<x-layouts.app>
    <!-- Header -->
    <div class="relative bg-dark pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 L100 0 L100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-heading font-bold mb-4">Discover Events</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">Found your next unforgettable experience.</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="border-b border-gray-100 bg-white sticky top-[80px] z-30 shadow-sm/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="{{ route('events.index') }}" method="GET"
                class="flex flex-col md:flex-row gap-4 items-center justify-between">

                <!-- Search -->
                <div class="relative w-full md:w-96">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search events, location..."
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-sm font-medium">
                </div>

                <!-- Filters -->
                <div class="flex w-full md:w-auto overflow-x-auto pb-2 md:pb-0 gap-3 no-scrollbar">

                    <!-- Category -->
                    <select name="category" onchange="this.form.submit()"
                        class="pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-dark focus:border-primary focus:ring-primary/20 cursor-pointer hover:border-primary/50 transition-colors min-w-[140px]">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    <!-- City -->
                    <select name="city" onchange="this.form.submit()"
                        class="pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-dark focus:border-primary focus:ring-primary/20 cursor-pointer hover:border-primary/50 transition-colors min-w-[140px]">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>

                    @if(request()->anyFilled(['search', 'category', 'city']))
                        <a href="{{ route('events.index') }}"
                            class="px-4 py-3 bg-gray-100 text-gray-500 hover:text-dark hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <a href="{{ route('events.show', $event) }}"
                    class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $event->thumbnail_path ?? 'https://via.placeholder.com/800x600' }}"
                            alt="{{ $event->name }}"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-dark shadow-sm">
                            {{ $event->category ?? 'General' }}
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-primary text-xs font-bold uppercase tracking-wider mb-2">
                            {{ $event->start_date->format('M d, Y • H:i') }}
                        </p>
                        <h3
                            class="text-xl font-heading font-bold text-dark group-hover:text-primary transition-colors mb-2 line-clamp-2">
                            {{ $event->name }}
                        </h3>
                        <p class="text-secondary text-sm flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ Str::limit($event->location, 30) }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-gray-500 text-sm font-medium">Starts from</span>
                            <span class="text-lg font-bold text-dark">
                                Rp {{ number_format($event->ticket->price ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-dark">No Events Found</h3>
                    <p class="text-gray-500 mt-2">Check back later for upcoming events.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $events->links() }}
        </div>
    </div>
</x-layouts.app>