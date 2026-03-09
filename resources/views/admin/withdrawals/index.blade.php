<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-8 pb-12">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-dark tracking-tight">Withdrawal Management</h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-2">Centralized payout reporting & processing</p>
            </div>

            <a href="{{ route('admin.withdrawals.create') }}"
                class="px-6 py-3.5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-dark transition-all shadow-xl shadow-primary/20 flex items-center gap-2">
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

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] uppercase tracking-wider text-gray-400 font-black">
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Note</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($withdrawals as $w)
                            <tr class="hover:bg-primary/[0.02] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-dark">{{ $w->created_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $w->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-dark group-hover:text-primary transition-colors">
                                        {{ $w->event->name }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $w->reference }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($w->status === 'approved')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-emerald-200">Approved</span>
                                    @elseif($w->status === 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-red-200">Rejected</span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase tracking-wider border border-amber-200 animate-pulse">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-black text-dark text-sm">
                                    Rp {{ number_format($w->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 font-medium max-w-xs truncate" title="{{ $w->note }}">
                                    {{ $w->note ?: '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2 text-right">
                                        @if($w->status === 'pending')
                                            <form action="{{ route('admin.withdrawals.approve', $w) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all" title="Approve">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.withdrawals.reject', $w) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Reject">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.withdrawals.edit', $w) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Edit">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.withdrawals.destroy', $w) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Delete">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v2m16 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1m16 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-400 italic">No withdrawal requests found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($withdrawals->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
