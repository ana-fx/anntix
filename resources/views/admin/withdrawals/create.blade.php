<x-layouts.admin>
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <!-- Back Link -->
        <div>
            @if($event)
                <a href="{{ route('admin.events.withdrawals.show', $event) }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-primary transition-colors gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Withdrawals
                </a>
            @else
                <a href="{{ route('admin.withdrawals.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-primary transition-colors gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to All Withdrawals
                </a>
            @endif
        </div>

        @if(!$event)
            @php
                $platformRoutes = [];
                foreach($events as $e) {
                    $platformRoutes[$e->id] = route('admin.events.platform-withdrawals.store', $e);
                }
            @endphp

            <!-- Global Manual Payout Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8"
                x-data="{
                    type: 'organizer',
                    eventId: '',
                    platformRoutes: {{ json_encode($platformRoutes) }},
                    organizerRoute: '{{ route('admin.withdrawals.store') }}',
                    financials: {{ json_encode($eventFinancials) }},
                    get formAction() {
                        if (this.type === 'platform' && this.eventId) {
                            return this.platformRoutes[this.eventId] ?? '#';
                        }
                        return this.organizerRoute;
                    },
                    get selected() {
                        return this.eventId ? (this.financials[this.eventId] ?? null) : null;
                    }
                }">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-dark tracking-tight">Record Manual Payout</h1>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-2">Select payout type and event</p>
                </div>

                {{-- Payout Type Toggle --}}
                <div class="flex gap-1 bg-gray-100 rounded-2xl p-1.5 w-fit mb-8">
                    {{-- Organizer tab --}}
                    <button type="button" @click="type = 'organizer'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all">
                        <span x-show="type === 'organizer'" class="flex items-center gap-2 bg-primary text-white rounded-xl px-5 py-2.5 -mx-5 -my-2.5 shadow-sm">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Organizer Payout
                        </span>
                        <span x-show="type !== 'organizer'" class="flex items-center gap-2 text-gray-500 hover:text-dark px-5 py-2.5 -mx-5 -my-2.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Organizer Payout
                        </span>
                    </button>

                    {{-- Platform tab --}}
                    <button type="button" @click="type = 'platform'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all">
                        <span x-show="type === 'platform'" class="flex items-center gap-2 bg-primary text-white rounded-xl px-5 py-2.5 -mx-5 -my-2.5 shadow-sm">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Platform Revenue
                        </span>
                        <span x-show="type !== 'platform'" class="flex items-center gap-2 text-gray-500 hover:text-dark px-5 py-2.5 -mx-5 -my-2.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Platform Revenue
                        </span>
                    </button>
                </div>

                {{-- Context description --}}
                <div x-show="type === 'organizer'" x-cloak class="mb-6 p-4 bg-primary/5 border border-primary/20 rounded-2xl">
                    <p class="text-xs font-bold text-primary">Deduct from organizer's net balance — marks funds as transferred to the event organizer.</p>
                </div>
                <div x-show="type === 'platform'" x-cloak class="mb-6 p-4 bg-primary/5 border border-primary/20 rounded-2xl">
                    <p class="text-xs font-bold text-primary">Record platform income taken — bookkeeping only, does not affect organizer balance.</p>
                </div>

                <form :action="formAction" method="POST" class="space-y-6">
                    @csrf
                    <div x-show="type === 'organizer'" x-cloak>
                        <input type="hidden" name="event_id" :value="eventId">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Select Event</label>
                        <div class="relative" x-data="{ open: false, label: 'Choose an event...' }">
                            <button type="button" @click="open = !open" @click.away="open = false"
                                class="w-full flex items-center justify-between px-6 py-4 rounded-2xl bg-gray-50 text-sm font-bold border border-gray-100 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all">
                                <span x-text="label" :class="eventId === '' ? 'text-gray-400 font-medium' : 'text-dark'"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-50 w-full mt-2 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden" style="display:none;">
                                <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Select Event</span>
                                </div>
                                <div class="py-2 max-h-60 overflow-y-auto">
                                    @foreach($events as $e)
                                        <button type="button"
                                            @click="eventId = '{{ $e->id }}'; label = '{{ addslashes($e->name) }}'; open = false"
                                            class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark border-l-2 border-transparent hover:border-primary">
                                            {{ $e->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Balance Info --}}
                    <div x-show="selected" x-cloak>

                        {{-- Organizer balance --}}
                        <div x-show="type === 'organizer'" class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Net Revenue</div>
                                <div class="text-base font-black text-dark" x-text="selected ? 'Rp ' + Number(selected.org_net).toLocaleString('id-ID') : '-'"></div>
                            </div>
                            <div class="bg-emerald-50 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-emerald-500 mb-1">Already Withdrawn</div>
                                <div class="text-base font-black text-emerald-600" x-text="selected ? 'Rp ' + Number(selected.org_withdrawn).toLocaleString('id-ID') : '-'"></div>
                            </div>
                            <div class="bg-amber-50 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-amber-500 mb-1">Pending</div>
                                <div class="text-base font-black text-amber-500" x-text="selected ? 'Rp ' + Number(selected.org_pending).toLocaleString('id-ID') : '-'"></div>
                            </div>
                            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-primary/60 mb-1">Available Saldo</div>
                                <div class="text-base font-black text-primary" x-text="selected ? 'Rp ' + Number(selected.org_available).toLocaleString('id-ID') : '-'"></div>
                            </div>
                        </div>

                        {{-- Platform balance --}}
                        <div x-show="type === 'platform'" class="grid grid-cols-3 gap-3">
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Platform Income</div>
                                <div class="text-base font-black text-dark" x-text="selected ? 'Rp ' + Number(selected.platform_income).toLocaleString('id-ID') : '-'"></div>
                            </div>
                            <div class="bg-emerald-50 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-emerald-500 mb-1">Already Recorded</div>
                                <div class="text-base font-black text-emerald-600" x-text="selected ? 'Rp ' + Number(selected.platform_recorded).toLocaleString('id-ID') : '-'"></div>
                            </div>
                            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-4">
                                <div class="text-[9px] font-black uppercase tracking-widest text-primary/60 mb-1">Available to Record</div>
                                <div class="text-base font-black text-primary" x-text="selected ? 'Rp ' + Number(selected.platform_available).toLocaleString('id-ID') : '-'"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Amount (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                            <input type="number" name="amount" required min="1" step="1"
                                   class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-dark font-bold text-lg placeholder-gray-300 transition-all"
                                   placeholder="0">
                        </div>
                        <p x-show="selected && type === 'organizer'" x-cloak class="text-[10px] text-gray-400 font-bold mt-2 ml-1">
                            Max: Rp <span x-text="selected ? Number(selected.org_available).toLocaleString('id-ID') : '0'"></span>
                        </p>
                        <p x-show="selected && type === 'platform'" x-cloak class="text-[10px] text-gray-400 font-bold mt-2 ml-1">
                            Max: Rp <span x-text="selected ? Number(selected.platform_available).toLocaleString('id-ID') : '0'"></span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Note (Optional)</label>
                        <textarea name="note" rows="3"
                                  class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-dark font-bold placeholder-gray-300 transition-all resize-none"
                                  placeholder="Reference number, details, etc..."></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" x-show="type === 'organizer'"
                            class="w-full md:w-auto px-10 py-4 bg-primary text-white rounded-2xl font-black text-sm transition-all shadow-xl shadow-primary/20 uppercase tracking-widest hover:opacity-90">
                            Confirm Organizer Payout
                        </button>
                        <button type="submit" x-show="type === 'platform'"
                            class="w-full md:w-auto px-10 py-4 bg-primary text-white rounded-2xl font-black text-sm transition-all shadow-xl shadow-primary/20 uppercase tracking-widest hover:opacity-90">
                            Record Platform Revenue
                        </button>
                    </div>
                </form>
            </div>
        @else
            <!-- Event Specific History -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8" x-data="{ open: false }">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Withdrawal History - {{ $event->name }}
                    </h3>

                    <button @click="open = true"
                        class="px-5 py-2.5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition shadow-lg shadow-primary/20 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Record Payout
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase text-gray-400 font-black tracking-widest">
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Reference</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($withdrawals as $w)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-700">
                                        {{ $w->created_at->format('M d, Y • H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-dark">
                                        {{ $w->reference }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($w->status === 'approved')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Approved</span>
                                        @elseif($w->status === 'rejected')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black uppercase">Rejected</span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase animate-pulse">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-black text-red-500 text-sm">
                                        Rp {{ number_format($w->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.withdrawals.edit', $w) }}" class="p-2 text-gray-400 hover:text-primary bg-gray-50 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.withdrawals.destroy', $w) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 bg-gray-50 rounded-lg transition-all">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic font-bold">
                                        No withdrawals recorded for this event yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Event Specific Withdrawal Modal -->
                <div x-show="open" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-dark/60 backdrop-blur-sm p-4">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden relative" @click.away="open = false">
                        <form action="{{ route('admin.events.withdrawals.store_for_event', $event) }}" method="POST">
                            @csrf
                            <input type="hidden" name="from_event" value="1">
                            <div class="px-8 pt-8 pb-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-2xl font-black text-dark tracking-tight">Withdraw Funds</h3>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">{{ $event->name }}</p>
                                    </div>
                                    <button type="button" @click="open = false" class="text-gray-400 hover:text-dark transition-colors">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-6">
                                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                        <div class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Available Balance</div>
                                        <div class="text-xl font-black text-emerald-700">Rp {{ number_format($availableSaldo, 0, ',', '.') }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Withdrawal Amount (Rp)</label>
                                        <div class="relative">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                                            <input type="number" name="amount" required min="1" max="{{ $availableSaldo }}" step="0.01"
                                                   class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-dark text-lg placeholder-gray-300 transition-all font-black"
                                                   placeholder="0">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Internal Note (Optional)</label>
                                        <textarea name="note" rows="3"
                                                  class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-dark font-bold placeholder-gray-300 transition-all resize-none"
                                                  placeholder="Internal record details..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="px-8 pb-8">
                                <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-dark transition-all shadow-xl shadow-primary/20">
                                    Confirm Payout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.admin>

