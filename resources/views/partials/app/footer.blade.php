<footer class="bg-dark text-white pt-24 pb-12 mt-20 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Brand Section -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center shadow-lg shadow-white/5">
                        <div class="w-5 h-5 bg-black rounded-full"></div>
                    </div>
                    <span class="font-heading font-extrabold text-2xl tracking-tighter">Anntix</span>
                </div>
                <p class="text-white text-sm leading-relaxed max-w-xs">
                    The premier platform for experiential events and ticket management. Bridging the gap between
                    performers and audiences since 2025.
                </p>
                <div class="flex gap-4">
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all group">
                        <svg class="w-4 h-4 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all group">
                        <svg class="w-4 h-4 text-white group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="lg:pl-10">
                <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Discovery</h4>
                <ul class="space-y-4 text-sm font-medium text-white">
                    <li><a href="#" class="hover:text-white transition-colors">Find Events</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Top Categories</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Pricing Plan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Support Center</a></li>
                </ul>
            </div>

            <!-- Legal Links -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Company</h4>
                <ul class="space-y-4 text-sm font-medium text-white">
                    <li><a href="{{ route('pages.services') }}" class="hover:text-white transition-colors">About Us</a>
                    </li>
                    <li><a href="{{ route('pages.privacy') }}" class="hover:text-white transition-colors">Privacy
                            Policy</a></li>
                    <li><a href="{{ route('pages.terms') }}" class="hover:text-white transition-colors">Terms of
                            Service</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-white transition-colors">Admin Portal</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Contact Us</h4>
                <ul class="space-y-4 text-sm font-medium text-white">
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <a href="mailto:support@anntix.com"
                            class="hover:text-primary transition-colors">support@anntix.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <span>+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span>Jakarta, Indonesia</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] text-secondary">
                &copy; {{ date('Y') }} Anntix Entertainment Inc. Built with Passion.
            </p>
            <div class="flex items-center gap-2 text-[10px] font-bold text-gray-700">
                <span class="w-1 h-1 bg-green-500 rounded-full animate-pulse"></span>
                SYSTEM STATUS: OPERATIONAL
            </div>
        </div>
    </div>
</footer>