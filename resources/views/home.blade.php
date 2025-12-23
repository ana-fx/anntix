<x-layouts.app>
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="relative bg-black rounded-[2.5rem] overflow-hidden min-h-[500px] flex items-center">
            <!-- Background Image Overlay -->
            <img src="https://images.unsplash.com/photo-1459749411177-0473ef71607b?q=80&w=2070&auto=format&fit=crop"
                 class="absolute inset-0 w-full h-full object-cover opacity-60"
                 alt="Concert Crowd">

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Left Content -->
                <div class="text-white space-y-6">
                    <h1 class="text-5xl lg:text-7xl font-heading font-bold leading-tight">
                        MADE FOR<br>
                        THOSE<br>
                        WHO DO
                    </h1>
                    <p class="text-gray-300 text-sm tracking-widest uppercase">Photos by Saepul Rohman</p>
                </div>

                <!-- Right Content (Cards) -->
                <div class="lg:flex lg:flex-col lg:items-end space-y-6 relative">

                    <!-- Date & Time Card (Floating) -->
                    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-sm w-full relative z-20 lg:-mr-10 lg:mt-10">
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold font-heading">Date & Time</h3>
                            <p class="text-gray-500">Saturday, Sep 14, 2019 at 20:30 PM</p>

                            <button class="flex items-center text-primary font-bold text-sm hover:underline">
                                <span class="text-xl mr-2">+</span> Add to Calendar
                            </button>

                            <button class="w-full py-4 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-violet-700 transition-colors">
                                Book Now (Free)
                            </button>

                            <button class="w-full py-4 bg-gray-100 text-gray-900 font-bold rounded-xl hover:bg-gray-200 transition-colors">
                                Promoter Program
                            </button>

                            <p class="text-center text-xs text-gray-400">No Refunds</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Search Bar Overlay at Bottom -->
            <div class="absolute bottom-10 left-6 right-6 lg:left-12 lg:right-auto max-w-4xl bg-[#1e1b2e]/90 backdrop-blur-md p-2 rounded-2xl flex flex-col md:flex-row gap-2 border border-white/10">
                 <div class="flex-1 px-6 py-4 border-b md:border-b-0 md:border-r border-white/10">
                    <label class="block text-xs text-gray-400 mb-1">Looking for</label>
                    <div class="text-white font-medium">UI UX Promotion</div>
                 </div>
                 <div class="flex-1 px-6 py-4 border-b md:border-b-0 md:border-r border-white/10">
                    <label class="block text-xs text-gray-400 mb-1">In</label>
                    <div class="text-white font-medium">Jakarta Selatan</div>
                 </div>
                 <div class="flex-1 px-6 py-4 flex justify-between items-center group cursor-pointer hover:bg-white/5 rounded-xl transition-colors">
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">When</label>
                        <div class="text-white font-medium">Any date</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                 </div>
            </div>

        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-bold font-heading">Upcoming Events</h2>

            <div class="flex gap-3">
                <button class="px-5 py-2 bg-gray-100 rounded-lg text-sm font-bold text-gray-700 flex items-center gap-2 hover:bg-gray-200">
                    Weekdays <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <button class="px-5 py-2 bg-gray-100 rounded-lg text-sm font-bold text-gray-700 flex items-center gap-2 hover:bg-gray-200">
                    Event Type <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <button class="px-5 py-2 bg-gray-100 rounded-lg text-sm font-bold text-gray-700 flex items-center gap-2 hover:bg-gray-200">
                    Any Category <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Event Card 1 -->
            <div class="group bg-white rounded-3xl p-4 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="relative rounded-2xl overflow-hidden h-48 mb-6">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Event">
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm">$10.00</div>
                    <div class="absolute top-4 right-4 flex gap-2">
                         <button class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg></button>
                         <button class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white text-red-500"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></button>
                    </div>
                </div>

                <div class="flex gap-4 px-2">
                    <div class="text-center">
                        <div class="text-xs font-bold text-primary uppercase tracking-wide">Sep</div>
                        <div class="text-2xl font-bold text-gray-900">18</div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1 group-hover:text-primary transition-colors">Indonesia - Korea Conference</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">Soehanna, Daerah Khusus Ibukota Yogyakarta, Indonesia</p>
                    </div>
                </div>
            </div>

             <!-- Event Card 2 -->
             <div class="group bg-white rounded-3xl p-4 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="relative rounded-2xl overflow-hidden h-48 mb-6">
                    <img src="https://images.unsplash.com/photo-1514525253440-b393452e8d26?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Event">
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm">FREE</div>
                     <div class="absolute top-4 right-4 flex gap-2">
                         <button class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg></button>
                         <button class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white text-red-500"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></button>
                    </div>
                </div>

                <div class="flex gap-4 px-2">
                    <div class="text-center">
                        <div class="text-xs font-bold text-primary uppercase tracking-wide">Sep</div>
                        <div class="text-2xl font-bold text-gray-900">17</div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1 group-hover:text-primary transition-colors">Dream World Wide in Jakarta</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">Soehanna, Daerah Khusus Ibukota Yogyakarta, Indonesia</p>
                    </div>
                </div>
            </div>

            <!-- Event Card 3 -->
            <div class="group bg-white rounded-3xl p-4 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="relative rounded-2xl overflow-hidden h-48 mb-6">
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Event">
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-lg text-xs font-bold shadow-sm">$12.00</div>
                    <div class="absolute top-4 right-4 flex gap-2">
                         <button class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg></button>
                         <button class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white text-red-500"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></button>
                    </div>
                </div>

                <div class="flex gap-4 px-2">
                    <div class="text-center">
                        <div class="text-xs font-bold text-primary uppercase tracking-wide">Sep</div>
                        <div class="text-2xl font-bold text-gray-900">16</div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1 group-hover:text-primary transition-colors">Pesta Kembang Api Terbesar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">Soehanna, Daerah Khusus Ibukota Yogyakarta, Indonesia</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Floating Sticky Ad/Checkout (Left Side - Desktop) -->
    <div class="hidden xl:block fixed bottom-10 left-10 w-72 z-40">
        <div class="bg-primary rounded-2xl p-6 text-white shadow-2xl shadow-primary/40">
            <h4 class="font-bold text-lg mb-2">General Admission</h4>
            <p class="text-xs opacity-80 mb-4">Sales end on Nov 27, 2019</p>
            <div class="text-2xl font-bold mb-4">$100 <span class="text-sm font-normal opacity-70 line-through">+$7.5 Free</span></div>
            <button class="w-full py-3 bg-white text-primary font-bold rounded-lg hover:bg-gray-100 transition-colors">
                Checkout Now
            </button>
        </div>
    </div>
</x-layouts.app>
