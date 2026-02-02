<x-layouts.admin>
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Edit Ticket for {{ $event->name }}</h2>

        <form action="{{ route('admin.tickets-report.update', $ticket) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">

                <!-- Ticket Event (Readonly) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ticket Event</label>
                    <input type="text" value="{{ $event->name }}" disabled
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Status -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $ticket->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 rounded text-primary focus:ring-primary/20 border-gray-300">
                    <label for="is_active" class="text-sm font-bold text-gray-700 select-none cursor-pointer">Active
                        Ticket</label>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $ticket->name) }}" placeholder="Enter Name"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Price</label>
                    <input type="number" name="price" value="{{ old('price', $ticket->price) }}"
                        placeholder="Enter Price" step="1"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    <p class="text-xs text-gray-500 mt-1">* Input 0 to set free ticket</p>
                    @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Quota -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Quota</label>
                    <input type="number" name="quota" value="{{ old('quota', $ticket->quota) }}"
                        placeholder="Enter Quota"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @error('quota') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Maximum Purchase User -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Maximum Purchase User</label>
                    <input type="number" name="max_purchase_per_user"
                        value="{{ old('max_purchase_per_user', $ticket->max_purchase_per_user) }}"
                        placeholder="Enter Maximum Purchase User"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @error('max_purchase_per_user') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sale Period -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div x-data
                        x-init="flatpickr($refs.picker, { enableTime: true, dateFormat: 'Y-m-d H:i', time_24hr: true, defaultDate: '{{ old('start_date', $ticket->start_date->format('Y-m-d H:i')) }}' })">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sale Start Date</label>
                        <input x-ref="picker" type="text" name="start_date"
                            value="{{ old('start_date', $ticket->start_date->format('Y-m-d H:i')) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white cursor-pointer">
                        @error('start_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data
                        x-init="flatpickr($refs.picker, { enableTime: true, dateFormat: 'Y-m-d H:i', time_24hr: true, defaultDate: '{{ old('end_date', $ticket->end_date->format('Y-m-d H:i')) }}' })">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sale End Date</label>
                        <input x-ref="picker" type="text" name="end_date"
                            value="{{ old('end_date', $ticket->end_date->format('Y-m-d H:i')) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white cursor-pointer">
                        @error('end_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Enter Description"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('description', $ticket->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-1 md:col-span-2 border-t border-gray-100 my-6"></div>

                <div
                    x-data="{ showFees: {{ $ticket->organizer_fee_online !== null || $ticket->organizer_fee_reseller !== null ? 'true' : 'false' }} }">
                    <button type="button" @click="showFees = !showFees"
                        class="flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-primary transition-colors mb-4">
                        <svg class="w-4 h-4 transition-transform duration-200" :class="showFees ? 'rotate-90' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Advanced: Custom Organizer Fees (Optional)
                    </button>

                    <div x-show="showFees" x-transition
                        class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-500 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Leave clear/empty to use Event Default settings. Only fill this if you want to override
                                fees for this specific ticket.
                            </p>
                        </div>

                        <!-- Online Fee -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Organizer Fee (Online)
                                Type</label>
                            <select name="organizer_fee_online_type"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white cursor-pointer">
                                <option value="">Use Event Default</option>
                                <option value="fixed" {{ old('organizer_fee_online_type', $ticket->organizer_fee_online_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ old('organizer_fee_online_type', $ticket->organizer_fee_online_type) == 'percent' ? 'selected' : '' }}>Percent (%)
                                </option>
                            </select>
                            @error('organizer_fee_online_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Organizer Fee (Online)
                                Value</label>
                            <input type="number" name="organizer_fee_online"
                                value="{{ old('organizer_fee_online', $ticket->organizer_fee_online) }}" min="0"
                                step="0.01" placeholder="Leave empty for default"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            @error('organizer_fee_online') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reseller Fee -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Organizer Fee (Reseller)
                                Type</label>
                            <select name="organizer_fee_reseller_type"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white cursor-pointer">
                                <option value="">Use Event Default</option>
                                <option value="fixed" {{ old('organizer_fee_reseller_type', $ticket->organizer_fee_reseller_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ old('organizer_fee_reseller_type', $ticket->organizer_fee_reseller_type) == 'percent' ? 'selected' : '' }}>Percent (%)
                                </option>
                            </select>
                            @error('organizer_fee_reseller_type') <p class="text-xs text-red-500 mt-1">{{ $message }}
                            </p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Organizer Fee (Reseller)
                                Value</label>
                            <input type="number" name="organizer_fee_reseller"
                                value="{{ old('organizer_fee_reseller', $ticket->organizer_fee_reseller) }}" min="0"
                                step="0.01" placeholder="Leave empty for default"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            @error('organizer_fee_reseller') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- Submit -->
                <div class="flex justify-end pt-4 pb-12">
                    <button type="submit"
                        class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/25 text-lg w-full md:w-auto">
                        Update Ticket
                    </button>
                </div>

        </form>
    </div>
</x-layouts.admin>