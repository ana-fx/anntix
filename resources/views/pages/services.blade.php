<x-layouts.app>
    <!-- Hero Section -->
    <div class="relative bg-dark overflow-hidden min-h-[60vh] flex items-center">
        <!-- Abstract Background -->
        <div class="absolute inset-0">
            <div
                class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-primary/30 rounded-full blur-3xl opacity-50 mix-blend-screen animate-pulse">
            </div>
            <div
                class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-secondary/20 rounded-full blur-3xl opacity-40 mix-blend-screen">
            </div>
            <div
                class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 w-full py-20">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-8 leading-tight">
                    We Create <br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Unforgettable</span>
                    Experiences.
                </h1>
                <p class="text-xl text-gray-400 leading-relaxed max-w-2xl border-l-4 border-primary pl-6">
                    Anntix is more than a ticketing platform. We are the bridge between visionary creators and
                    passionate audiences, powering the events that shape culture.
                </p>
            </div>
        </div>
    </div>

    <!-- Features Grid (Masonry Style) -->
    <div class="bg-gray-50 py-24 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Feature 1: Large -->
                <div
                    class="lg:col-span-2 bg-white rounded-[2.5rem] p-10 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 group overflow-hidden relative">
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-dark mb-4 group-hover:text-primary transition-colors">Smart
                            Ticketing Engine</h3>
                        <p class="text-secondary text-lg leading-relaxed max-w-md">
                            Our proprietary algorithm ensures fair distribution, preventing scalping while providing a
                            seamless checkout experience that converts visitors into attendees in seconds.
                        </p>
                    </div>
                    <div
                        class="absolute right-0 bottom-0 opacity-10 transform translate-x-12 translate-y-12 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-64 h-64 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                </div>

                <!-- Feature 2: Tall -->
                <div class="bg-dark rounded-[2.5rem] p-10 shadow-xl relative overflow-hidden group text-white">
                    <div class="absolute inset-0 bg-gradient-to-br from-secondary to-dark opacity-50"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div
                                class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">Real-Time Data</h3>
                            <p class="text-gray-400">
                                Watch your event grow. Track sales, demographics, and check-ins as they happen.
                            </p>
                        </div>
                        <div class="mt-8 border-t border-white/10 pt-6">
                            <span class="text-sm font-bold uppercase tracking-widest text-primary">Analytics V2.0</span>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 group">
                    <div
                        class="w-16 h-16 bg-accent/10 text-accent rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-12 transition-transform">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4h-4v-4H8m16 0V9a2 2 0 00-2-2h-2m-4-1v1m0 0H8m4 0h4m-4-1V4m4 1v1m0 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">Secure Entry</h3>
                    <p class="text-secondary leading-relaxed">
                        Bank-grade QR encryption ensures that every ticket is unique and every entry is valid.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="lg:col-span-2 bg-gradient-to-r from-primary to-secondary rounded-[2.5rem] p-10 shadow-xl text-white relative overflow-hidden flex items-center">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20">
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 w-full">
                        <div>
                            <h3 class="text-3xl font-bold mb-2">Ready to Host?</h3>
                            <p class="text-white/80 text-lg">Join thousands of organizers transforming their events
                                today.</p>
                        </div>
                        <a href="{{ route('contact.index') }}"
                            class="px-8 py-4 bg-white text-primary font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                            Start Now
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>