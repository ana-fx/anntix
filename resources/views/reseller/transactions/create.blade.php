<x-layouts.reseller title="Buy Tickets: {{ $event->name }}">
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('reseller.dashboard') }}"
                    class="flex items-center gap-2 text-primary hover:text-dark transition-colors mb-2 text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
                <h1 class="text-3xl font-black text-dark uppercase tracking-tight">Buy Tickets</h1>
                <p class="text-primary mt-1">Purchase tickets for customers for <strong>{{ $event->name }}</strong>.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <!-- Event Info (Left) -->
                <div class="lg:col-span-4">
                    <div class="rounded-2xl overflow-hidden shadow-lg mb-6">
                        <img src="{{ $event->thumbnail_path ? Storage::url($event->thumbnail_path) : 'https://via.placeholder.com/600x600' }}"
                            class="w-full aspect-square object-cover">
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-gray-50 rounded-lg text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Date</p>
                                <p class="font-bold text-dark">{{ $event->start_date->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-gray-50 rounded-lg text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Location</p>
                                <p class="font-bold text-dark">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Form (Right) -->
                <div class="lg:col-span-8">
                    <form action="{{ route('reseller.transactions.store', $event) }}" method="POST" x-data='{
                        tickets: {{ $event->tickets->map(function ($t) {
    $available = $t->quota - (($t->paid_qty ?? 0) + ($t->pending_qty ?? 0));
    return [
        "id" => $t->id,
        "name" => $t->name,
        "price" => (int) $t->price,
        "limit" => (int) $t->max_purchase_per_user,
        "description" => $t->description,
        "quota" => max(0, $available)
    ];
})->toJson() }},
                        handlingFee: {{ (int) \App\Models\Setting::getValue("handling_fee", 0) }},
                        selectedTicketId: null,
                        selectedTicket: null,
                        quantity: 1,
                        
                        init() {
                             const available = this.tickets.find(t => t.quota > 0);
                             if(available) this.selectTicket(available.id);
                        },

                        selectTicket(id) {
                            this.selectedTicketId = id;
                            this.selectedTicket = this.tickets.find(t => t.id === id);
                            this.quantity = 1;
                        },

                        get total() { 
                            return this.selectedTicket ? ((this.selectedTicket.price + this.handlingFee) * this.quantity) : 0; 
                        }
                    }' class="space-y-8">
                        @csrf
                        <input type="hidden" name="ticket_id" :value="selectedTicketId">

                        <!-- Stock/Availability Notifications -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-rose-500 flex items-center justify-center text-white flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1 pt-0.5">
                                    <h4 class="text-sm font-black text-rose-900 uppercase tracking-widest mb-1">Error</h4>
                                    @foreach ($errors->all() as $error)
                                        <p class="text-xs font-bold text-rose-600/80">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Ticket Selection -->
                        <div class="space-y-4">
                            <h3 class="font-bold text-dark">1. Select Ticket</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <template x-for="ticket in tickets" :key="ticket.id">
                                    <div @click="if(ticket.quota > 0) selectTicket(ticket.id)"
                                        class="cursor-pointer border-2 rounded-xl p-4 transition-all" :class="[
                                            selectedTicketId === ticket.id ? 'border-primary bg-primary/5' : 'border-gray-100 hover:border-gray-200',
                                            ticket.quota === 0 ? 'opacity-50 cursor-not-allowed bg-gray-50' : ''
                                        ]">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h4 class="font-bold text-dark" x-text="ticket.name"></h4>
                                                <p class="text-xs text-primary mt-1"
                                                    x-text="ticket.description || 'Entry Ticket'"></p>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-bold text-primary"
                                                    x-text="ticket.price == 0 ? 'Free' : 'Rp ' + new Intl.NumberFormat('id-ID').format(ticket.price)">
                                                </div>
                                                <div class="text-xs font-medium"
                                                    :class="ticket.quota > 0 ? 'text-green-600' : 'text-red-500'"
                                                    x-text="ticket.quota > 0 ? 'Available' : 'Sold Out'"></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="space-y-4" x-show="selectedTicket">
                            <h3 class="font-bold text-dark">2. Quantity</h3>
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex items-center gap-4 bg-gray-50 border border-gray-100 rounded-xl px-2 py-1.5">
                                    <button type="button" @click="if(quantity > 1) quantity--"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white text-primary transition-colors font-bold text-lg">−</button>
                                    <span class="font-bold text-dark w-8 text-center" x-text="quantity">1</span>
                                    <input type="hidden" name="quantity" :value="quantity">
                                    <button type="button" @click="if(quantity < selectedTicket.limit) quantity++"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white text-primary transition-colors font-bold text-lg">+</button>
                                </div>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Max: <span
                                        x-text="selectedTicket?.limit"></span></span>
                            </div>
                        </div>

                        <!-- Basic Customer Details -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="font-bold text-dark mb-4">3. Customer Details</h3>
                                <p class="text-xs text-primary mb-4">Enter the details of the customer who will This is
                                    a test
                                    receive the ticket.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Identity
                                        Number (NIK)</label>
                                    <input type="text" inputmode="numeric" name="nik" maxlength="16" minlength="16"
                                        pattern="\d{16}"
                                        class="w-full bg-gray-50 border-none px-4 py-3 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all rounded-xl"
                                        placeholder="16-digit number" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                                </div>
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Gender</label>
                                    <div class="relative">
                                        <select name="gender"
                                            class="w-full bg-gray-50 border-none px-4 py-3 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all rounded-xl appearance-none cursor-pointer"
                                            required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
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
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Full
                                        Name</label>
                                    <input type="text" name="name"
                                        class="w-full bg-gray-50 border-none px-4 py-3 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all rounded-xl"
                                        placeholder="John Doe" required>
                                </div>
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Email
                                        Address</label>
                                    <input type="email" name="email"
                                        class="w-full bg-gray-50 border-none px-4 py-3 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all rounded-xl"
                                        placeholder="john@example.com" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone
                                        Number</label>
                                    <input type="tel" name="phone" maxlength="15"
                                        class="w-full bg-gray-50 border-none px-4 py-3 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all rounded-xl"
                                        placeholder="+62..." required
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                                </div>
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">City
                                        of Residence</label>
                                    <input type="text" name="city"
                                        class="w-full bg-gray-50 border-none px-4 py-3 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all rounded-xl"
                                        placeholder="Jakarta" required>
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="pt-8 border-t border-gray-100">
                            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total
                                        Payment</p>
                                    <p class="text-3xl font-black text-primary tracking-tight">
                                        Rp <span x-text="new Intl.NumberFormat('id-ID').format(total)"></span>
                                    </p>
                                </div>
                                <button type="submit" :disabled="!selectedTicket"
                                    :class="!selectedTicket ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary/90 hover:scale-105 active:scale-95'"
                                    class="w-full md:w-auto px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/30 transition-all flex items-center justify-center gap-2">
                                    <span>Process Payment</span>
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.reseller>