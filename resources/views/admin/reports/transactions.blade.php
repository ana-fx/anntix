<x-layouts.admin title="Transaction Report">
    <!-- Header Section -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-dark tracking-tight">Transactions</h2>
            <p class="text-gray-500 mt-1 font-medium">Monitor and manage all customer payments in real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="exportToExcel()"
                class="group px-6 py-3.5 bg-white text-dark font-bold rounded-2xl hover:bg-gray-50 transition-all shadow-sm border border-gray-100 flex items-center gap-3 active:scale-95">
                <div
                    class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <span>Export Excel</span>
            </button>
        </div>
    </div>

    <!-- Filter & Statistics Card -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-primary/5 border border-gray-100 p-8 mb-10">
        <form action="{{ route('admin.reports.transactions') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Search</label>
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search..."
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-none bg-gray-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all text-sm font-medium placeholder:text-gray-400">
                </div>
            </div>

            <!-- Source Filter -->
            <div class="md:col-span-3" x-data="{
                open: false,
                selected: '{{ request('source') ?: '' }}',
                label: '{{ request('source') == 'online' ? 'Online' : (request('source') == 'reseller' ? 'Reseller' : 'All Sources') }}'
            }">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Source</label>
                <input type="hidden" name="source" :value="selected">
                <div class="relative">
                    <button type="button" @click="open = !open" @click.away="open = false"
                        class="w-full flex items-center justify-between px-6 py-4 rounded-2xl bg-gray-50 text-sm font-bold border-none focus:ring-4 focus:ring-primary/10 transition-all text-dark">
                        <span x-text="label" :class="selected === '' ? 'text-gray-400 font-medium' : 'text-dark'"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute z-50 w-full mt-2 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Select Source</span>
                        </div>
                        <div class="py-2">
                            <button type="button" @click="selected = ''; label = 'All Sources'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">All Sources</button>
                            <button type="button" @click="selected = 'online'; label = 'Online'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">Online</button>
                            <button type="button" @click="selected = 'reseller'; label = 'Reseller'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">Reseller</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="md:col-span-3" x-data="{
                open: false,
                selected: '{{ request('status') ?: '' }}',
                label: '{{ request('status') == 'pending' ? 'Pending' : (request('status') == 'paid' ? 'Paid' : (request('status') == 'failed' ? 'Failed' : 'All Status')) }}'
            }">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Status</label>
                <input type="hidden" name="status" :value="selected">
                <div class="relative">
                    <button type="button" @click="open = !open" @click.away="open = false"
                        class="w-full flex items-center justify-between px-6 py-4 rounded-2xl bg-gray-50 text-sm font-bold border-none focus:ring-4 focus:ring-primary/10 transition-all text-dark">
                        <span x-text="label" :class="selected === '' ? 'text-gray-400 font-medium' : 'text-dark'"></span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute z-50 w-full mt-2 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Select Status</span>
                        </div>
                        <div class="py-2">
                            <button type="button" @click="selected = ''; label = 'All Status'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">All Status</button>
                            <button type="button" @click="selected = 'pending'; label = 'Pending'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">Pending</button>
                            <button type="button" @click="selected = 'paid'; label = 'Paid'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">Paid</button>
                            <button type="button" @click="selected = 'failed'; label = 'Failed'; open = false" class="w-full px-6 py-3 text-left hover:bg-primary/5 transition-colors text-sm font-bold text-dark">Failed</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit"
                    class="flex-1 py-4 bg-dark text-white font-black rounded-2xl hover:opacity-90 transition-all shadow-lg active:scale-95 uppercase tracking-widest text-xs">
                    Apply
                </button>
                <a href="{{ route('admin.reports.transactions') }}"
                    class="px-5 py-4 bg-gray-100 text-dark font-black rounded-2xl hover:bg-gray-200 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="transaction-table">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                        <th class="px-8 py-5">
                            Transaction</th>
                        <th class="px-8 py-5">Customer
                        </th>
                        <th class="px-8 py-5">Source</th>
                        <th class="px-8 py-5">Event Detail</th>
                        <th
                            class="px-8 py-5 text-right">
                            Amount Breakout</th>
                        <th
                            class="px-8 py-5 text-center">
                            Status</th>
                        <th
                            class="px-8 py-5 text-right">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $index => $transaction)
                        @php
                            $ticketSales = $transaction->quantity * ($transaction->ticket->price ?? 0);
                            $handlingTotal = $transaction->quantity * $handlingFeeValue;
                            $serviceFee = (float) $transaction->total_price - ($ticketSales + $handlingTotal);
                            if ($serviceFee < 0)
                                $serviceFee = 0;
                        @endphp
                        <tr class="group hover:bg-primary/[0.02] transition-colors">
                            <td class="px-8 py-7 leading-none">
                                <a href="{{ route('admin.reports.transactions.show', $transaction->id) }}"
                                    class="block group/item">
                                    <div
                                        class="font-mono text-[11px] font-black text-primary tracking-tighter mb-1 select-all underline decoration-dotted decoration-primary/30 underline-offset-4 group-hover/item:text-dark transition-colors">
                                        {{ $transaction->code }}</div>
                                </a>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="px-8 py-7">
                                <div class="text-sm font-black text-dark mb-0.5">{{ $transaction->name }}</div>
                                <div class="flex flex-col gap-0.5">
                                    <a href="mailto:{{ $transaction->email }}" class="text-[10px] font-bold text-secondary hover:text-primary transition-colors">{{ $transaction->email }}</a>
                                    <a href="tel:{{ $transaction->phone }}" class="text-[10px] font-black text-primary hover:opacity-70 transition-opacity">{{ $transaction->phone }}</a>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                @if($transaction->reseller_id)
                                    <div class="flex flex-col">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100 w-max mb-1 uppercase tracking-tighter">Reseller</span>
                                        <div class="text-[10px] font-black text-dark truncate max-w-[120px]" title="{{ $transaction->reseller->name ?? 'Deleted' }}">
                                            {{ $transaction->reseller->name ?? 'Deleted' }}
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 w-max uppercase tracking-tighter">Online</span>
                                @endif
                            </td>
                            <td class="px-8 py-7">
                                <span
                                    class="inline-block text-xs font-black text-dark bg-gray-100 px-2.5 py-1 rounded-lg mb-1">{{ $transaction->event->name ?? 'Deleted Event' }}</span>
                                <div class="text-[10px] font-bold text-secondary uppercase tracking-wider ml-1">
                                    {{ $transaction->ticket->name ?? 'N/A' }} <span
                                        class="text-primary italic mx-1">x{{ $transaction->quantity }}</span></div>
                            </td>
                            <td class="px-8 py-7 text-right">
                                <div class="text-base font-black text-dark tracking-tight mb-0.5">Rp
                                    {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                                <div class="flex items-center justify-end gap-2">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Svc:
                                        {{ number_format($serviceFee, 0, ',', '.') }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Hdl:
                                        {{ number_format($handlingTotal, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @if($transaction->status === 'paid')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm shadow-emerald-500/10">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                        Accepted
                                    </span>
                                @elseif($transaction->status === 'pending')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm shadow-amber-500/10">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></div>
                                        Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100 opacity-60">
                                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-7 text-right">
                                <a href="{{ route('admin.reports.transactions.show', $transaction->id) }}"
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 text-secondary hover:bg-dark hover:text-white transition-all active:scale-95 shadow-sm border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center justify-center opacity-30 group">
                                    <div
                                        class="w-20 h-20 rounded-[2rem] bg-gray-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-10 h-10 text-dark" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-xl font-black text-dark tracking-tight">Empty Vault</p>
                                    <p class="text-sm font-medium text-secondary mt-1">No transaction records match your
                                        criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Premium Pagination -->
        @if($transactions->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
        <script>
            function exportToExcel() {
                const table = document.getElementById('transaction-table');
                const wb = XLSX.utils.table_to_book(table, { sheet: "Transactions" });

                // Subtle sound effect or animation trigger could go here
                XLSX.writeFile(wb, "ANNTIX_Transaction_Intelligence_" + new Date().toISOString().split('T')[0] + ".xlsx");
            }
        </script>
    @endpush
</x-layouts.admin>
