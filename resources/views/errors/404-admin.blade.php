<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-blue-600 min-h-screen w-full flex items-center justify-center overflow-hidden relative selection:bg-white selection:text-blue-600">

    <!-- Geometric background patterns (SVG) -->
    <div class="absolute inset-0 w-full h-full pointer-events-none opacity-20">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 L100 0 L100 100 Z" fill="url(#grad1)"></path>
            <defs>
                <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:white;stop-opacity:0" />
                    <stop offset="100%" style="stop-color:white;stop-opacity:0.3" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <!-- Decorative Circles -->
    <div
        class="absolute top-[-20%] right-[-10%] w-[50vw] h-[50vw] rounded-full border border-blue-400/30 opacity-30 blur-[1px]">
    </div>
    <div
        class="absolute top-[-15%] right-[-5%] w-[40vw] h-[40vw] rounded-full border border-blue-400/30 opacity-30 blur-[1px]">
    </div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-blue-500/50 rounded-full blur-3xl"></div>

    <!-- Main Content -->
    <div
        class="relative z-10 w-full max-w-5xl px-8 flex flex-col md:flex-row items-center justify-between gap-12 text-white">

        <!-- Left: Text Context -->
        <div class="flex-1 text-center md:text-left space-y-8">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/50 border border-blue-400/50 backdrop-blur-md">
                <span class="flex h-2 w-2 relative">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                <span class="text-xs font-bold tracking-widest uppercase text-blue-50">System Notice</span>
            </div>

            <h2 class="text-4xl md:text-6xl font-bold leading-tight tracking-tight">
                This page has gone<br>
                <span class="text-blue-200">off grid.</span>
            </h2>

            <p class="text-lg text-blue-100 max-w-md mx-auto md:mx-0 leading-relaxed font-light opacity-90">
                The requested URL was not found on this server. It might have been moved, renamed, or is temporarily
                unavailable.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-8 py-4 bg-white text-blue-600 font-bold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Return to Dashboard
                </a>
                <a href="{{ url()->previous() }}"
                    class="px-8 py-4 bg-blue-700/50 border border-blue-400/30 text-white font-semibold rounded-xl hover:bg-blue-700 hover:border-blue-400/50 transition-all duration-300 backdrop-blur-sm">
                    Back
                </a>
            </div>
        </div>

        <!-- Right: Massive Number -->
        <div class="flex-1 relative flex items-center justify-center">
            <!-- Background glow behind number -->
            <div class="absolute inset-0 bg-blue-400/20 blur-[60px] rounded-full"></div>

            <h1 class="relative text-[12rem] md:text-[16rem] leading-none font-black tracking-tighter text-transparent select-none"
                style="-webkit-text-stroke: 4px rgba(255,255,255,0.2);">
                <span class="absolute inset-0 text-white/10 blur-sm transform translate-x-2 translate-y-2">404</span>
                <span
                    class="relative z-10 bg-clip-text text-transparent bg-gradient-to-br from-white to-blue-200 opacity-90">404</span>
            </h1>
        </div>

    </div>

    <!-- Footer -->
    <div class="absolute bottom-6 w-full text-center">
        <p class="text-blue-200/40 text-xs font-mono tracking-widest uppercase">ANNTIX ADMIN CONSOLE // ERROR_LOG_404
        </p>
    </div>

</body>

</html>