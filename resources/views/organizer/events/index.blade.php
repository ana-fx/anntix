<x-layouts.organizer title="Events">
    <div x-data="{ deleteModalOpen: false, formToSubmit: null }">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">My Events</h2>
                <p class="text-sm text-gray-500 mt-1">Manage events assigned to your organization</p>
            </div>
            {{-- Organizers cannot create events --}}
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                            <th class="px-6 py-4">Thumbnail</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-center">Tickets</th>
                            <th class="px-6 py-4 text-center">Scanners</th>
                            <th class="px-6 py-4 text-center">Resellers</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($events as $event)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    @php
                                        $thumb = $event->thumbnail_path;
                                        $thumbUrl = $thumb
                                            ? (Str::startsWith($thumb, 'http') ? $thumb : (file_exists(public_path($thumb)) ? asset($thumb) : asset('storage/' . $thumb)))
                                            : null;
                                    @endphp
                                    @if($thumbUrl)
                                        <img src="{{ $thumbUrl }}" class="w-16 h-10 object-cover rounded-lg" alt="">
                                    @else
                                        <div
                                            class="w-16 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">
                                            No Img</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $event->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $event->location }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $event->start_date->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('organizer.events.tickets-report.index', $event) }}"
                                            class="group flex items-center justify-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100"
                                            title="View Variation Report">
                                            <div class="flex items-baseline gap-0.5">
                                                <span class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $event->tickets_count ?? '0' }}</span>
                                                <span class="text-xs text-gray-400 font-medium">/ {{ $event->total_tickets ?? '0' }}</span>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors ml-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('organizer.events.scanners.index', $event) }}"
                                            class="group flex items-center justify-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100"
                                            title="View Scanners">
                                            <span class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $event->scanners_count ?? 0 }}</span>
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('organizer.events.resellers.index', $event) }}"
                                            class="group flex items-center justify-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100"
                                            title="View Resellers">
                                            <span class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $event->resellers_count ?? 0 }}</span>
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match ($event->status) {
                                            'active' => 'bg-green-100 text-green-700',
                                            'draft' => 'bg-gray-100 text-gray-600',
                                            default => 'bg-red-100 text-red-700',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('organizer.events.show', $event) }}"
                                            class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all"
                                            title="View Event Details">
                                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('organizer.events.edit', $event) }}"
                                            class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all"
                                            title="Edit Event">
                                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    No events found assigned to you.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($events->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.organizer>
