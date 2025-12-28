<x-layouts.admin>
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Ticket Variants</h2>
                <p class="text-sm text-gray-500">Manage tickets for event: <span
                        class="font-bold">{{ $event->name }}</span></p>
            </div>
            <a href="{{ route('admin.events.tickets.create', $event) }}"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                + Tambah Data
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
                    <select class="border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 w-full md:w-auto">
                    <span>Search:</span>
                    <input type="text"
                        class="border-gray-200 rounded-lg text-sm w-full md:w-64 focus:ring-indigo-500 focus:border-indigo-500">
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
                                $sold = $ticket->transactions_sum_quantity ?? 0;
                                $available = $ticket->quota - $sold;
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
                                <td class="px-6 py-4 text-sm font-bold text-indigo-600">
                                    {{ $available }}
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
                                    No tickets found. Click "Tambah Data" to create one.
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
    </div>
</x-layouts.admin>