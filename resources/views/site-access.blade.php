<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encrypted Access | Anntix</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex items-center justify-center p-6 overflow-hidden">

    <!-- Background Decor -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-50/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-50/50 rounded-full blur-3xl"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[30rem] font-black text-gray-50/50 select-none tracking-tighter uppercase">
            ANX</div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-black uppercase tracking-widest mb-8 border border-blue-100">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                Secure Environment
            </div>
            <h1 class="text-6xl font-black text-black tracking-tighter leading-none mb-4">
                Access<span class="text-blue-600">.</span>
            </h1>
            <p class="text-gray-400 font-medium">Please enter the administrative password to unlock Anntix Dashboard.
            </p>
        </div>

        <form action="{{ route('site-access.unlock') }}" method="POST" class="space-y-6" x-data="{ show: false }">
            @csrf
            <div class="relative group">
                <input :type="show ? 'text' : 'password'" name="password" required placeholder="Enter password"
                    class="w-full px-8 py-6 bg-gray-50 border-2 border-transparent rounded-[2rem] text-xl font-bold text-black placeholder:text-gray-300 focus:bg-white focus:border-blue-600 outline-none transition-all duration-300 text-center shadow-inner group-hover:bg-gray-100/50">

                <!-- Eye Icon Toggle -->
                <button type="button" @click="show = !show"
                    class="absolute right-6 top-1/2 -translate-y-1/2 p-2 text-gray-300 hover:text-blue-600 transition-colors focus:outline-none">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>

            @if(session('error'))
                <div class="text-red-500 text-sm font-bold text-center tracking-tight animate-bounce">
                    {{ session('error') }}
                </div>
            @endif

            <button type="submit"
                class="w-full py-5 bg-black text-white font-black rounded-[2rem] text-lg uppercase tracking-widest hover:bg-blue-600 transition-all duration-500 shadow-2xl hover:-translate-y-1 active:scale-95">
                Unlock System
            </button>
        </form>

        <div class="mt-20 text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Authorized Personnel Only</p>
        </div>
    </div>

</body>

</html>