<x-layouts.organizer>
    <x-slot name="title">All Resellers</x-slot>
    <div class="space-y-8">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight">Active Resellers</h2>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">All authorized distribution partners across your events</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                            <th class="px-6 py-4">Reseller Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Assigned Events</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($resellers as $reseller)
                            <tr class="hover:bg-primary/[0.02] transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-xs">
                                            {{ $reseller->initials() }}
                                        </div>
                                        <div class="font-black text-dark text-sm group-hover:text-primary transition-colors">
                                            {{ $reseller->name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-gray-400">
                                    {{ $reseller->email }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($reseller->resellerEvents as $event)
                                            <span class="px-2 py-1 bg-gray-100 rounded-md text-[9px] font-bold text-gray-500 uppercase tracking-wider border border-gray-200">
                                                {{ $event->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $resellers->links() }}
            </div>
        </div>
    </div>
</x-layouts.organizer>
