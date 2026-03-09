<x-layouts.organizer>
    <x-slot name="title">Event Scanners - {{ $event->name }}</x-slot>
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('organizer.events.index') }}"
                    class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-primary transition-colors gap-2 mb-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Events
                </a>
                <h2 class="text-2xl font-bold text-gray-900">Event Scanners</h2>
                <p class="text-sm text-gray-500">Assigned scanners for event: <span
                        class="font-bold">{{ $event->name }}</span></p>
            </div>
            <div class="px-5 py-2.5 bg-gray-100 rounded-2xl border border-gray-200 flex items-center gap-3">
                <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Read Only Mode (Admin Managed)</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-xs uppercase text-gray-500 font-bold tracking-wider">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Joined Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($event->scanners as $index => $scanner)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="font-bold text-gray-900">{{ $scanner->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $scanner->email }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ ucfirst($scanner->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $scanner->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    No scanners assigned to this event yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.organizer>
