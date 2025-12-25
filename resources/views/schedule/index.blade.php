<x-layouts.app>
    <!-- Header -->
    <div class="bg-dark pt-32 pb-20 relative overflow-hidden">
        <!-- Abstract Background -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                 <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-heading font-black text-white mb-4 tracking-tight">Event Schedule</h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">Plan your experience. Don't miss a beat.</p>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        @forelse($events as $date => $dayEvents)
            <div class="mb-16 last:mb-0 relative">
                <!-- Date Header -->
                <div class="sticky top-24 z-20 bg-gray-50/95 backdrop-blur-sm py-4 mb-8 border-b border-gray-200">
                    <div class="flex items-baseline gap-4">
                        <h2 class="text-4xl font-heading font-black text-dark">
                            {{ \Carbon\Carbon::parse($date)->format('d') }}
                        </h2>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-dark">{{ \Carbon\Carbon::parse($date)->format('F Y') }}</span>
                            <span class="text-sm font-medium text-primary uppercase tracking-widest">{{ \Carbon\Carbon::parse($date)->format('l') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Items -->
                <div class="space-y-8 pl-4 md:pl-8 border-l-2 border-dashed border-gray-200 ml-4 md:ml-6 relative">
                    @foreach($dayEvents as $event)
                        <div class="relative group">
                            <!-- Dot -->
                            <div class="absolute -left-[25px] md:-left-[41px] top-6 w-4 h-4 rounded-full bg-white border-4 border-primary shadow-sm group-hover:scale-125 transition-transform duration-300"></div>

                            <a href="{{ route('events.show', $event) }}" class="block bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:border-primary/20 transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex flex-col md:flex-row gap-6 md:items-center">
                                    
                                    <!-- Time -->
                                    <div class="flex-shrink-0 md:w-32 text-left md:text-right">
                                        <div class="text-2xl font-bold text-dark font-mono">{{ $event->start_date->format('H:i') }}</div>
                                        <div class="text-sm text-gray-400 font-medium">{{ $event->end_date->format('H:i') }}</div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                                                {{ $event->category }}
                                            </span>
                                            @if($event->ticket && $event->ticket->price == 0)
                                                 <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider">Free</span>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-heading font-bold text-dark group-hover:text-primary transition-colors mb-2">
                                            {{ $event->name }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-secondary text-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $event->location }}
                                        </div>
                                    </div>

                                    <!-- Action -->
                                    <div class="hidden md:block">
                                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-dark mb-2">No Scheduled Events</h2>
                <p class="text-gray-500">Check back later for updates to the timeline.</p>
            </div>
        @endforelse

    </div>
</x-layouts.app>
