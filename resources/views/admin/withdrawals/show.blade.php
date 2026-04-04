<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-8 pb-12">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.withdrawals.index') }}"
                    class="w-12 h-12 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 hover:text-primary hover:shadow-md hover:-translate-x-0.5 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-dark tracking-tight">{{ $event->name }}</h1>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Withdrawal Detail & Financial Summary</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Financial Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            {{-- Gross Revenue --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Gross Revenue</div>
                <div class="text-xl font-black text-dark">Rp {{ number_format($financial['gross_revenue'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold mt-1">Online: Rp {{ number_format($financial['online_revenue'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold">Reseller: Rp {{ number_format($financial['reseller_revenue'], 0, ',', '.') }}</div>
            </div>
            {{-- Platform Fee --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Platform Fee</div>
                <div class="text-xl font-black text-primary">Rp {{ number_format($financial['total_platform_income'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-gray-400 font-bold mt-1">Handling + organizer tax</div>
            </div>
            {{-- Organizer Net --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Net to Organizer</div>
                <div class="text-xl font-black text-dark">Rp {{ number_format($financial['net_revenue'], 0, ',', '.') }}</div>
                <div class="mt-2 space-y-1">
                    <div class="flex justify-between text-[10px] font-bold">
                        <span class="text-gray-400">Withdrawn</span>
                        <span class="text-emerald-600">Rp {{ number_format($financial['withdrawn_approved'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold">
                        <span class="text-gray-400">Pending</span>
                        <span class="text-amber-500">Rp {{ number_format($financial['withdrawn_pending'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            {{-- Available --}}
            <div class="bg-primary/5 border border-primary/20 rounded-2xl shadow-sm p-5">
                <div class="text-[9px] font-black uppercase tracking-widest text-primary/60 mb-2">Available to Withdraw</div>
                <div class="text-xl font-black text-primary">Rp {{ number_format($financial['available_saldo'], 0, ',', '.') }}</div>
                <div class="text-[10px] text-primary/50 font-bold mt-1">Organizer can request</div>
            </div>
        </div>

        {{-- Ticket Sales Breakdown --}}
        @if($financial['online_tickets_sold'] > 0 || $financial['reseller_tickets_sold'] > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-4">Ticket Sales Breakdown</div>
            <div class="grid grid-cols-2 gap-6">
                @php
                    $total = $financial['online_tickets_sold'] + $financial['reseller_tickets_sold'];
                    $onlinePct = $total > 0 ? ($financial['online_tickets_sold'] / $total * 100) : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-500">Online</span>
                        <span class="text-xs font-black text-dark">{{ $financial['online_tickets_sold'] }} tickets</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-1">
                        <div class="bg-primary h-2 rounded-full" style="width: {{ $onlinePct }}%"></div>
                    </div>
                    <div class="text-xs font-bold text-primary">Rp {{ number_format($financial['online_revenue'], 0, ',', '.') }}</div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-500">Reseller</span>
                        <span class="text-xs font-black text-dark">{{ $financial['reseller_tickets_sold'] }} tickets</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-1">
                        <div class="bg-violet-500 h-2 rounded-full" style="width: {{ 100 - $onlinePct }}%"></div>
                    </div>
                    <div class="text-xs font-bold text-violet-500">Rp {{ number_format($financial['reseller_revenue'], 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Tabs --}}
        <div x-data="{ activeTab: '{{ $withdrawals->where('status', 'pending')->count() > 0 ? 'organizer' : 'organizer' }}' }">

            {{-- Tab Bar --}}
            <div class="flex gap-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-1.5 w-fit">
                <button @click="activeTab = 'organizer'"
                    class="relative flex items-center gap-2 px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all">
                    <span x-show="activeTab === 'organizer'"
                        class="absolute inset-0 rounded-xl bg-primary shadow-sm"></span>
                    <span :class="activeTab === 'organizer' ? 'text-white' : 'text-gray-500'"
                        class="relative flex items-center gap-2 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Organizer Withdrawals
                        @if($withdrawals->where('status', 'pending')->count() > 0)
                            <span class="px-1.5 py-0.5 bg-amber-400 text-white rounded-full text-[9px] font-black leading-none">
                                {{ $withdrawals->where('status', 'pending')->count() }}
                            </span>
                        @endif
                    </span>
                </button>
                <button @click="activeTab = 'platform'"
                    class="relative flex items-center gap-2 px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all">
                    <span x-show="activeTab === 'platform'"
                        class="absolute inset-0 rounded-xl bg-primary shadow-sm"></span>
                    <span :class="activeTab === 'platform' ? 'text-white' : 'text-gray-500'"
                        class="relative flex items-center gap-2 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Platform Revenue
                    </span>
                </button>
            </div>

            {{-- Tab: Organizer Withdrawals --}}
            <div x-show="activeTab === 'organizer'" x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mt-4">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-black text-dark uppercase tracking-wider">Organizer Withdrawal Requests</h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $withdrawals->count() }} total — approve or reject payouts to organizer</p>
                        </div>
                        @if($financial['available_saldo'] > 0)
                            <a href="{{ route('admin.events.withdrawals.create_for_event', $event) }}"
                                class="flex items-center gap-1.5 px-4 py-2.5 bg-primary text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm hover:opacity-90">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Manual Payout
                            </a>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Reference</th>
                                    <th class="px-6 py-4">Notes</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Amount</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($withdrawals as $w)
                                    <tr class="hover:bg-gray-50/60 transition-colors group" x-data="{ showApprove: false, showReject: false }">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-dark text-sm">{{ $w->created_at->format('d M Y') }}</div>
                                            <div class="text-[9px] text-gray-400 font-bold uppercase">{{ $w->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-dark text-xs">
                                            {{ $w->reference ?: 'Manual Payout' }}
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-gray-500 max-w-[200px] truncate" title="{{ $w->note }}">
                                            {{ $w->note ?: '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($w->status === 'approved')
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-emerald-200">Approved</span>
                                            @elseif($w->status === 'rejected')
                                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-red-200">Rejected</span>
                                            @else
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-amber-200 animate-pulse">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-black text-dark text-sm">
                                            Rp {{ number_format($w->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                @if($w->status === 'pending')
                                                    <button @click="showApprove = true"
                                                        class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Approve">
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                    <button @click="showReject = true"
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Reject">
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.withdrawals.edit', $w) }}"
                                                    class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Edit">
                                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.withdrawals.destroy', $w) }}" method="POST"
                                                    onsubmit="return confirm('Delete this withdrawal request?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                        {{-- Approve Modal --}}
                                        <div x-show="showApprove" style="display:none;"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-dark/60 backdrop-blur-sm p-4"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8" @click.away="showApprove = false">
                                                <div class="flex items-center gap-4 mb-6">
                                                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-black text-dark">Approve Withdrawal?</h3>
                                                        <p class="text-xs text-gray-500 font-bold mt-0.5">This marks the funds as transferred to the organizer</p>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 rounded-2xl p-4 mb-6 space-y-2">
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-gray-500 font-bold">Amount</span>
                                                        <span class="font-black text-dark">Rp {{ number_format($w->amount, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-gray-500 font-bold">Reference</span>
                                                        <span class="font-bold text-dark">{{ $w->reference ?: 'Manual Payout' }}</span>
                                                    </div>
                                                    @if($w->note)
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-gray-500 font-bold">Notes</span>
                                                        <span class="font-bold text-dark max-w-[200px] text-right">{{ $w->note }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="flex gap-3">
                                                    <button @click="showApprove = false"
                                                        class="flex-1 py-3 rounded-2xl border border-gray-200 text-gray-600 font-black text-sm hover:bg-gray-50 transition-all">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('admin.withdrawals.approve', $w) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <button type="submit"
                                                            class="w-full py-3 rounded-2xl bg-emerald-500 text-white font-black text-sm hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                                                            Yes, Approve
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Reject Modal --}}
                                        <div x-show="showReject" style="display:none;"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-dark/60 backdrop-blur-sm p-4"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8" @click.away="showReject = false">
                                                <div class="flex items-center gap-4 mb-6">
                                                    <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-black text-dark">Reject Withdrawal?</h3>
                                                        <p class="text-xs text-gray-500 font-bold mt-0.5">The organizer will be notified that this request has been rejected</p>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 rounded-2xl p-4 mb-6">
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-gray-500 font-bold">Amount</span>
                                                        <span class="font-black text-dark">Rp {{ number_format($w->amount, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex gap-3">
                                                    <button @click="showReject = false"
                                                        class="flex-1 py-3 rounded-2xl border border-gray-200 text-gray-600 font-black text-sm hover:bg-gray-50 transition-all">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('admin.withdrawals.reject', $w) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <button type="submit"
                                                            class="w-full py-3 rounded-2xl bg-red-500 text-white font-black text-sm hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">
                                                            Yes, Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-gray-400 font-bold text-sm">No withdrawal requests found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tab: Platform Revenue --}}
            <div x-show="activeTab === 'platform'" x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mt-4">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-black text-dark uppercase tracking-wider">Platform Revenue</h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Admin bookkeeping — record platform income taken</p>
                        </div>
                    </div>

                    {{-- Platform Revenue Summary Cards --}}
                    <div class="grid grid-cols-3 gap-4 p-6">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Platform Income</div>
                            <div class="text-lg font-black text-dark">Rp {{ number_format($financial['total_platform_income'], 0, ',', '.') }}</div>
                            <div class="text-[10px] text-gray-400 font-bold mt-1">Handling + organizer tax</div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Already Recorded</div>
                            <div class="text-lg font-black text-emerald-600">Rp {{ number_format($financial['platform_withdrawn'], 0, ',', '.') }}</div>
                            <div class="text-[10px] text-gray-400 font-bold mt-1">{{ $platformWithdrawals->count() }} record(s)</div>
                        </div>
                        <div class="bg-primary/5 border border-primary/20 rounded-2xl p-4">
                            <div class="text-[9px] font-black uppercase tracking-widest text-primary/60 mb-1">Available to Record</div>
                            <div class="text-lg font-black text-primary">Rp {{ number_format($financial['platform_available'], 0, ',', '.') }}</div>
                            <div class="text-[10px] text-primary/50 font-bold mt-1">Unrecorded platform income</div>
                        </div>
                    </div>

                    {{-- Record Form --}}
                    @if($financial['platform_available'] > 0)
                    <div class="px-6 pb-6">
                        <form action="{{ route('admin.events.platform-withdrawals.store', $event) }}" method="POST"
                            class="bg-gray-50 rounded-2xl p-5 flex flex-col md:flex-row md:items-end gap-4">
                            @csrf
                            <div class="flex-1">
                                <label class="block text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Amount (max Rp {{ number_format($financial['platform_available'], 0, ',', '.') }})</label>
                                <input type="number" name="amount" min="1" max="{{ $financial['platform_available'] }}" step="1" required
                                    placeholder="Enter amount..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm font-bold text-dark focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            </div>
                            <div class="flex-[2]">
                                <label class="block text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Note (optional)</label>
                                <input type="text" name="note" maxlength="500"
                                    placeholder="e.g. Transfer to main account April 2026..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm font-bold text-dark focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            </div>
                            <button type="submit"
                                class="shrink-0 flex items-center gap-2 px-5 py-3 bg-primary text-white hover:bg-dark rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-primary/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Record
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- Platform Withdrawal History --}}
                    @if($platformWithdrawals->isNotEmpty())
                    <div class="border-t border-gray-100 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Note</th>
                                    <th class="px-6 py-4 text-right">Amount</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($platformWithdrawals as $pw)
                                    <tr class="hover:bg-primary/[0.02] transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-dark text-sm">{{ $pw->created_at->format('d M Y') }}</div>
                                            <div class="text-[9px] text-gray-400 font-bold uppercase">{{ $pw->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-gray-500 max-w-[300px] truncate" title="{{ $pw->note }}">
                                            {{ $pw->note ?: '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-black text-dark text-sm">
                                            Rp {{ number_format($pw->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.platform-withdrawals.destroy', $pw) }}" method="POST"
                                                onsubmit="return confirm('Delete this platform revenue record?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="px-6 pb-10 text-center">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-400 font-bold text-sm">No platform revenue records yet.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</x-layouts.admin>
