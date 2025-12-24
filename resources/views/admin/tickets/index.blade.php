<x-layouts.admin>
    <div class="space-y-6" x-data="{ deleteModalOpen: false, formToSubmit: null }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-3xl font-bold text-gray-900">All Tickets</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Ticket Name</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Quota</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($ticket->event->thumbnail_path)
                                            <img src="{{ Storage::url($ticket->event->thumbnail_path) }}"
                                                class="w-8 h-8 rounded-lg object-cover shadow-sm group-hover:scale-105 transition-transform"
                                                alt="{{ $ticket->event->name }}">
                                        @else
                                            <div
                                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-500 font-bold text-xs">
                                                {{ substr($ticket->event->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="font-medium text-gray-900">{{ $ticket->event->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-700">{{ $ticket->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900">
                                        {{ $ticket->price == 0 ? 'Free' : 'Rp. ' . number_format($ticket->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full max-w-[80px] h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
                                            <!-- Assuming current loaded/sold count is not available yet, just showing styling -->
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">{{ $ticket->quota }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-100">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2 opacity-100">
                                        <a href="{{ route('admin.tickets.edit', $ticket) }}"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                            title="Edit Ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST"
                                            @submit.prevent="formToSubmit = $el; deleteModalOpen = true" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Delete Ticket">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div
                                        class="flex flex-col items-center justify-center p-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="font-medium text-gray-900">No tickets found</p>
                                        <p class="text-sm text-gray-500 mt-1">Create events and add tickets to see them
                                            here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
        <x-notifications.delete />
    </div>
</x-layouts.admin>