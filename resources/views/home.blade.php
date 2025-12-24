<x-layouts.app>
    <div class="bg-white min-h-screen pb-20">

        <!-- Main Banner Carousel -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div x-data="{ 
                    activeSlide: 0, 
                    slides: [
                        { img: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop', title: 'Grand Music Festival', discount: '30% OFF' },
                        { img: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=2070&auto=format&fit=crop', title: 'Electronic Dreams', discount: 'Early Bird' },
                        { img: 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?q=80&w=1000&auto=format&fit=crop', title: 'Night Life 2025', discount: 'Buy 1 Get 1' }
                    ],
                    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                    timer: null
                }" x-init="timer = setInterval(() => next(), 5000)" @mouseenter="clearInterval(timer)"
                @mouseleave="timer = setInterval(() => next(), 5000)"
                class="relative group rounded-3xl overflow-hidden shadow-2xl shadow-blue-900/10 aspect-[3/1] md:aspect-[3.5/1]">

                <!-- Slides -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index" x-transition:enter="transition transform duration-500 ease-out"
                        x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition transform duration-500 ease-in"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute inset-0 w-full h-full bg-dark">

                        <img :src="slide.img" class="w-full h-full object-cover opacity-60">

                        <!-- Banner Content Overlay (Mocking the promo style) -->
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <div class="max-w-3xl px-4 space-y-4">
                                <span
                                    class="inline-block px-4 py-1 rounded-full bg-accent text-black font-extrabold text-sm tracking-widest uppercase mb-2"
                                    x-text="slide.discount"></span>
                                <h2 class="text-4xl md:text-6xl font-heading font-extrabold text-white tracking-tight leading-tight"
                                    x-text="slide.title"></h2>
                                <p class="text-xl text-gray-200">The biggest event of the year is here. Don't miss out.
                                </p>
                                <button
                                    class="mt-6 px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/30">
                                    Get Tickets
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Navigation Arrows -->
                <button @click="prev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Pagination Dots -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index"
                            class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                            :class="activeSlide === index ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/80'">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Featured Events Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-heading font-bold text-dark">Featured Events</h2>
                <a href="#" class="text-sm font-bold text-primary hover:text-primary/80">View All</a>
            </div>

            <!-- Event List / Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    // MOCK DATA for display purposes if DB is empty or for specific design layout
                    $mockEvents = [
                        [
                            'title' => 'Sound of Java 2025',
                            'date' => '31 Dec 2025',
                            'location' => 'Istora Senayan, Jakarta',
                            'image' => 'https://images.unsplash.com/photo-1533174072545-e8d4aa97edf9?q=80&w=1000&auto=format&fit=crop',
                            'price' => 'Rp 150.000'
                        ],
                        [
                            'title' => 'Jazz Goes to Campus',
                            'date' => '15 Nov 2025',
                            'location' => 'UI Depok',
                            'image' => 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=1000&auto=format&fit=crop',
                            'price' => 'Rp 250.000'
                        ],
                        [
                            'title' => 'Indie Music Fest',
                            'date' => '20 Oct 2025',
                            'location' => 'Gambir Expo',
                            'image' => 'https://images.unsplash.com/photo-1459749411177-0473ef71607b?q=80&w=1000&auto=format&fit=crop',
                            'price' => 'Rp 75.000'
                        ],
                        [
                            'title' => 'Rock in Solo',
                            'date' => '05 Dec 2025',
                            'location' => 'Benteng Vastenburg',
                            'image' => 'https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?q=80&w=1000&auto=format&fit=crop',
                            'price' => 'Starting at Rp 100k'
                        ],
                    ];
                @endphp

                @foreach($mockEvents as $event)
                    <div
                        class="group bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                        <!-- Landscape Image -->
                        <div class="aspect-video relative overflow-hidden">
                            <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div
                                class="absolute top-3 right-3 bg-accent text-dark px-2 py-1 rounded text-xs font-bold shadow-sm">
                                New
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 space-y-3">
                            <div class="flex items-center gap-2 text-xs font-medium text-primary">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $event['date'] }}
                            </div>

                            <h3
                                class="font-bold text-dark leading-tight group-hover:text-primary transition-colors line-clamp-2">
                                {{ $event['title'] }}
                            </h3>

                            <div class="flex items-center gap-2 text-xs text-secondary">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $event['location'] }}
                            </div>

                            <div class="pt-3 border-t border-gray-50 mt-1 flex items-center justify-between">
                                <span class="text-xs text-secondary font-medium">Starts from</span>
                                <span class="font-extrabold text-dark text-sm">{{ $event['price'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Secondary Section (Optional - to fill space like image) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-12">
            <div
                class="bg-gray-50 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-8 border border-gray-100">
                <div class="space-y-4 max-w-2xl">
                    <h3 class="text-2xl font-bold font-heading text-dark">Become an Event Creator</h3>
                    <p class="text-secondary">Join thousands of successful organizers. Create, manage, and sell tickets
                        for your events easily with Anntix.</p>
                </div>
                <div class="flex gap-4">
                    <button
                        class="px-6 py-3 bg-white border border-gray-200 text-dark font-bold rounded-xl hover:bg-gray-50 transition-colors">Learn
                        More</button>
                    <button
                        class="px-6 py-3 bg-dark text-white font-bold rounded-xl hover:bg-dark/90 transition-colors shadow-lg shadow-dark/10">Create
                        Event</button>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>