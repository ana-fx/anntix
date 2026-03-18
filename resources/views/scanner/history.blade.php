<x-layouts.scanner>
    <div class="h-full flex flex-col pt-safe bg-slate-50">

        <!-- Header -->
        <header
            class="bg-white border-b border-gray-100 h-24 flex items-center justify-between px-4 md:px-8 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2.5 rounded-xl bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-primary transition-all duration-200 focus:outline-none group">
                    <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div>
                    <h1 class="text-lg font-extrabold text-slate-900 tracking-tight leading-tight">Scan History</h1>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Your recent activity</p>
                </div>
            </div>

            <a href="{{ route('scanner.index') }}" class="w-12 h-12 bg-primary/5 text-primary rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-200" title="Back to Scanner">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto pb-24 scrollbar-hide">
            <div class="max-w-4xl mx-auto space-y-6">
                <!-- Data Widget -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Scans Today</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $todayScansCount }}</h3>
                    </div>
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Last Update</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ now()->format('H:i') }}</h3>
                    </div>
                </div>

                <div class="flex items-center justify-between px-2">
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Full Activity Log</h2>
                    <span class="px-3 py-1 bg-slate-100 rounded-full text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $scans->total() }} Records</span>
                </div>
                @forelse($scans as $scan)
                    <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex items-center justify-between group hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary/5 group-hover:text-primary transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 mb-0.5">{{ $scan->transaction->name }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $scan->transaction->ticket->event->name }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest">{{ $scan->transaction->ticket->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-slate-900">{{ $scan->created_at->format('H:i') }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ $scan->created_at->format('d M') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-black text-slate-900 uppercase tracking-widest">No History Yet</p>
                        <p class="text-xs text-slate-400 font-medium mt-1">Start scanning tickets to see them here.</p>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $scans->links() }}
                </div>
            </div>
        </main>
    </div>
</x-layouts.scanner>
