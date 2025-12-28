<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Scanner' }} - Anntix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-900 text-white h-full antialiased selection:bg-purple-500 selection:text-white"
    x-data="scannerLayout()">

    <div class="fixed inset-0 z-[-1]">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-purple-900/50 to-transparent opacity-50">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-blue-900/20 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2">
        </div>
    </div>

    <div class="min-h-full flex flex-col">
        <!-- Glassmorphism Header -->
        <header class="sticky top-0 z-50 backdrop-blur-xl bg-gray-900/70 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-tr from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 17h.01M8 11h16M12 5l7 7-7 7M5 5l-7 7 7 7" />
                            </svg>
                        </div>
                        <span
                            class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">Scanner</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-bold text-white">{{ Auth::user()->name }}</span>
                            <span class="text-xs text-gray-400">Authorized Personnel</span>
                        </div>
                        <div class="h-8 w-px bg-white/10 mx-2 hidden sm:block"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative">
            {{ $slot }}
        </main>

        <!-- Footer Partial -->
        @include('layouts.partials.scanner-footer')
    </div>

    <script>
        function scannerLayout() {
            return {
                // Layout specific logic if needed
            }
        }
    </script>
</body>

</html>