<x-layouts.admin title="Voided Transactions Report">
    <!-- Header Section -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-dark tracking-tight">Voided Transactions</h2>
            <p class="text-gray-500 mt-1 font-medium">List of transactions that have been cancelled or deleted.</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl shadow-sm shadow-primary/5 border border-gray-100 p-5 mb-10">
        <form action="{{ route('admin.reports.voided-transactions') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
            <div class="md:col-span-9">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Search</label>
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by code, name, or email..."
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-none bg-gray-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all text-sm font-medium placeholder:text-gray-400">
                </div>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit"
                    class="flex-1 py-4 bg-dark text-white font-black rounded-2xl hover:opacity-90 transition-all shadow-lg active:scale-95 uppercase tracking-widest text-xs">
                    Apply
                </button>
                <a href="{{ route('admin.reports.voided-transactions') }}"
                    class="px-5 py-4 bg-gray-100 text-dark font-black rounded-2xl hover:bg-gray-200 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl shadow-2xl shadow-primary/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="voided-transaction-table">
                <thead>
                    <tr
                        class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                        <th class="px-4 py-3">Transaction</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Event Detail</th>
                        <th class="px-4 py-3">Void Reason / Notes</th>
                        <th class="px-4 py-3 text-right">Deleted At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $transaction)
                        @php
                            $voidLog = $transaction->logs->first();
                        @endphp
                        <tr class="group hover:bg-primary/[0.02] transition-colors text-gray-400">
                            <td class="px-4 py-3 leading-none">
                                <div class="font-mono text-[11px] font-black tracking-tighter mb-1 select-all">
                                    {{ $transaction->code }}
                                </div>
                                <div class="text-[10px] font-bold uppercase tracking-widest">
                                    {{ $transaction->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-black mb-0.5">{{ $transaction->name }}</div>
                                <div class="text-[10px] font-bold">{{ $transaction->email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block text-xs font-black bg-gray-100 px-2.5 py-1 rounded-lg mb-1">{{ $transaction->event->name ?? 'Deleted Event' }}</span>
                                <div class="text-[10px] font-bold uppercase tracking-wider ml-1">
                                    {{ $transaction->ticket->name ?? 'N/A' }} <span class="italic mx-1">x{{ $transaction->quantity }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($voidLog)
                                    <div class="text-sm italic font-medium text-gray-500">
                                        "{{ $voidLog->notes }}"
                                    </div>
                                    <div class="text-[10px] font-bold uppercase mt-1">
                                        by {{ $voidLog->user->name ?? 'System' }}
                                    </div>
                                @else
                                    <span class="text-xs italic">No reason provided</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="text-xs font-black tracking-tight">
                                    {{ $transaction->deleted_at->format('d M Y') }}
                                </div>
                                <div class="text-[10px] font-bold uppercase tracking-widest">
                                    {{ $transaction->deleted_at->format('H:i') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-32 text-center">
                                <div class="flex flex-col items-center justify-center opacity-30">
                                    <div class="w-20 h-20 rounded-[2rem] bg-gray-100 flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xl font-black text-dark tracking-tight">No Voided Transactions</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="px-4 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
