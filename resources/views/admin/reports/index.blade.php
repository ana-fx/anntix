<x-layouts.admin>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-dark">Sales Reports</h1>
        
        <!-- Date Filter Form -->
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-xl border border-gray-100 shadow-sm">
            <input type="date" name="start_date" value="{{ $startDate }}" class="bg-gray-50 border-none rounded-lg text-sm font-medium focus:ring-primary/20">
            <span class="text-gray-400">-</span>
            <input type="date" name="end_date" value="{{ $endDate }}" class="bg-gray-50 border-none rounded-lg text-sm font-medium focus:ring-primary/20">
            <button type="submit" class="p-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Revenue -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-secondary text-xs uppercase tracking-wider font-bold">Total Revenue</h3>
                    <p class="text-xs text-gray-400">In selected period</p>
                </div>
            </div>
            <div class="text-3xl font-black text-dark tracking-tight">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>

        <!-- Tickets -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-secondary text-xs uppercase tracking-wider font-bold">Tickets Sold</h3>
                     <p class="text-xs text-gray-400">In selected period</p>
                </div>
            </div>
            <div class="text-3xl font-black text-dark tracking-tight">
                {{ number_format($ticketsSold) }}
            </div>
        </div>

        <!-- Transactions -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                     <h3 class="text-secondary text-xs uppercase tracking-wider font-bold">Total Transactions</h3>
                      <p class="text-xs text-gray-400">Paid transactions</p>
                </div>
            </div>
            <div class="text-3xl font-black text-dark tracking-tight">
                {{ number_format($totalTransactions) }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Event Performance Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-dark text-lg">Top Performing Events</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Event Name</th>
                            <th class="px-6 py-4 text-right">Tickets</th>
                            <th class="px-6 py-4 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($revenueByEvent as $event)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 font-medium text-dark">{{ Str::limit($event->name, 40) }}</td>
                                <td class="px-6 py-4 text-right">{{ $event->total_tickets }}</td>
                                <td class="px-6 py-4 text-right font-bold text-green-600">Rp {{ number_format($event->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                             <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-400">No data available for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Simple Daily Chart (Visual Representation using CSS bars) -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-dark text-lg mb-6">Daily Revenue Trend</h3>
            
            <div class="h-64 flex items-end gap-2">
                @if($chartRevenue->count() > 0)
                    @php $maxRevenue = $chartRevenue->max(); @endphp
                    @foreach($dailyRevenue as $day)
                        @php 
                            $height = $maxRevenue > 0 ? ($day->revenue / $maxRevenue) * 100 : 0; 
                        @endphp
                        <div class="flex-1 flex flex-col items-center group relative">
                            <!-- Tooltip -->
                            <div class="absolute bottom-full mb-2 opacity-0 group-hover:opacity-100 transition-opacity bg-dark text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10 pointer-events-none">
                                {{ $day->date }}: Rp {{ number_format($day->revenue, 0, ',', '.') }}
                            </div>
                            
                            <!-- Bar -->
                            <div class="w-full bg-blue-100 rounded-t-sm hover:bg-primary transition-colors duration-300 relative" style="height: {{ $height }}%"></div>
                        </div>
                    @endforeach
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                        No chart data available
                    </div>
                @endif
            </div>
             <div class="flex justify-between text-xs text-gray-400 mt-2 border-t border-gray-100 pt-2">
                <span>{{ $startDate }}</span>
                <span>{{ $endDate }}</span>
            </div>
        </div>
    </div>
    <!-- Detailed Transaction History -->
    <div class="mt-8 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-dark text-lg">Detailed Transaction History</h3>
             <p class="text-xs text-gray-400">Showing latest transactions first</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Ref ID</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Buyer Identity</th>
                        <th class="px-6 py-4">Event Info</th>
                        <th class="px-6 py-4 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                {{ $trx->code }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $trx->created_at->format('M d, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-dark">{{ $trx->name }}</div>
                                <div class="text-xs text-secondary mb-1">{{ $trx->email }}</div>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">{{ $trx->nik ?? 'N/A' }}</span>
                                    <span class="capitalize">{{ $trx->gender ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-dark">{{ $trx->event->name ?? 'Deleted Event' }}</div>
                                <div class="text-xs text-secondary">{{ $trx->ticket->name ?? 'Ticket' }} (x{{ $trx->quantity }})</div>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-dark">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">No transactions found in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transactions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
