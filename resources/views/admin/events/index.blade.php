<x-layouts.admin>
    <div x-data="{ deleteModalOpen: false, formToSubmit: null }">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Events</h2>
            <a href="{{ route('admin.events.create') }}"
                class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary/25">
                + Create Event
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                        <th class="px-6 py-4">Thumbnail</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                @if($event->thumbnail_path)
                                    <img src="{{ Storage::url($event->thumbnail_path) }}"
                                        class="w-16 h-10 object-cover rounded-lg" alt="">
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
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold
                                                                    @if($event->status === 'active') bg-green-100 text-green-700
                                                                    @elseif($event->status === 'draft') bg-gray-100 text-gray-600
                                                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.events.show', $event) }}"
                                        class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                        title="View Event Details">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>



                                    <a href="{{ route('admin.events.edit', $event) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        title="Edit Event">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline"
                                        @submit.prevent="formToSubmit = $el; deleteModalOpen = true">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            title="Delete Event">
                                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No events found. Start by creating one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($events->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
        <!-- Delete Confirmation Modal -->
        <x-notifications.delete />
    </div>
</x-layouts.admin>