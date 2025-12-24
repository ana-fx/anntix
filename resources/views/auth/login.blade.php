<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom scrollbar hide if needed */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<!-- Full screen gradient background with centered content -->

<body
    class="font-sans antialiased text-gray-900 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4 overflow-hidden relative">

    <!-- Geometric Shapes removed by user request -->

    <!-- Main Card Container -->
    <div
        class="relative w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">

        <!-- Left Side: Branding (50%) -->
        <div
            class="w-full md:w-1/2 bg-gradient-to-br from-primary to-primary/90 p-12 text-white flex flex-col justify-center relative overflow-hidden">

            <!-- Branding Content -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <div class="w-3 h-3 bg-primary rounded-full"></div>
                    </div>
                    <span class="text-xl font-bold tracking-wider uppercase">ANNTIX</span>
                </div>

                <h1 class="text-5xl font-bold leading-tight mb-4">Anntix<br>Event Management</h1>

                <p class="text-blue-100 text-sm max-w-xs mt-8 opacity-90 leading-relaxed font-light">
                    The central command center for your event platform. Effortlessly orchestrate schedules, speakers,
                    and attendee experiences with precision.
                </p>
            </div>

        </div>

        <!-- Right Side: Login Form (50%) -->
        <div class="w-full md:w-1/2 bg-white p-12 flex flex-col justify-center">

            <form method="POST" action="{{ route('login.store') }}" class="w-full max-w-sm mx-auto space-y-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="peer w-full border-2 border-gray-200 rounded-md px-4 py-3 text-sm outline-none focus:border-primary transition-colors placeholder-transparent bg-white text-dark"
                                placeholder="Email address">
                            <label for="email" class="absolute left-4 -top-2.5 bg-white px-1 text-xs text-primary font-semibold transition-all
                                   peer-placeholder-shown:text-base peer-placeholder-shown:text-secondary peer-placeholder-shown:top-3.5
                                   peer-focus:-top-2.5 peer-focus:text-primary peer-focus:text-xs">
                                Email address
                            </label>
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <p class="text-xs text-secondary mt-1 ml-1">name@mail.com</p>
                    </div>

                    <div class="relative mt-6" x-data="{ show: false }">
                        <input id="password" :type="show ? 'text' : 'password'" name="password" required
                            class="peer w-full border-2 border-gray-200 rounded-md px-4 py-3 text-sm outline-none focus:border-primary transition-colors placeholder-transparent bg-white text-dark padding-right-10"
                            placeholder="Password">
                        <label for="password" class="absolute left-4 -top-2.5 bg-white px-1 text-xs text-primary font-semibold transition-all
                               peer-placeholder-shown:text-base peer-placeholder-shown:text-secondary peer-placeholder-shown:top-3.5
                               peer-focus:-top-2.5 peer-focus:text-primary peer-focus:text-xs">
                            Password
                        </label>
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-3.5 text-secondary hover:text-dark focus:outline-none">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs mt-2">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary">
                        <label for="remember_me" class="ml-2 text-secondary">Remember me</label>
                    </div>
                    <a href="#" class="text-primary font-semibold hover:underline">Forgot password?</a>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit"
                        class="flex-1 bg-primary text-white font-bold py-3 px-4 rounded shadow-lg hover:bg-primary/90 transition-transform active:scale-95 text-sm uppercase tracking-wider">
                        Login
                    </button>
                    {{-- Sign up button removed/disabled if registration is disabled --}}
                    {{-- <button type="button"
                        class="flex-1 bg-white text-primary border-2 border-primary font-bold py-3 px-4 rounded hover:bg-blue-50 transition-colors text-sm uppercase tracking-wider">
                        Sign up
                    </button> --}}
                </div>



            </form>
        </div>
    </div>
</body>

</html>