<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-8 pb-12">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-dark tracking-tight">Withdrawal Report</h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-2">Revenue & balance across all events</p>
            </div>
            <a href="{{ route('admin.withdrawals.create') }}"
                class="px-5 py-3 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-dark transition-all shadow-lg shadow-primary/20 flex items-center gap-2 self-start md:self-auto">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Record Manual Payout
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
            {{-- Gross Revenue --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Gross Revenue</div>
                <div class="text-xl font-black text-dark">Rp {{ number_format($totals['gross_revenue'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold mt-1">Ticket price × qty</div>
            </div>
            {{-- Platform Fee --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Platform Fee</div>
                <div class="text-xl font-black text-primary">Rp {{ number_format($totals['total_platform_income'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold mt-1">Handling + organizer tax</div>
            </div>
            {{-- Organizer Net --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Organizer Net</div>
                <div class="text-xl font-black text-dark">Rp {{ number_format($totals['net_revenue'], 0, ',', '.') }}</div>
                <div class="mt-2 space-y-1">
                    <div class="flex justify-between text-[10px] font-bold">
                        <span class="text-gray-400">Withdrawn</span>
                        <span class="text-emerald-600">Rp {{ number_format($totals['withdrawn_approved'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold">
                        <span class="text-gray-400">Pending</span>
                        <span class="text-amber-500">Rp {{ number_format($totals['withdrawn_pending'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            {{-- Available to Withdraw --}}
            <div class="bg-primary/5 border border-primary/20 rounded-2xl shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-primary/60 mb-2">Available to Withdraw</div>
                <div class="text-xl font-black text-primary">Rp {{ number_format($totals['available_saldo'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-primary/50 font-bold mt-1">Across all events</div>
            </div>
        </div>

        {{-- Events Report Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-sm font-black text-dark uppercase tracking-wider">Report Per Event</h2>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Click "Detail" to view history & process withdrawals</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4 text-right">Gross Revenue</th>
                            <th class="px-6 py-4 text-right">Platform Fee</th>
                            <th class="px-6 py-4 text-right">Net to Organizer</th>
                            <th class="px-6 py-4 text-right">Withdrawn</th>
                            <th class="px-6 py-4 text-right">Available</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($events as $event)
                            @php $f = $event->financial; @endphp
                            <tr class="hover:bg-primary/[0.02] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-black text-dark text-sm group-hover:text-primary transition-colors">
                                        {{ $event->name }}
                                    </div>
                                    <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">
                                        {{ $event->organizer->name ?? $event->organizer_name ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-bold text-dark text-sm">Rp {{ number_format($f['gross_revenue'], 0, ',', '.') }}</div>
                                    <div class="text-[9px] text-gray-400 font-bold mt-0.5">Online: Rp {{ number_format($f['online_revenue'], 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-primary text-sm">
                                    Rp {{ number_format($f['total_platform_income'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-bold text-dark text-sm">Rp {{ number_format($f['net_revenue'], 0, ',', '.') }}</div>
                                    @if($f['withdrawn_pending'] > 0)
                                        <div class="text-[9px] text-amber-500 font-bold mt-0.5">{{ number_format($f['withdrawn_pending'], 0, ',', '.') }} pending</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-emerald-600 text-sm">
                                    Rp {{ number_format($f['withdrawn_approved'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-black text-sm {{ $f['available_saldo'] > 0 ? 'text-primary' : 'text-gray-400' }}">
                                        Rp {{ number_format($f['available_saldo'], 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right" x-data="{ showPlatform: false }">
                                    <div class="flex items-center justify-end gap-1">
                                        {{-- View Detail --}}
                                        <a href="{{ route('admin.events.withdrawals.show', $event) }}"
                                            class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all inline-flex" title="View Detail">
                                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>

                                        {{-- Record EO Withdrawal --}}
                                        @if($f['available_saldo'] > 0)
                                            <a href="{{ route('admin.events.withdrawals.create_for_event', $event) }}"
                                                class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all inline-flex" title="Record EO Withdrawal">
                                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Record Platform Revenue --}}
                                        @if($f['platform_available'] > 0)
                                            <button @click="showPlatform = true"
                                                class="p-2 text-gray-400 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-all" title="Record Platform Revenue">
                                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            {{-- Platform Revenue Modal --}}
                                            <div x-show="showPlatform" style="display:none;"
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-dark/60 backdrop-blur-sm p-4"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8" @click.away="showPlatform = false">
                                                    <div class="flex items-center gap-4 mb-6">
                                                        <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center shrink-0">
                                                            <svg class="w-6 h-6 text-violet-600" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-lg font-black text-dark">Record Platform Revenue</h3>
                                                            <p class="text-xs text-gray-500 font-bold mt-0.5">{{ $event->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="bg-violet-50 rounded-2xl p-4 mb-6">
                                                        <div class="flex justify-between text-xs">
                                                            <span class="text-gray-500 font-bold">Available</span>
                                                            <span class="font-black text-violet-700">Rp {{ number_format($f['platform_available'], 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('admin.events.platform-withdrawals.store', $event) }}" method="POST" class="space-y-4">
                                                        @csrf
                                                        <div>
                                                            <label class="block text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Amount</label>
                                                            <input type="number" name="amount" min="1" max="{{ $f['platform_available'] }}" step="1" required
                                                                placeholder="Enter amount..."
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-dark focus:outline-none focus:border-violet-400 focus:ring-2 focus:ring-violet-100 transition-all">
                                                        </div>
                                                        <div>
                                                            <label class="block text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Note (optional)</label>
                                                            <input type="text" name="note" maxlength="500"
                                                                placeholder="e.g. Transfer April 2026..."
                                                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-dark focus:outline-none focus:border-violet-400 focus:ring-2 focus:ring-violet-100 transition-all">
                                                        </div>
                                                        <div class="flex gap-3 pt-2">
                                                            <button type="button" @click="showPlatform = false"
                                                                class="flex-1 py-3 rounded-2xl border border-gray-200 text-gray-600 font-black text-sm hover:bg-gray-50 transition-all">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="flex-1 py-3 rounded-2xl bg-violet-500 text-white font-black text-sm hover:bg-violet-600 transition-all shadow-lg shadow-violet-500/20">
                                                                Save Record
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-20 text-center">
                                    <p class="text-sm font-bold text-gray-400">Belum ada event.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
