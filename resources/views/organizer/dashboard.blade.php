<x-layouts.organizer title="Dashboard">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight">Dashboard Overview</h2>
            <p class="text-gray-500 mt-1 font-medium">Welcome back, <span class="text-primary font-bold">{{ Auth::user()->name }}</span>. Here's your event performance.</p>
        </div>
        <div class="text-sm font-bold text-gray-400 font-mono bg-gray-100 px-4 py-2 rounded-xl">
            {{ now()->format('D, d M Y') }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Revenue Card -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mb-1">Total Revenue</p>
                <p class="text-2xl font-black text-dark tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shadow-lg ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Tickets Sold -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mb-1">Tickets Sold</p>
                <p class="text-2xl font-black text-dark tracking-tight">{{ number_format($ticketsSold) }}</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shadow-lg ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
        </div>

        <!-- Active Events -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mb-1">Active Events</p>
                <p class="text-2xl font-black text-dark tracking-tight">{{ number_format($activeEvents) }}</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shadow-lg ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <!-- Dedicated Resellers -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mb-1">Active Resellers</p>
                <p class="text-2xl font-black text-dark tracking-tight">{{ number_format($totalResellers) }}</p>
            </div>
            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shadow-lg ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <!-- Chart Section -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-dark tracking-tight">Revenue Analytics</h3>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Last 30 Days Performance</p>
                </div>
                <button class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-dark hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col h-full">
            <h3 class="text-xl font-black text-dark tracking-tight mb-6">Recent Activity</h3>

            <div class="flex-1 space-y-4 overflow-y-auto pr-2 custom-scrollbar">
                @forelse($recentTransactions as $transaction)
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 hover:bg-primary/5 transition-colors border border-gray-50 group">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline justify-between mb-0.5">
                                <p class="text-sm font-black text-dark truncate">{{ $transaction->name }}</p>
                                <span class="text-[10px] font-bold text-gray-400">{{ $transaction->created_at->diffForHumans(null, true, true) }}</span>
                            </div>
                            <p class="text-xs font-medium text-gray-500 group-hover:text-primary transition-colors truncate">
                                {{ $transaction->event->name }}
                                <span class="text-primary font-bold">• Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-40 text-center opacity-40">
                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-sm font-bold text-gray-500">No recent activity</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('organizer.reports.transactions') }}" class="mt-6 flex items-center justify-center w-full py-3 bg-gray-100 rounded-xl text-xs font-black uppercase tracking-widest text-gray-500 hover:bg-dark hover:text-white transition-all">
                View All History
            </a>
        </div>
    </div>

    <!-- My Events Table (Preserved and styled) -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-xl font-black text-dark uppercase tracking-tight">Active Campaigns</h2>
            <a href="{{ route('organizer.events.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:text-primary-700 transition-colors">
                View All Events →
            </a>
        </div>

        @if($recentEvents->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-50">
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Event</th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Date</th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tickets sold</th>
                            <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentEvents as $event)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="font-bold text-dark">{{ $event->name }}</div>
                                <div class="text-xs text-gray-400">{{ $event->location ?? '-' }}</div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="text-sm font-bold text-dark">{{ $event->start_date->format('d M') }}</div>
                                <div class="text-[10px] text-gray-400 font-medium">{{ $event->start_date->format('Y') }}</div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span @class([
                                    'px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest inline-block shadow-sm',
                                    'bg-green-100 text-green-700' => $event->status === 'active',
                                    'bg-gray-100 text-gray-500' => $event->status === 'draft',
                                    'bg-red-100 text-red-700' => !in_array($event->status, ['active', 'draft'])
                                ])>
                                    {{ $event->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="text-sm font-black text-dark">{{ number_format($event->transactions_count) }}</div>
                                <div class="text-[9px] text-gray-400 font-bold uppercase">Paid</div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('organizer.events.show', $event) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-dark mb-1">No campaigns active</h4>
                <p class="text-sm text-secondary mb-6">You don't have any events assigned yet.</p>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('revenueChart').getContext('2d');

                // Gradient for the chart
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); // Primary color with opacity
                gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! $chartLabels !!},
                        datasets: [{
                            label: 'Daily Revenue',
                            data: {!! $chartData !!},
                            borderColor: '#4F46E5', // Primary color (Indigo 600)
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#4F46E5',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleFont: {
                                    family: "'Inter', sans-serif",
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#F3F4F6',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 10,
                                        weight: '600'
                                    },
                                    color: '#9CA3AF',
                                    callback: function(value) {
                                        if (value >= 1000000) return 'Rp ' + (value/1000000) + 'M';
                                        if (value >= 1000) return 'Rp ' + (value/1000) + 'k';
                                        return 'Rp ' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 10,
                                        weight: '600'
                                    },
                                    color: '#9CA3AF'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layouts.organizer>
