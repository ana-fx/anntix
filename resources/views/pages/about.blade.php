<x-layouts.app title="About Us">
    <div class="bg-white min-h-screen">
        <!-- Minimalist Hero -->
        <div class="pt-40 pb-24 relative overflow-hidden bg-dark">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 L100 0 L100 100 Z" fill="white"></path>
                </svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-[0.2em] mb-8 border border-primary/20">
                    Our Story
                </div>
                <h1 class="text-6xl md:text-8xl font-heading font-black text-white tracking-tighter leading-none mb-8">
                    Defining the <br>
                    <span class="text-primary italic">Future.</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    At Anntix, we believe events are more than just gatherings—they are milestones of human connection.
                </p>
            </div>
        </div>

        <!-- Vision Section -->
        <div class="py-32 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div>
                        <div class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-6">Our Mission
                        </div>
                        <h2
                            class="text-4xl md:text-5xl font-heading font-black text-dark tracking-tighter leading-tight mb-8">
                            Empowering event organizers with seamless technology.
                        </h2>
                        <p class="text-lg text-black/70 leading-relaxed mb-10">
                            Founded in 2024, Anntix was born from a simple observation: the process of discovering and
                            attending events should be as inspiring as the events themselves.
                            We've built a platform that bridges the gap between organizers and attendees through
                            elegant, robust integration.
                        </p>

                        <div class="grid grid-cols-2 gap-10">
                            <div>
                                <div class="text-3xl font-black text-dark tracking-tighter mb-1">10k+</div>
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tickets Sold
                                </div>
                            </div>
                            <div>
                                <div class="text-3xl font-black text-dark tracking-tighter mb-1">50+</div>
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Global Partners
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-[4/5] rounded-[3rem] overflow-hidden bg-gray-100 shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop"
                                class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-10 -left-10 w-48 h-48 bg-primary rounded-full filter blur-3xl opacity-20">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="py-32 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <h2 class="text-4xl font-heading font-black text-dark tracking-tighter">The Anntix DNA</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="p-10 bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100">
                        <div
                            class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-dark mb-4">Speed Control</h3>
                        <p class="text-gray-500 leading-relaxed">Millisecond-level precision in ticket processing and
                            distribution.</p>
                    </div>
                    <div class="p-10 bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100">
                        <div
                            class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-dark mb-4">Ironclad Security</h3>
                        <p class="text-gray-500 leading-relaxed">Our advanced encryption ensures that your data and
                            payments are always protected.</p>
                    </div>
                    <div class="p-10 bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100">
                        <div
                            class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-dark mb-4">Human First</h3>
                        <p class="text-gray-500 leading-relaxed">Technology is just a tool; the experience of our users
                            is the real goal.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Join Us -->
        <div class="py-32 bg-dark">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <h2 class="text-5xl md:text-6xl font-heading font-black tracking-tighter mb-10">Ready to start your
                    journey?</h2>
                <a href="{{ route('events.index') }}"
                    class="inline-block px-12 py-5 bg-primary text-white font-black rounded-2xl shadow-2xl hover:-translate-y-1 transition-all">
                    Browse Events
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>