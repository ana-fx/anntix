<x-layouts.admin>

    <!-- Dashboard Header -->
    <div class="mb-10 flex items-end justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
        <div class="text-sm text-gray-400 font-mono">
            {{ now()->format('D, M d Y') }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Users</p>
                <p class="text-2xl font-bold text-gray-900">1,234</p>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
             <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Active Events</p>
                <p class="text-2xl font-bold text-gray-900">56</p>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
             <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tickets Sold</p>
                <p class="text-2xl font-bold text-gray-900">8,942</p>
            </div>
        </div>

         <!-- Stat Card 4 -->
         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
             <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Revenue</p>
                <p class="text-2xl font-bold text-gray-900">$45.2k</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h3 class="font-bold text-lg text-gray-900">Recent Users</h3>
        </div>
        <div class="p-8 text-center text-gray-400 py-20">
            No recent user activity found.
        </div>
    </div>

</x-layouts.admin>
