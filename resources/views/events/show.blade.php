<x-layouts.app>
    <div class="bg-gray-50 min-h-screen pb-20">

        <!-- Hero Banner -->
        <div class="relative h-[400px] md:h-[500px] w-full overflow-hidden">
            <div class="absolute inset-0 bg-dark/50 z-10"></div>
            <img src="{{ $event->banner_path ?? $event->thumbnail_path ?? 'https://via.placeholder.com/1920x600' }}"
                alt="{{ $event->name }}" class="w-full h-full object-cover blur-sm scale-110">

            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div
                    class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-end gap-8 pb-12">
                    <!-- Thumbnail -->
                    <div
                        class="hidden md:block w-48 h-64 rounded-xl overflow-hidden shadow-2xl border-4 border-white shrink-0">
                        <img src="{{ $event->thumbnail_path ?? 'https://via.placeholder.com/400x600' }}"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Title & Basic Info -->
                    <div class="text-white space-y-4 flex-1">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 bg-accent text-dark rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $event->category ?? 'Event' }}
                        </div>
                        <h1
                            class="text-4xl md:text-5xl font-heading font-extrabold leading-tight shadow-black drop-shadow-lg">
                            {{ $event->name }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-6 text-sm md:text-base font-medium text-gray-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $event->start_date->format('l, d F Y') }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $event->start_date->format('H:i') }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $event->location }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-30">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-heading font-bold text-dark mb-6">About This Event</h2>
                        <div class="prose prose-blue max-w-none text-secondary">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    <!-- Organizer Info (Moved here) -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-heading font-bold text-dark mb-6">Organized By</h2>
                        <div class="flex items-center gap-6">
                            @if($event->organizer_logo_path)
                                <img src="{{ asset('storage/' . $event->organizer_logo_path) }}"
                                    alt="{{ $event->organizer_name }}"
                                    class="w-20 h-20 rounded-full object-cover border-4 border-gray-50">
                            @else
                                <div
                                    class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-3xl shadow-inner">
                                    {{ substr($event->organizer_name ?? 'A', 0, 1) }}
                                </div>
                            @endif

                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="font-bold text-dark text-xl">
                                        {{ $event->organizer_name ?? 'Anntix Official' }}</h3>
                                    <span
                                        class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-blue-100">Verified</span>
                                </div>
                                <p class="text-secondary mb-4">
                                    Creating unforgettable experiences on Anntix since
                                    {{ $event->created_at->format('Y') }}.
                                </p>
                                <button class="text-primary font-bold text-sm hover:underline">
                                    View Full Profile &rarr;
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Location / Map -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-heading font-bold text-dark mb-6">Location</h2>
                        <div class="space-y-4">
                            <h3 class="font-bold text-lg text-dark flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ $event->location }}
                            </h3>
                            <p class="text-secondary">{{ $event->address ?? $event->city . ', ' . $event->province }}
                            </p>

                            @if($event->google_map_embed)
                                <div class="w-full h-64 rounded-xl overflow-hidden border border-gray-200">
                                    {!! $event->google_map_embed !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Terms -->
                    @if($event->terms)
                        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                            <h2 class="text-2xl font-heading font-bold text-dark mb-6">Terms & Conditions</h2>
                            <div class="prose prose-sm max-w-none text-secondary">
                                {!! nl2br(e($event->terms)) !!}
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Right Column: Booking Card -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 bg-white rounded-3xl p-6 shadow-xl border border-gray-100">
                        <div class="text-center mb-6">
                            <h3 class="text-gray-500 font-medium text-sm uppercase tracking-wider mb-1">Ticket Price
                            </h3>
                            @if($event->ticket)
                                <div class="text-4xl font-extrabold text-primary">
                                    Rp {{ number_format($event->ticket->price, 0, ',', '.') }}
                                </div>
                            @else
                                <div class="text-3xl font-extrabold text-green-600">Free Event</div>
                            @endif
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center justify-between text-sm py-2 border-b border-gray-50">
                                <span class="text-secondary">Date</span>
                                <span class="font-bold text-dark">{{ $event->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm py-2 border-b border-gray-50">
                                <span class="text-secondary">Time</span>
                                <span class="font-bold text-dark">{{ $event->start_date->format('H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center justify-between text-sm py-2 border-b border-gray-50">
                                <span class="text-secondary">Organizer</span>
                                <span class="font-bold text-dark">{{ $event->organizer_name ?? 'Anntix' }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.create', $event) }}"
                            class="block w-full py-4 bg-primary text-center text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-primary/90 hover:-translate-y-1 transition-all active:scale-95 text-lg">
                            Buy Tickets Now
                        </a>

                        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Secure Transaction via Anntix Pay
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layouts.app>