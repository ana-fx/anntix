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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex min-h-screen overflow-hidden"
    x-data="{ sidebarOpen: true }">

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
        class="fixed bottom-6 left-6 z-50 p-4 bg-primary text-white rounded-2xl shadow-2xl hover:bg-dark transition-all active:scale-95 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    @stack('scripts')
</body>

</html>