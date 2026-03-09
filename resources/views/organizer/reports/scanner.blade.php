<x-layouts.organizer title="Scanner Report">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight">Scanner History</h2>
            <p class="text-gray-500 mt-1 font-medium">Real-time log of ticket redemptions for your events.</p>
        </div>

        <form action="{{ route('organizer.reports.scanner') }}" method="GET"
            class="flex items-center gap-2 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search attendee, event..."
                class="bg-transparent border-none text-sm font-bold text-dark focus:ring-0 px-4 w-64 uppercase tracking-widest placeholder:text-gray-300">
            <button type="submit" class="p-3 bg-dark text-white rounded-xl hover:opacity-90 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm shadow-primary/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                        <th class="px-4 py-3">Ticket & Event</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Created Date</th>
                        <th class="px-4 py-3">Scans</th>
                        <th class="px-4 py-3">Latest Scan Date</th>
                        <th class="px-4 py-3">Latest Scanned By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $trx)
                        <tr class="group hover:hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm font-black text-dark mb-1">{{ $trx->ticket->name ?? 'N/A' }}</div>
                                <div class="text-[10px] font-bold text-gray-400 group-hover:text-primary transition-colors uppercase tracking-widest">
                                    {{ $trx->event->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-black text-dark">{{ $trx->name }}</div>
                                <div class="text-xs text-gray-400 font-medium">{{ $trx->email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex px-3 py-1 pb-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-primary/10 text-primary">
                                    Redeemed
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-xs font-bold text-dark">{{ $trx->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400 font-medium uppercase tracking-widest">
                                    {{ $trx->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-3 py-1 pb-1.5 rounded-full text-[12px] font-black uppercase tracking-widest {{ $trx->scans->count() >= ($trx->ticket->max_scans ?? 1) ? 'bg-red-50 text-red-500' : 'bg-green-50 text-green-600' }}">
                                    {{ $trx->scans->count() }} / {{ $trx->ticket->max_scans ?? 1 }} Scans
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-xs text-dark font-black">
                                    {{ $trx->redeemed_at->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest">
                                    {{ $trx->redeemed_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm font-black text-primary italic uppercase tracking-tighter">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center text-[10px] text-gray-400 not-italic">
                                        {{ substr($trx->scanner->name ?? '?', 0, 1) }}
                                    </div>
                                    {{ $trx->scanner->name ?? 'System' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-32 text-center text-gray-400 italic">No scanned activity recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="px-4 py-3 bg-gray-50/50 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.organizer>
