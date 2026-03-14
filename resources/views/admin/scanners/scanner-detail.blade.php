<x-layouts.admin>
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.scanner-management.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400 hover:text-primary transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-dark">{{ $scanner->name }}'s Scan Logs</h1>
                <p class="text-sm text-gray-500">Detailed record of all tickets scanned by this account.</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <form action="{{ route('admin.scanner-management.show', $scanner) }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-64 pl-10 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm"
                    placeholder="Search ticket code, name, event...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Managed Scans</p>
            <p class="text-3xl font-black text-dark tracking-tight">{{ $scanner->scanner_scans_count ?? $scanner->scannerScans()->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Unique Events</p>
            <p class="text-3xl font-black text-dark tracking-tight">
                {{ \App\Models\TransactionScan::where('scanned_by', $scanner->id)->join('transactions', 'transaction_scans.transaction_id', '=', 'transactions.id')->distinct('transactions.event_id')->count() }}
            </p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
             <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Recent Scan</p>
             <p class="text-lg font-bold text-dark tracking-tight">
                @if($scans->first())
                    {{ $scans->first()->created_at->diffForHumans() }}
                @else
                    N/A
                @endif
             </p>
        </div>
        <div class="bg-dark p-6 rounded-3xl shadow-lg flex items-center justify-between overflow-hidden relative">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-1">Account Status</p>
                <p class="text-xl font-black text-white uppercase tracking-wider">{{ $scanner->is_active ? 'ENABLED' : 'DISABLED' }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/5 transform -rotate-12">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 4.5A1.5 1.5 0 014.5 3h6.414a1.5 1.5 0 011.06.44l1.59 1.59a1.5 1.5 0 01.44 1.06V19.5a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5V4.5z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4">Scan Time</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Ticket Details</th>
                        <th class="px-6 py-4">Guest Info</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($scans as $scan)
                        <tr class="hover:bg-gray-50/10 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-dark">{{ $scan->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400 uppercase font-black tracking-widest mt-0.5">{{ $scan->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-dark">{{ $scan->transaction->event->name ?? 'Unknown Event' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-black text-primary uppercase tracking-wider">{{ $scan->transaction->ticket->name ?? 'Unknown Ticket' }}</div>
                                <div class="text-[10px] text-gray-400 mt-1 font-mono uppercase tracking-tighter">{{ $scan->transaction->code }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-dark">{{ $scan->transaction->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $scan->transaction->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-wider rounded-lg">
                                    REDEEMED
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                No scan logs found for this search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($scans->hasPages())
             <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                {{ $scans->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
