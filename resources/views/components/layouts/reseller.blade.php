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


    @stack('scripts')
</body>

</html>
