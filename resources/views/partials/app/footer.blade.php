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
                <p class="text-secondary text-sm leading-relaxed max-w-xs">
                    The premier platform for experiential events and ticket management. Bridging the gap between
                    performers and audiences since 2025.
                </p>
                <div class="flex gap-4">
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all group">
                        <svg class="w-4 h-4 text-secondary group-hover:text-white" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all group">
                        <svg class="w-4 h-4 text-secondary group-hover:text-white" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="lg:pl-10">
                <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Discovery</h4>
                <ul class="space-y-4 text-sm font-medium text-secondary">
                    <li><a href="#" class="hover:text-white transition-colors">Find Events</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Top Categories</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Pricing Plan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Support Center</a></li>
                </ul>
            </div>

            <!-- Legal Links -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Company</h4>
                <ul class="space-y-4 text-sm font-medium text-secondary">
                    <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-white transition-colors">Admin Portal</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter Mockup -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Keep in Touch</h4>
                <p class="text-xs text-secondary mb-4 font-medium leading-relaxed">Join our weekly newsletter to get the
                    latest updates on global events.</p>
                <div class="relative group">
                    <input type="email" placeholder="Email Address"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 flex pl-5 pr-14 text-sm focus:outline-none focus:border-primary transition-all">
                    <button
                        class="absolute right-2 top-2 bottom-2 px-4 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] text-gray-600">
                &copy; {{ date('Y') }} Anntix Entertainment Inc. Built with Passion.
            </p>
            <div class="flex items-center gap-2 text-[10px] font-bold text-gray-700">
                <span class="w-1 h-1 bg-green-500 rounded-full animate-pulse"></span>
                SYSTEM STATUS: OPERATIONAL
            </div>
        </div>
    </div>
</footer>