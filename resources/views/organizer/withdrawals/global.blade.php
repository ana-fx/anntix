<x-layouts.organizer>
    <x-slot name="title">Withdrawals Overview</x-slot>

    <div>
        <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-8 gap-6">
            <div>
                <h2 class="text-3xl font-black text-dark tracking-tight">Withdrawals</h2>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">Manage payouts across all your events</p>
            </div>

            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between px-6 py-3 min-w-[250px]">
                    <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Total Available Saldo</div>
                    <div class="font-black text-primary text-2xl leading-tight">
                        Rp {{ number_format($totalAvailableSaldo, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-3xl bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Events with Baldo Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-dark tracking-tight uppercase">Event Balances</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest {{ $event->available_saldo > 0 ? 'text-primary' : 'text-gray-400' }}">
                                {{ $event->available_saldo > 0 ? 'Funds Available' : 'No Funds' }}
                            </span>
                        </div>
                        <h4 class="font-black text-dark text-lg mb-1 truncate" title="{{ $event->name }}">{{ $event->name }}</h4>
                        <div class="text-2xl font-black text-dark mb-6">
                            Rp {{ number_format($event->available_saldo, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('organizer.events.withdrawals.index', $event) }}"
                           class="flex items-center justify-center w-full py-3 {{ $event->available_saldo > 0 ? 'bg-primary text-white hover:bg-primary-600 shadow-lg shadow-primary/20' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }} rounded-2xl font-bold text-xs transition-all gap-2">
                            Request Withdrawal
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Global History Table -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-dark tracking-tight uppercase">Recent Requests (All Events)</h3>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                <th class="px-6 py-5">Date</th>
                                <th class="px-6 py-5">Event</th>
                                <th class="px-6 py-5">Reference</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-6 py-5 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($withdrawals as $withdrawal)
                                <tr class="hover:bg-primary/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-dark text-sm">
                                            {{ $withdrawal->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">
                                            {{ $withdrawal->created_at->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-black text-dark text-sm leading-tight">{{ $withdrawal->event->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-dark text-xs group-hover:text-primary transition-colors">
                                        {{ $withdrawal->reference ?: 'Manual Payout' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($withdrawal->status === 'approved')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-emerald-200">Approved</span>
                                        @elseif($withdrawal->status === 'rejected')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-red-200">Rejected</span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-amber-200">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-dark text-sm">
                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold text-sm bg-gray-50/30">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        No withdrawal history found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($withdrawals->hasPages())
                    <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
                        {{ $withdrawals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.organizer>
