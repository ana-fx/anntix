<div class="w-64 bg-gradient-to-b from-blue-600 to-blue-500 text-white min-h-screen flex flex-col shadow-xl">
    <!-- Branding -->
    <div class="h-24 flex items-center px-8 border-b border-blue-400/30">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                <div class="w-2.5 h-2.5 bg-blue-600 rounded-full"></div>
            </div>
            <span class="text-lg font-bold tracking-wider uppercase">ANNTIX</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-8 px-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 rounded-xl text-sm font-semibold shadow-inner border border-white/10 transition-all hover:bg-white/20">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <!-- Placeholder Links -->
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-100 hover:bg-white/10 rounded-xl text-sm font-medium transition-colors">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Users
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-100 hover:bg-white/10 rounded-xl text-sm font-medium transition-colors">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Events
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-100 hover:bg-white/10 rounded-xl text-sm font-medium transition-colors">
             <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Reports
        </a>
    </nav>

</div>
