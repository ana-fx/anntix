<x-layouts.app title="Privacy Policy">
    <div class="bg-white min-h-screen">
        <!-- Minimalist Hero -->
        <div class="pt-40 pb-20 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/5 text-primary text-xs font-bold uppercase tracking-widest mb-6">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    Privacy Commitment
                </div>
                <h1 class="text-6xl md:text-8xl font-heading font-black text-dark tracking-tighter leading-none mb-8">
                    Privacy <br>
                    <span class="text-primary/20">Policy.</span>
                </h1>
                <p class="text-xl text-gray-500 max-w-2xl leading-relaxed">
                    We value your trust. This policy outlines our commitment to being transparent about how we handle
                    your data.
                </p>
            </div>

            <!-- Minimalist Decorative Element -->
            <div class="absolute top-0 right-0 -z-10 w-1/2 h-full bg-gray-50/50 skew-x-12 transform origin-top-right">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                <!-- Sidebar Nav -->
                <div class="lg:col-span-3 hidden lg:block">
                    <div class="sticky top-32 space-y-4">
                        <div
                            class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-100 pb-2">
                            Contents</div>
                        <a href="#collect"
                            class="block text-sm font-bold text-dark hover:text-primary transition-colors">1. Data
                            Collection</a>
                        <a href="#usage"
                            class="block text-sm font-medium text-gray-400 hover:text-dark transition-colors">2. Purpose
                            & Usage</a>
                        <a href="#sharing"
                            class="block text-sm font-medium text-gray-400 hover:text-dark transition-colors">3. Third
                            Parties</a>
                        <a href="#security"
                            class="block text-sm font-medium text-gray-400 hover:text-dark transition-colors">4.
                            Security Measures</a>
                    </div>
                </div>

                <!-- Main Content -->
                <div
                    class="lg:col-span-9 prose prose-2xl prose-primary max-w-none text-black prose-headings:text-dark prose-headings:font-black prose-headings:tracking-tighter">
                    <section id="collect" class="mb-20">
                        <h2 class="text-4xl mb-8">Data Collection</h2>
                        <p class="text-lg leading-relaxed text-black/80">
                            When you use Anntix, we collect information that you provide to us directly, information we
                            collect automatically, and information from third-party sources.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 not-prose mt-12">
                            <div
                                class="group border-l-2 border-primary/20 hover:border-primary pl-8 py-4 transition-all">
                                <h4 class="font-black text-dark mb-2 text-sm uppercase tracking-widest">Direct
                                    Information</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Name, email, phone, billing address,
                                    and identity
                                    verification (NIK) for event security.</p>
                            </div>
                            <div
                                class="group border-l-2 border-primary/20 hover:border-primary pl-8 py-4 transition-all">
                                <h4 class="font-black text-dark mb-2 text-sm uppercase tracking-widest">Usage Data</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">IP address, device identifiers,
                                    browsing patterns, and transaction history.</p>
                            </div>
                        </div>
                    </section>

                    <section id="usage" class="mb-20">
                        <h2 class="text-4xl mb-8">Purpose & Usage</h2>
                        <p class="text-lg leading-relaxed text-black/80">We use your data to deliver and improve our
                            services, including:</p>
                        <ul class="space-y-4 text-lg list-none pl-0">
                            <li class="flex items-start gap-4">
                                <span class="w-6 h-px bg-primary mt-4 flex-shrink-0"></span>
                                Processing ticket purchases and generating unique QR codes.
                            </li>
                            <li class="flex items-start gap-4">
                                <span class="w-6 h-px bg-primary mt-4 flex-shrink-0"></span>
                                Sending updates, cancellations, or venue change notifications.
                            </li>
                            <li class="flex items-start gap-4">
                                <span class="w-6 h-px bg-primary mt-4 flex-shrink-0"></span>
                                Fraud prevention and ensuring platform integrity.
                            </li>
                        </ul>
                    </section>

                    <section id="security" class="mb-20">
                        <h2 class="text-4xl mb-8">Security Measures</h2>
                        <p class="text-lg leading-relaxed text-black/80">
                            We use bank-grade encryption to protect your data during transmission and storage. Our
                            systems are routinely audited to ensure the highest standards of protection.
                        </p>
                    </section>

                    <div
                        class="pt-20 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-8">
                        <div>
                            <div class="text-xs text-gray-400 uppercase tracking-widest mb-2 font-bold">Contact
                                Representative</div>
                            <a href="mailto:privacy@anntix.com"
                                class="text-2xl font-black hover:text-primary transition-colors">privacy@anntix.com</a>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-400 uppercase tracking-widest mb-2 font-bold">Last Update
                            </div>
                            <div class="text-lg font-bold text-dark">{{ date('F d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>