<x-layouts.organizer>
    <x-slot name="title">Withdrawals Overview</x-slot>

    <div>
        <div class="mb-8">
            <h2 class="text-3xl font-black text-dark tracking-tight">Withdrawals</h2>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">Financial summary across all events</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Global Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4 mb-10">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 col-span-2 md:col-span-1 xl:col-span-1">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Total Gross Revenue</div>
                <div class="text-xl font-black text-dark leading-tight">Rp {{ number_format($totals['gross_revenue'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold mt-1">All events</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Net Revenue</div>
                <div class="text-xl font-black text-dark leading-tight">Rp {{ number_format($totals['net_revenue'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold mt-1">Total withdrawable</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Withdrawn</div>
                <div class="text-xl font-black text-emerald-600 leading-tight">Rp {{ number_format($totals['withdrawn_approved'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-emerald-400 font-bold mt-1 uppercase tracking-wider">Approved</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Pending</div>
                <div class="text-xl font-black text-amber-500 leading-tight">Rp {{ number_format($totals['withdrawn_pending'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-amber-400 font-bold mt-1 uppercase tracking-wider">Awaiting</div>
            </div>
            <div class="bg-primary/5 border border-primary/20 rounded-2xl shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-primary/60 mb-2">Total Available</div>
                <div class="text-xl font-black text-primary leading-tight">Rp {{ number_format($totals['available_saldo'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-primary/50 font-bold mt-1">Withdrawable</div>
            </div>
        </div>

        {{-- Event Balances Table --}}
        <div class="mb-10">
            <div class="mb-5">
                <h3 class="text-lg font-black text-dark tracking-tight uppercase">Event Balances</h3>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Financial breakdown per event</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                <th class="px-6 py-4">Event</th>
                                <th class="px-6 py-4 text-right">Gross Revenue</th>
                                <th class="px-6 py-4 text-right">Net Revenue</th>
                                <th class="px-6 py-4 text-right">Withdrawn</th>
                                <th class="px-6 py-4 text-right">Pending</th>
                                <th class="px-6 py-4 text-right">Available</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($events as $event)
                                @php $f = $event->financial; @endphp
                                <tr class="hover:bg-primary/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-black text-dark text-sm group-hover:text-primary transition-colors truncate max-w-[200px]" title="{{ $event->name }}">
                                            {{ $event->name }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">
                                            {{ $f['online_tickets_sold'] + $f['reseller_tickets_sold'] }} tickets sold
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-dark text-sm">
                                        Rp {{ number_format($f['gross_revenue'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-dark text-sm">
                                        Rp {{ number_format($f['net_revenue'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-sm">
                                        Rp {{ number_format($f['withdrawn_approved'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-amber-500 text-sm">
                                        Rp {{ number_format($f['withdrawn_pending'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-sm {{ $f['available_saldo'] > 0 ? 'text-primary' : 'text-gray-400' }}">
                                        Rp {{ number_format($f['available_saldo'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('organizer.events.withdrawals.index', $event) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 text-[10px] font-black uppercase tracking-wider rounded-xl transition-all
                                            {{ $f['available_saldo'] > 0
                                                ? 'bg-primary text-white hover:bg-primary-600 shadow-sm shadow-primary/20'
                                                : 'bg-gray-100 text-gray-400 pointer-events-none' }}">
                                            Manage
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Withdrawal History Grouped by Event --}}
        <div>
            <div class="mb-5">
                <h3 class="text-lg font-black text-dark tracking-tight uppercase">Withdrawal History</h3>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Grouped by event</p>
            </div>

            @php $hasAny = $events->contains(fn($e) => $e->withdrawalHistory->isNotEmpty()); @endphp

            @if(!$hasAny)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-14 text-center">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-400 font-bold text-sm">No withdrawal history yet.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($events as $event)
                        @if($event->withdrawalHistory->isNotEmpty())
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                {{-- Event header --}}
                                <div class="flex items-center justify-between px-6 py-4 bg-gray-50/60 border-b border-gray-100">
                                    <div>
                                        <div class="font-black text-dark text-sm">{{ $event->name }}</div>
                                        <div class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mt-0.5">
                                            {{ $event->withdrawalHistory->count() }} request
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Total Withdrawn</div>
                                        <div class="font-black text-emerald-600 text-sm">
                                            Rp {{ number_format($event->withdrawalHistory->where('status', 'approved')->sum('amount'), 0, ',', '.') }}
                                        </div>
                                        @if($event->withdrawalHistory->where('status', 'pending')->count() > 0)
                                            <div class="text-[9px] font-bold text-amber-500 mt-0.5">
                                                + Rp {{ number_format($event->withdrawalHistory->where('status', 'pending')->sum('amount'), 0, ',', '.') }} pending
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- Rows --}}
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="text-[9px] uppercase tracking-wider text-gray-400 font-black border-b border-gray-50">
                                                <th class="px-6 py-3">Date</th>
                                                <th class="px-6 py-3">Reference</th>
                                                <th class="px-6 py-3 text-center">Status</th>
                                                <th class="px-6 py-3">Notes</th>
                                                <th class="px-6 py-3 text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach($event->withdrawalHistory as $withdrawal)
                                                <tr class="hover:bg-primary/[0.02] transition-colors group">
                                                    <td class="px-6 py-3.5">
                                                        <div class="font-bold text-dark text-sm">{{ $withdrawal->created_at->format('d M Y') }}</div>
                                                        <div class="text-[9px] text-gray-400 font-bold uppercase">{{ $withdrawal->created_at->format('H:i') }}</div>
                                                    </td>
                                                    <td class="px-6 py-3.5 font-bold text-dark text-xs group-hover:text-primary transition-colors">
                                                        {{ $withdrawal->reference ?: 'Manual Payout' }}
                                                    </td>
                                                    <td class="px-6 py-3.5 text-center">
                                                        @if($withdrawal->status === 'approved')
                                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-emerald-200">Approved</span>
                                                        @elseif($withdrawal->status === 'rejected')
                                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-red-200">Rejected</span>
                                                        @else
                                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-amber-200">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-3.5 text-xs font-medium text-gray-500 max-w-xs truncate" title="{{ $withdrawal->note }}">
                                                        {{ $withdrawal->note ?: '-' }}
                                                    </td>
                                                    <td class="px-6 py-3.5 text-right font-black text-dark text-sm">
                                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Footer: manage link --}}
                                <div class="px-6 py-3 border-t border-gray-50 bg-gray-50/30 flex justify-end">
                                    <a href="{{ route('organizer.events.withdrawals.index', $event) }}"
                                        class="text-[10px] font-black uppercase tracking-wider text-primary hover:underline flex items-center gap-1">
                                        Manage Withdrawal
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.organizer>
