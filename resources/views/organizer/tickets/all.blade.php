<x-layouts.organizer>
    <x-slot name="title">All Tickets</x-slot>
    <div class="space-y-8">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight">Ticket Variations</h2>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">All ticket types across your events</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Ticket Variation</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Volume</th>
                            <th class="px-6 py-4 text-center">Stock</th>
                            <th class="px-6 py-4 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tickets as $ticket)
                            @php
                                $totalPaid = (int) ($ticket->transactions_sum_quantity_paid ?? 0);
                                $totalPending = (int) ($ticket->transactions_sum_quantity_pending ?? 0);
                                $available = max(0, $ticket->quota - $totalPaid - $totalPending);
                                $revenue = $totalPaid * $ticket->price;
                            @endphp
                            <tr class="hover:bg-primary/[0.02] transition-all group">
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $ticket->event->name }}</div>
                                </td>
                                <td class="px-6 py-4 font-black text-dark text-sm group-hover:text-primary transition-colors">
                                    {{ $ticket->name }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ticket->is_active)
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold uppercase tracking-wider">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold uppercase tracking-wider">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-black text-dark">
                                        {{ number_format($totalPaid) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="font-black text-dark text-sm">{{ number_format($available) }}</div>
                                    <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">/ {{ number_format($ticket->quota) }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-primary text-sm">
                                    Rp {{ number_format($revenue, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-layouts.organizer>
