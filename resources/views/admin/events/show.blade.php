<x-layouts.admin>
    <div class="max-w-6xl mx-auto space-y-8 pb-12" x-data="{ deleteModalOpen: false, formToSubmit: null }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex text-sm text-gray-500 mb-2 gap-2 items-center">
                    <a href="{{ route('admin.events.index') }}" class="hover:text-primary transition-colors">Events</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-900 font-medium font-bold">Event Details</span>
                </nav>
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $event->name }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.edit', $event) }}"
                    class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Event
                </a>
                <a href="{{ route('admin.events.index') }}"
                    class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary/25 flex items-center gap-2">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Main Content (Left) -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Banner Image -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group">
                    <div class="aspect-video relative overflow-hidden bg-gray-100">
                        @if($event->banner_path)
                            <img src="{{ Storage::url($event->banner_path) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                alt="{{ $event->name }}">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-2 opacity-20" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="font-medium">No banner image uploaded</span>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="inline-flex px-4 py-1.5 rounded-full text-sm font-bold shadow-lg backdrop-blur-md
                                @if($event->status === 'active') bg-green-500/90 text-white
                                @elseif($event->status === 'draft') bg-gray-500/90 text-white
                                @else bg-red-500/90 text-white @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            About this Event
                        </h3>
                        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed whitespace-pre-line">
                            {{ $event->description }}
                        </div>
                    </div>

                    @if($event->terms)
                        <div class="pt-6 border-t border-gray-50">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Terms & Conditions</h3>
                            <div class="text-sm text-gray-500 leading-relaxed whitespace-pre-line">
                                {{ $event->terms }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Location Map -->
                @if($event->google_map_embed)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Location
                        </h3>
                        <p class="text-gray-600 mb-4">{{ $event->location }}, {{ $event->city }}, {{ $event->province }}
                            {{ $event->zip }}
                        </p>
                        <div class="rounded-2xl overflow-hidden border border-gray-100 aspect-video w-full bg-gray-50">
                            {!! $event->google_map_embed !!}
                        </div>
                    </div>
                @endif

                <!-- Ticket Information Table -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            Ticket Information
                        </h3>
                        @php
                            $latestTicket = $event->tickets->sortByDesc('end_date')->first();
                            $nextStartDate = $latestTicket ? $latestTicket->end_date->addDay()->format('Y-m-d H:i') : null;
                        @endphp
                        <a href="{{ route('admin.events.tickets.create', ['event' => $event, 'min_start_date' => $nextStartDate]) }}"
                            class="text-sm font-bold text-primary hover:text-primary-700 transition-colors">
                            + Add Ticket
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                                    <th class="px-6 py-4 rounded-tl-xl text-dark">Ticket Type</th>
                                    <th class="px-6 py-4 text-dark">Price</th>
                                    <th class="px-6 py-4 text-dark">Quota</th>
                                    <th class="px-6 py-4 text-dark">Status</th>
                                    <th class="px-6 py-4 text-dark text-right rounded-tr-xl">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($event->tickets as $ticket)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $ticket->name }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $ticket->description ?? 'No description' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-primary">
                                                {{ $ticket->price == 0 ? 'Free' : 'Rp. ' . number_format($ticket->price, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $ticket->quota }}</div>
                                            <div class="text-xs text-gray-400">Limit:
                                                {{ $ticket->max_purchase_per_user }} / User
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold 
                                                                                                        {{ $ticket->quota > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $ticket->quota > 0 ? 'Available' : 'Sold Out' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.tickets.edit', $ticket) }}"
                                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                    title="Edit Ticket">
                                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST"
                                                    @submit.prevent="formToSubmit = $el; deleteModalOpen = true"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                        title="Delete Ticket">
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
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">
                                            No ticket information available for this event.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Assigned Scanners Table -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8"
                    x-data="{ assignModalOpen: false }">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M11 4a1 1 0 10-2 0v1a1 1 0 002 0V4zM10 7a1 1 0 011 1v1h2a1 1 0 110 2h-3a1 1 0 01-1-1V8a1 1 0 011-1zM16 9a1 1 0 100 2 1 1 0 000-2zM9 13a1 1 0 011-1h1a1 1 0 110 2v2a1 1 0 11-2 0v-3zM7 11a1 1 0 100-2H4a1 1 0 100 2h3zM17 13a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM16 17a1 1 0 100-2h-3a1 1 0 100 2h3z" />
                            </svg>
                            Assigned Scanners
                        </h3>
                        <button @click="assignModalOpen = !assignModalOpen"
                            class="text-sm font-bold text-primary hover:text-primary-700 transition-colors">
                            + Assign Scanner
                        </button>
                    </div>

                    <!-- Scan Assignment Form -->
                    <div x-show="assignModalOpen" @click.away="assignModalOpen = false" x-transition
                        class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <form action="{{ route('admin.events.assign-scanner', $event) }}" method="POST"
                            class="flex gap-4 items-end">
                            @csrf
                            <div class="flex-1">
                                <label for="scanner_id" class="block text-sm font-bold text-gray-700 mb-1">Select
                                    Scanner</label>
                                <select name="scanner_id" id="scanner_id" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <option value="">-- Choose a scanner --</option>
                                    @foreach($scanners as $scanner)
                                        <option value="{{ $scanner->id }}">{{ $scanner->name }} ({{ $scanner->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary/25">
                                Assign
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                                    <th class="px-6 py-4 rounded-tl-xl text-dark">Scanner Name</th>
                                    <th class="px-6 py-4 text-dark">Email</th>
                                    <th class="px-6 py-4 text-dark">Assigned At</th>
                                    <th class="px-6 py-4 text-dark text-right rounded-tr-xl">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($event->scanners as $scanner)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $scanner->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $scanner->email }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 text-sm">
                                            {{ $scanner->pivot->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.events.unassign-scanner', [$event, $scanner]) }}"
                                                method="POST" @submit.prevent="formToSubmit = $el; deleteModalOpen = true"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                    title="Remove Access">
                                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">
                                            No scanners assigned to this event yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Ticket Info Card -->
                <div
                    class="bg-gradient-to-b from-blue-600 to-blue-500 rounded-3xl shadow-xl shadow-blue-500/20 p-8 text-white relative overflow-hidden">
                    <!-- Subtle background decoration -->
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>

                    <h3 class="text-sm font-bold uppercase tracking-wider text-blue-100 mb-1">Entry Ticket</h3>
                    <div class="flex items-baseline gap-2 mb-8">
                        @if($event->ticket)
                            <span class="text-4xl font-extrabold tracking-tight">
                                {{ $event->ticket->price == 0 ? 'Free Entry' : 'Rp. ' . number_format($event->ticket->price, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-2xl font-bold text-blue-200/60 italic">No tickets added yet</span>
                        @endif
                    </div>

                    @if($event->ticket)
                        <div class="space-y-5 mb-8">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-11 h-11 rounded-2xl bg-white/15 flex items-center justify-center border border-white/10">
                                    <svg class="w-5 h-5 text-blue-100" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-blue-200 uppercase tracking-wide">Ticket Type</p>
                                    <p class="text-lg font-bold">{{ $event->ticket->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-11 h-11 rounded-2xl bg-white/15 flex items-center justify-center border border-white/10">
                                    <svg class="w-5 h-5 text-blue-100" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-blue-200 uppercase tracking-wide">Remaining Quota</p>
                                    <p class="text-lg font-bold">{{ $event->ticket->quota }} <span
                                            class="text-sm font-medium text-blue-100">tickets left</span></p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.tickets.edit', $event->ticket) }}"
                            class="block w-full py-4 bg-white text-blue-600 font-bold rounded-2xl text-center hover:bg-blue-50 transition-all shadow-lg active:scale-[0.98]">
                            Edit Ticket Pricing
                        </a>
                    @else
                        <a href="{{ route('admin.events.tickets.create', $event) }}"
                            class="block w-full py-4 bg-white text-blue-600 font-bold rounded-2xl text-center hover:bg-blue-50 transition-all shadow-lg active:scale-[0.98]">
                            Add First Ticket
                        </a>
                    @endif
                </div>

                <!-- Logistics Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Event Info</h4>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400 font-medium font-bold mb-1">Date & Time</p>
                                <p class="font-bold text-gray-900">{{ $event->start_date->format('l, d M Y') }}</p>
                                <p class="text-sm text-gray-500 font-bold">{{ $event->start_date->format('H:i') }} -
                                    {{ $event->end_date->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400 font-medium font-bold mb-1">Category</p>
                                <p class="font-bold text-gray-900">{{ $event->category }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400 font-medium font-bold mb-1">Organizer</p>
                                @if($event->organizer_name)
                                    <div class="flex items-center gap-2">
                                        @if($event->organizer_logo_path)
                                            <img src="{{ Storage::url($event->organizer_logo_path) }}"
                                                class="w-6 h-6 rounded-full object-cover">
                                        @endif
                                        <p class="font-bold text-gray-900">{{ $event->organizer_name }}</p>
                                    </div>
                                @else
                                    <p class="font-bold text-gray-900 italic opacity-50">Not specified</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-notifications.delete />
    </div>
</x-layouts.admin>