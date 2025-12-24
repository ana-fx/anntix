<x-layouts.admin>
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Events</h2>
        <a href="{{ route('admin.events.create') }}" class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary/25">
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
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
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
                                <img src="{{ Storage::url($event->thumbnail_path) }}" class="w-16 h-10 object-cover rounded-lg" alt="">
                            @else
                                <div class="w-16 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">No Img</div>
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
                                @if($event->status === 'published') bg-green-100 text-green-700
                                @elseif($event->status === 'draft') bg-gray-100 text-gray-600
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs">Delete</button>
                            </form>
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
</x-layouts.admin>
