<x-layouts.reseller title="Dashboard">
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-dark uppercase tracking-tight">Reseller Dashboard</h1>
                <p class="text-secondary mt-1">Welcome back, <span
                        class="text-primary font-bold">{{ Auth::user()->name }}</span>. Here's your performance
                    overview.</p>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="px-5 py-3 bg-white border border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-dark shadow-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download Report
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Sales -->
            <div
                class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Total Sales</p>
                <h3 class="text-3xl font-black text-dark tracking-tighter">Rp {{ number_format($stats['total_sales']) }}
                </h3>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg">+0%</span>
                    <span class="text-[10px] text-gray-400 font-medium">vs last month</span>
                </div>
            </div>

            <!-- Commission Earned -->
            <div
                class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10v2a2 2 0 002 2h2a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h4a2 2 0 110 4H8a2 2 0 01-2-2zm11 7a2 2 0 002-2v-4a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1h1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Commission</p>
                <h3 class="text-3xl font-black text-dark tracking-tighter">Rp
                    {{ number_format($stats['total_commission']) }}
                </h3>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-lg">Available</span>
                </div>
            </div>

            <!-- Active Events -->
            <div
                class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Active Events</p>
                <h3 class="text-3xl font-black text-dark tracking-tighter">{{ $stats['active_events'] }}</h3>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-[10px] text-gray-400 font-medium whitespace-nowrap">Promote events to earn</span>
                </div>
            </div>

            <!-- Tickets Sold -->
            <div
                class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                    </svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Tickets Sold</p>
                <h3 class="text-3xl font-black text-dark tracking-tighter">{{ $stats['tickets_sold'] }}</h3>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-[10px] text-gray-400 font-medium whitespace-nowrap">Your lifetime impact</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Active Events -->
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                    <h2 class="text-xl font-black text-dark uppercase tracking-tight">Active Events</h2>
                </div>
                <div class="overflow-x-auto">
                    @if($events->count() > 0)
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-gray-50">
                                @foreach($events as $event)
                                    <tr class="group hover:bg-gray-50/50 transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $event->thumbnail_path ? Storage::url($event->thumbnail_path) : 'https://via.placeholder.com/100' }}"
                                                    class="w-16 h-16 rounded-xl object-cover shadow-sm">
                                                <div>
                                                    <h4 class="font-bold text-dark text-lg">{{ $event->name }}</h4>
                                                    <div class="flex items-center gap-2 text-sm text-gray-400 mt-1">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>{{ $event->start_date->format('d M Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('reseller.transactions.create', $event) }}"
                                                class="inline-block px-6 py-3 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                                                Buy Ticket
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center py-12">
                            <div
                                class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-dark mb-1">No active events</h4>
                            <p class="text-sm text-secondary">Check back later for new events.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Profile -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-primary/5">
                    <h2 class="text-xl font-black text-dark uppercase tracking-tight text-center">Your Profile</h2>
                </div>
                <div class="p-8 text-center">
                    <div class="mb-6">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                class="w-24 h-24 rounded-[2rem] mx-auto object-cover ring-4 ring-primary/5">
                        @else
                            <div
                                class="w-24 h-24 bg-primary/10 text-primary rounded-[2rem] flex items-center justify-center text-3xl font-black mx-auto ring-4 ring-primary/5">
                                {{ Auth::user()->initials() }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-xl font-black text-dark uppercase tracking-tight leading-none mb-1">
                        {{ Auth::user()->name }}
                    </h3>
                    <p class="text-xs font-bold text-primary uppercase tracking-widest mb-4">Official Reseller</p>
                    <p class="text-sm text-secondary px-4">{{ Auth::user()->bio ?? 'No bio provided.' }}</p>

                    <div class="mt-8 pt-8 border-t border-gray-50 space-y-3">
                        <div class="flex items-center justify-between text-left">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</span>
                            <span class="text-xs font-black text-dark">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex items-center justify-between text-left">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Phone</span>
                            <span class="text-xs font-black text-dark">{{ Auth::user()->phone ?? '-' }}</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.profile') }}"
                        class="mt-8 block w-full py-4 bg-gray-50 hover:bg-primary hover:text-white text-dark text-xs font-black uppercase tracking-widest rounded-2xl transition-all">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.reseller>