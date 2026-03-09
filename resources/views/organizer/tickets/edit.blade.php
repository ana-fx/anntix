<x-layouts.organizer title="Edit Ticket">
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <div class="text-sm text-gray-400 mb-1">
                <a href="{{ route('organizer.events.show', $event) }}" class="hover:text-primary transition-colors">{{ $event->name }}</a>
                <span class="mx-1">/</span>
                <span class="text-dark font-bold">Edit Ticket</span>
            </div>
            <h1 class="text-2xl font-black text-dark tracking-tight">Edit Ticket</h1>
        </div>

        <form action="{{ route('organizer.events.tickets.update', [$event, $ticket]) }}" method="POST" class="space-y-6 pb-12">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">Ticket Information</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ticket Name</label>
                        <input type="text" name="name" value="{{ old('name', $ticket->name) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all placeholder-gray-400"
                            placeholder="Enter ticket name">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Price (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $ticket->price) }}" min="0"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Quota</label>
                            <input type="number" name="quota" value="{{ old('quota', $ticket->quota) }}" min="1"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Max Purchase / User</label>
                            <input type="number" name="max_purchase_per_user"
                                value="{{ old('max_purchase_per_user', $ticket->max_purchase_per_user) }}" min="1"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Max Scans</label>
                            <input type="number" name="max_scans" value="{{ old('max_scans', $ticket->max_scans) }}"
                                min="1"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div x-data
                            x-init="flatpickr($refs.startPicker, { enableTime: true, dateFormat: 'Y-m-d H:i', time_24hr: true, defaultDate: '{{ old('start_date', $ticket->start_date?->format('Y-m-d H:i')) }}', altInput: true, altFormat: 'd M Y, H:i', altInputClass: 'w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white cursor-pointer' })">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Sale Start Date</label>
                            <input x-ref="startPicker" type="text" name="start_date"
                                value="{{ old('start_date', $ticket->start_date?->format('Y-m-d H:i')) }}"
                                class="hidden">
                        </div>
                        <div x-data
                            x-init="flatpickr($refs.endPicker, { enableTime: true, dateFormat: 'Y-m-d H:i', time_24hr: true, defaultDate: '{{ old('end_date', $ticket->end_date?->format('Y-m-d H:i')) }}', altInput: true, altFormat: 'd M Y, H:i', altInputClass: 'w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white cursor-pointer' })">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Sale End Date</label>
                            <input x-ref="endPicker" type="text" name="end_date"
                                value="{{ old('end_date', $ticket->end_date?->format('Y-m-d H:i')) }}" class="hidden">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $ticket->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <label for="is_active" class="text-sm font-bold text-gray-700 select-none">Ticket is Published &
                            Available for Sale</label>
                    </div>
                </div>
            </div>

            <!-- Fees & Commissions (READ ONLY FOR ORGANIZER) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6"
                x-data="{ showFees: false }">
                <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Fees & Commission</h2>
                            <p class="text-xs text-red-500 font-bold uppercase tracking-wider mt-0.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Managed by Administrator
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="showFees = !showFees"
                        class="text-sm font-bold text-primary hover:primary-700 transition-colors">
                        <span x-text="showFees ? 'Hide' : 'View Details'"></span>
                    </button>
                </div>

                <div x-show="showFees" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Reseller Fee -->
                        <div class="space-y-4 p-4 bg-gray-50 rounded-xl border border-gray-100 opacity-75">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Reseller Fee</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Type</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ ucfirst($ticket->reseller_fee_type ?? 'Default') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Value</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ $ticket->reseller_fee_value ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Platform Fee Online -->
                        <div class="space-y-4 p-4 bg-gray-50 rounded-xl border border-gray-100 opacity-75">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Platform Fee (Online)</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Type</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ ucfirst($ticket->organizer_fee_online_type ?? 'Default') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Value</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ $ticket->organizer_fee_online ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Platform Fee Reseller -->
                        <div class="space-y-4 p-4 bg-gray-50 rounded-xl border border-gray-100 opacity-75">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Platform Fee (Reseller)</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Type</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ ucfirst($ticket->organizer_fee_reseller_type ?? 'Default') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Value</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ $ticket->organizer_fee_reseller ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Handling Fee -->
                        <div class="space-y-4 p-4 bg-gray-50 rounded-xl border border-gray-100 opacity-75">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Handling Fee</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Type</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ ucfirst($ticket->handling_fee_type ?? 'Default') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Value</label>
                                    <div class="mt-1 font-bold text-dark text-sm bg-white px-3 py-2 rounded-lg border border-gray-200">
                                        {{ $ticket->handling_fee_value ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('organizer.events.show', $event) }}"
                    class="px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                    Discard Changes
                </a>
                <button type="submit"
                    class="px-10 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-xl shadow-primary/25 active:scale-[0.98]">
                    Save Ticket Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.organizer>
