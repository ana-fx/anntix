<x-layouts.admin>
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Ticket Variants</h2>
                <p class="text-sm text-gray-500">Manage tickets for event: <span
                        class="font-bold">{{ $event->name }}</span></p>
            </div>
            <a href="{{ route('admin.events.tickets.create', $event) }}"
                class="px-6 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition shadow-lg shadow-primary/30">
                + Add Ticket
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Table Header Controls (Search/Show) - Placeholder for visual matching -->
            <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span>Show</span>
                    <select class="border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 w-full md:w-auto">
                    <span>Search:</span>
                    <input type="text"
                        class="border-gray-200 rounded-lg text-sm w-full md:w-64 focus:ring-primary focus:border-primary">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-xs uppercase text-gray-500 font-bold tracking-wider">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Quota</th>
                            <th class="px-6 py-4">Available</th>
                            <th class="px-6 py-4">Max Purchase</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Desc</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tickets as $index => $ticket)
                            @php
                                $sold = $ticket->transactions_sum_quantity_paid ?? 0;
                                $pending = $ticket->transactions_sum_quantity_pending ?? 0;
                                $available = $ticket->quota - ($sold + $pending);
                                $now = now();
                                $status = 'Inactive';
                                $statusClass = 'bg-gray-100 text-gray-800';

                                if ($ticket->deleted_at) {
                                    $status = 'Deleted';
                                    $statusClass = 'bg-red-100 text-red-800';
                                } elseif ($available <= 0) {
                                    $status = 'Sold Out';
                                    $statusClass = 'bg-red-100 text-red-800';
                                } elseif ($now < $ticket->start_date) {
                                    $status = 'Upcoming';
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                } elseif ($now > $ticket->end_date) {
                                    $status = 'Expired';
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                } else {
                                    $status = 'Active';
                                    $statusClass = 'bg-green-100 text-green-800';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $tickets->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $ticket->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $ticket->quota }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-primary">
                                    <div class="flex flex-col">
                                        <span>{{ $available }}</span>
                                        @if($pending > 0)
                                            <span
                                                class="text-[9px] font-black text-amber-500 uppercase tracking-tighter">Locked:
                                                {{ $pending }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $ticket->max_purchase_per_user }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate"
                                    title="{{ $ticket->description }}">
                                    {{ Str::limit($ticket->description, 20) }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.tickets.edit', $ticket) }}"
                                            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    No tickets found. Click "Add Ticket" to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>

        <!-- Data Events Report Section (Light Style Matching Dashboard) -->
        <div class="mt-12 mb-20">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Data Events Report</h2>
                    <p class="text-sm text-gray-500">Sales summary breakdown for this event</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Ticket Variation</th>
                                <th class="px-6 py-4">Ticket Price</th>
                                <th class="px-6 py-4 text-center">Ticket Available</th>
                                <th class="px-6 py-4 text-center">Ticket Sales</th>
                                <th class="px-6 py-4 text-right">Total Ticket Sales</th>
                                <th class="px-6 py-4 text-right">Service Fee</th>
                                <th class="px-6 py-4 text-right">Handling Fee</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $grandQty = 0;
                                $grandTotalSales = 0;
                                $grandServiceFee = 0;
                                $grandHandlingFee = 0;
                            @endphp
                            @foreach($tickets as $index => $ticket)
                                @php
                                    $salesQty = $ticket->transactions_sum_quantity_paid ?? 0;
                                    $pendingQty = $ticket->transactions_sum_quantity_pending ?? 0;
                                    $availableQty = $ticket->quota - ($salesQty + $pendingQty);
                                    $totalPriceCollected = (float) ($ticket->transactions_sum_total_price ?? 0);

                                    $ticketSales = $salesQty * $ticket->price;
                                    $handlingTotal = $salesQty * $handlingFeeValue;
                                    $serviceFeeValue = $totalPriceCollected > 0 ? ($totalPriceCollected - ($ticketSales + $handlingTotal)) : 0;

                                    $grandQty += $salesQty;
                                    $grandTotalSales += $ticketSales;
                                    $grandServiceFee += $serviceFeeValue;
                                    $grandHandlingFee += $handlingTotal;
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors text-sm">
                                    <td class="px-6 py-5 text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-5 font-bold text-gray-900">{{ $ticket->name }}</td>
                                    <td class="px-6 py-5 text-gray-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-5 text-center font-bold text-primary">
                                        <div class="flex flex-col items-center">
                                            <span>{{ number_format($availableQty) }}</span>
                                            @if($pendingQty > 0)
                                                <span
                                                    class="text-[9px] text-amber-500 font-bold uppercase tracking-widest">Locked:
                                                    {{ $pendingQty }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center font-bold text-gray-900">{{ number_format($salesQty) }}
                                    </td>
                                    <td class="px-6 py-5 text-right font-black text-dark">Rp
                                        {{ number_format($ticketSales, 0, ',', '.') }}</td>
                                    <td class="px-6 py-5 text-right text-gray-500">Rp
                                        {{ number_format($serviceFeeValue, 0, ',', '.') }}</td>
                                    <td class="px-6 py-5 text-right text-gray-500">Rp
                                        {{ number_format($handlingTotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr class="font-black text-dark">
                                <td colspan="4" class="px-6 py-6 text-sm uppercase tracking-wider text-gray-500">Total
                                    Ticket Sales</td>
                                <td class="px-6 py-6 text-center text-lg text-primary">{{ number_format($grandQty) }}
                                </td>
                                <td class="px-6 py-6 text-right text-lg">Rp
                                    {{ number_format($grandTotalSales, 0, ',', '.') }}</td>
                                <td class="px-6 py-6 text-right text-lg text-gray-600">Rp
                                    {{ number_format($grandServiceFee, 0, ',', '.') }}</td>
                                <td class="px-6 py-6 text-right text-lg text-gray-600">Rp
                                    {{ number_format($grandHandlingFee, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>