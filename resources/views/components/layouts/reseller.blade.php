<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(isset($title))
            {{ ($global_settings['site_name'] ?? 'ANTIX') . ' | ' . $title }}
        @else
            {{ ($global_settings['site_name'] ?? 'ANTIX') . ' | Reseller' }}
        @endif
    </title>
    @if(isset($global_settings['site_icon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $global_settings['site_icon']) }}">
    @endif

    <!-- Scripts -->
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex min-h-screen overflow-hidden"
    x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <!-- Sidebar -->
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="relative z-30 transition-all duration-300 ease-in-out flex-shrink-0">
        @include('partials.reseller.sidebar')
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto h-screen">

        <!-- Header (Reuse admin header or create reseller one if needed) -->
        @include('partials.admin.header')

        <!-- Page Content -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('partials.admin.footer')
    </div>

    <!-- Floating Toggle -->
    <button x-show="!sidebarOpen" @click="sidebarOpen = true" x-cloak
        class="fixed bottom-8 left-8 z-50 p-4 bg-primary text-white rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:bg-primary-700 hover:shadow-primary/30 transition-all duration-300 hover:scale-110 active:scale-95 flex items-center justify-center group">
        <div class="absolute inset-0 bg-primary/20 rounded-full animate-ping opacity-0 group-hover:opacity-100"></div>
        <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    @stack('scripts')
</body>

</html>
