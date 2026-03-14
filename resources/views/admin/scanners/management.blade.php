<x-layouts.admin>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-dark">Scanner Management</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor and manage ticket scans grouped by scanner account.</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.scanner-management.index') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-64 pl-10 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm"
                    placeholder="Search scanner name/email...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.008v.008H6.75V6.75ZM6.75 16.5h.008v.008H6.75V16.5ZM16.5 6.75h.008v.008H16.5V6.75ZM13.5 13.5h.008v.008H13.5V13.5ZM13.5 19.5h.008v.008H13.5V19.5ZM19.5 13.5h.008v.008H19.5V13.5ZM19.5 19.5h.008v.008H19.5V19.5ZM16.5 16.5h.008v.008H16.5V16.5Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Scanners</p>
                <p class="text-2xl font-black text-dark tracking-tight">{{ \App\Models\User::where('role', 'scanner')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-green-500/10 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Scans</p>
                <p class="text-2xl font-black text-dark tracking-tight">{{ \App\Models\TransactionScan::count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Scans (Today)</p>
                <p class="text-2xl font-black text-dark tracking-tight">{{ \App\Models\TransactionScan::whereDate('created_at', today())->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4">Scanner Name</th>
                        <th class="px-6 py-4">Contact Info</th>
                        <th class="px-6 py-4 text-center">Total Scans</th>
                        <th class="px-6 py-4">Last Activity</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($scanners as $scanner)
                        <tr class="hover:bg-gray-50/10 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                                        {{ $scanner->name[0] }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-dark">{{ $scanner->name }}</div>
                                        <div class="inline-flex mt-1">
                                            <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $scanner->is_active ? 'bg-green-100 text-green-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ $scanner->is_active ? 'Active' : 'Disabled' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ $scanner->email }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $scanner->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-primary/5 text-primary rounded-full font-black text-sm">
                                    {{ $scanner->scanner_scans_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($scanner->scannerScans->first())
                                    <div class="text-sm text-gray-700">{{ $scanner->scannerScans->first()->created_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase font-black tracking-widest mt-0.5">{{ $scanner->scannerScans->first()->created_at->format('H:i:s') }}</div>
                                @else
                                    <span class="text-xs text-gray-400 italic">No activity yet</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.scanner-management.show', $scanner) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-dark text-white text-xs font-bold rounded-xl hover:bg-dark/90 transition-all shadow-sm">
                                    View Detailed Logs
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="font-bold">No scanner accounts found.</p>
                                    <p class="text-sm">Try using different search keywords.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($scanners->hasPages())
            <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                {{ $scanners->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
