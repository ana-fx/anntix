<x-layouts.app>
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <!-- Left Column: Visual Summary (Sticky) -->
                <div class="lg:col-span-5 sticky top-24">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 bg-dark/40 group-hover:bg-dark/30 transition-colors z-10"></div>
                        <img src="{{ $event->thumbnail_path ?? 'https://via.placeholder.com/600x800' }}"
                            class="w-full aspect-[4/5] object-cover object-center transform group-hover:scale-105 transition-transform duration-700">

                        <!-- Content Overlay -->
                        <div class="absolute inset-0 z-20 p-8 flex flex-col justify-between text-white">
                            <div>
                                <div
                                    class="inline-block px-3 py-1 mb-4 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold uppercase tracking-widest">
                                    {{ $event->category ?? 'Event' }}
                                </div>
                                <h1
                                    class="text-4xl font-heading font-extrabold leading-tight shadow-black drop-shadow-lg">
                                    {{ $event->name }}
                                </h1>
                            </div>

                            <div class="space-y-4 bg-black/20 backdrop-blur-lg p-6 rounded-2xl border border-white/10">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-white/10 rounded-lg">
                                        <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-white/60 font-medium uppercase tracking-wider">Date</p>
                                        <p class="font-bold">{{ $event->start_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-white/10 rounded-lg">
                                        <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-white/60 font-medium uppercase tracking-wider">Location
                                        </p>
                                        <p class="font-bold line-clamp-1">{{ $event->location }}</p>
                                    </div>
                                </div>
                                <div class="pt-4 mt-4 border-t border-white/10 flex justify-between items-center">
                                    <span class="text-sm font-medium text-white/80">Ticket Price</span>
                                    <span class="text-2xl font-extrabold text-white">Rp
                                        {{ number_format($event->ticket->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Minimalist Form -->
                <div class="lg:col-span-7">
                    <form action="{{ route('checkout.store', $event) }}" method="POST" x-data="{
                        price: {{ $event->ticket->price }},
                        quantity: 1,
                        get total() { return this.price * this.quantity }
                    }" class="space-y-10">
                        @csrf

                        <!-- Header -->
                        <div>
                            <h2 class="text-3xl font-heading font-bold text-dark mb-2">Secure Your Spot</h2>
                            <p class="text-secondary">Fill in your details to receive your e-ticket instantly.</p>
                        </div>

                        <!-- Ticket Details / Quantity section -->
                        <div class="pb-8 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-dark">{{ $event->ticket->name }}</h3>
                                    <p class="text-sm text-secondary">
                                        {{ $event->ticket->description ?? 'Single Entry Ticket' }}
                                    </p>
                                </div>

                                <!-- Minimalist Stepper -->
                                <div
                                    class="flex items-center gap-4 bg-white shadow-sm border border-gray-100 rounded-full px-2 py-1.5">
                                    <button type="button" @click="if(quantity > 1) quantity--"
                                        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-50 text-secondary transition-colors font-bold text-lg">
                                        −
                                    </button>
                                    <span class="font-bold text-dark w-6 text-center text-lg" x-text="quantity">1</span>
                                    <input type="hidden" name="quantity" :value="quantity">
                                    <button type="button"
                                        @click="if(quantity < {{ $event->ticket->max_purchase_per_user ?? 5 }}) quantity++"
                                        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-50 text-secondary transition-colors font-bold text-lg">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Inputs Grid -->
                        <div class="grid grid-cols-1 gap-6">

                            <!-- NIK & Gender Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label
                                        class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2 ml-1">Identity
                                        Number (NIK)</label>
                                    <input type="text" inputmode="numeric" name="nik" maxlength="16" minlength="16"
                                        pattern="\d{16}"
                                        class="w-full bg-white border-b-2 border-gray-100 px-4 py-3 text-dark font-medium focus:outline-none focus:border-primary transition-all rounded-xl hover:bg-gray-50 focus:bg-white"
                                        placeholder="16-digit number" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                                </div>
                                <div class="group">
                                    <label
                                        class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2 ml-1">Gender</label>
                                    <div class="relative">
                                        <select name="gender"
                                            class="w-full bg-white border-b-2 border-gray-100 px-4 py-3 text-dark font-medium focus:outline-none focus:border-primary transition-all rounded-xl hover:bg-gray-50 focus:bg-white appearance-none cursor-pointer"
                                            required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-secondary pointer-events-none"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label
                                        class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2 ml-1">Full
                                        Name</label>
                                    <input type="text" name="name"
                                        class="w-full bg-white border-b-2 border-gray-100 px-4 py-3 text-dark font-medium focus:outline-none focus:border-primary transition-all rounded-xl hover:bg-gray-50 focus:bg-white"
                                        placeholder="John Doe" required>
                                </div>

                                <div class="group">
                                    <label
                                        class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2 ml-1">Email
                                        Address</label>
                                    <input type="email" name="email"
                                        class="w-full bg-white border-b-2 border-gray-100 px-4 py-3 text-dark font-medium focus:outline-none focus:border-primary transition-all rounded-xl hover:bg-gray-50 focus:bg-white"
                                        placeholder="john@example.com" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label
                                        class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2 ml-1">Phone
                                        Number</label>
                                    <input type="tel" name="phone"
                                        class="w-full bg-white border-b-2 border-gray-100 px-4 py-3 text-dark font-medium focus:outline-none focus:border-primary transition-all rounded-xl hover:bg-gray-50 focus:bg-white"
                                        placeholder="+62..." required
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                                </div>

                                <div class="group">
                                    <label
                                        class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2 ml-1">City
                                        of Residence</label>
                                    <input type="text" name="city"
                                        class="w-full bg-white border-b-2 border-gray-100 px-4 py-3 text-dark font-medium focus:outline-none focus:border-primary transition-all rounded-xl hover:bg-gray-50 focus:bg-white"
                                        placeholder="Jakarta" required>
                                </div>
                            </div>
                        </div>

                        <!-- Footer / Pay -->
                        <div class="pt-8 mt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-secondary font-medium">Total Payable</p>
                                <p class="text-3xl font-extrabold text-primary tracking-tight">
                                    Rp <span x-text="new Intl.NumberFormat('id-ID').format(total)"></span>
                                </p>
                            </div>
                            <button type="submit"
                                class="px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/30 hover:bg-primary/90 hover:scale-105 transition-all active:scale-95 flex items-center gap-2">
                                <span>Complete Order</span>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>

                        <p class="text-center text-xs text-gray-400 mt-4">
                            By continuing, you agree to the <a href="#" class="underline hover:text-dark">Terms of
                                Service</a> and <a href="#" class="underline hover:text-dark">Privacy Policy</a>.
                        </p>

                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>