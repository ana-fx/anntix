<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom scrollbar hide if needed */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<!-- Full screen gradient background with centered content -->
<body class="font-sans antialiased text-gray-900 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4 overflow-hidden relative">

    <!-- Geometric Shapes removed by user request -->

    <!-- Main Card Container -->
    <div class="relative w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">

        <!-- Left Side: Branding (50%) -->
        <div class="w-full md:w-1/2 bg-gradient-to-br from-blue-600 to-blue-500 p-12 text-white flex flex-col justify-center relative overflow-hidden">

            <!-- Branding Content -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                    </div>
                    <span class="text-xl font-bold tracking-wider uppercase">ANNTIX</span>
                </div>

                <h1 class="text-5xl font-bold leading-tight mb-4">Anntix<br>Event Management</h1>

                <p class="text-blue-100 text-sm max-w-xs mt-8 opacity-90 leading-relaxed font-light">
                    The central command center for your event platform. Effortlessly orchestrate schedules, speakers, and attendee experiences with precision.
                </p>
            </div>

        </div>

        <!-- Right Side: Login Form (50%) -->
        <div class="w-full md:w-1/2 bg-white p-12 flex flex-col justify-center">

            <form method="POST" action="{{ route('admin.login.store') }}" class="w-full max-w-sm mx-auto space-y-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="peer w-full border-2 border-blue-100 rounded-md px-4 py-3 text-sm outline-none focus:border-blue-500 transition-colors placeholder-transparent bg-white text-gray-800"
                            placeholder="Email address">
                            <label for="email"
                            class="absolute left-4 -top-2.5 bg-white px-1 text-xs text-blue-500 font-semibold transition-all
                                   peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5
                                   peer-focus:-top-2.5 peer-focus:text-blue-500 peer-focus:text-xs">
                                Email address
                            </label>
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <p class="text-xs text-gray-400 mt-1 ml-1">name@mail.com</p>
                    </div>

                    <div class="relative mt-6">
                        <input id="password" type="password" name="password" required
                        class="peer w-full border-2 border-blue-100 rounded-md px-4 py-3 text-sm outline-none focus:border-blue-500 transition-colors placeholder-transparent bg-white text-gray-800"
                        placeholder="Password">
                        <label for="password"
                        class="absolute left-4 -top-2.5 bg-white px-1 text-xs text-blue-500 font-semibold transition-all
                               peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5
                               peer-focus:-top-2.5 peer-focus:text-blue-500 peer-focus:text-xs">
                            Password
                        </label>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs mt-2">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <label for="remember_me" class="ml-2 text-gray-500">Remember me</label>
                    </div>
                    <a href="#" class="text-blue-500 font-semibold hover:underline">Forgot password?</a>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 px-4 rounded shadow-lg hover:bg-blue-700 transition-transform active:scale-95 text-sm uppercase tracking-wider">
                        Login
                    </button>
                    <button type="button" class="flex-1 bg-white text-blue-600 border-2 border-blue-600 font-bold py-3 px-4 rounded hover:bg-blue-50 transition-colors text-sm uppercase tracking-wider">
                        Sign up
                    </button>
                </div>



            </form>
        </div>
    </div>
</body>
</html>
