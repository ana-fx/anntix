<x-layouts.app>
    <div class="bg-gray-50 min-h-screen">
        <!-- Creative Header -->
        <div class="bg-dark relative overflow-hidden h-[400px] flex items-center justify-center">
            <div class="absolute inset-0">
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full blur-3xl">
                </div>
                <!-- Grid Pattern -->
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;">
                </div>
            </div>

            <div class="relative z-10 text-center max-w-2xl px-6">
                <div
                    class="inline-block px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-widest text-primary mb-6">
                    Legal Documentation
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-white tracking-tight mb-4">
                    Terms of Service
                </h1>
                <p class="text-gray-400 text-lg">
                    Essential guidelines to ensure a safe and transparent experience for everyone.
                </p>
            </div>
        </div>

        <!-- Content Container -->
        <div class="max-w-4xl mx-auto px-6 -mt-20 relative z-20 pb-20">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <!-- Last Updated Bar -->
                <div
                    class="bg-gray-50/50 border-b border-gray-100 px-8 py-4 flex items-center gap-2 text-sm text-gray-500 font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Last Updated: December 25, 2025
                </div>

                <div
                    class="p-8 md:p-12 prose prose-lg prose-headings:font-bold prose-headings:text-dark prose-p:text-gray-600 prose-a:text-primary max-w-none">

                    <h3>1. Introduction</h3>
                    <p>
                        Welcome to <strong>Anntix</strong> ("we," "our," or "us"). By accessing or using our website,
                        mobile application, and ticketing services (collectively, the "Services"), you agree to be bound
                        by these Terms of Service ("Terms"). If you do not agree to these Terms, please do not use our
                        Services.
                    </p>

                    <h3>2. Use of Services</h3>
                    <p>
                        Anntix provides a digital marketplace connecting Event Organizers with Attendees. We are an
                        intermediary platform and do not organize, host, or produce the events listed unless explicitly
                        stated.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl my-8 not-prose">
                        <h4 class="text-blue-900 font-bold mb-2">Key Responsibility</h4>
                        <p class="text-blue-800 text-sm">
                            Organizers are solely responsible for their events, including quality, safety, and
                            compliance with applicable laws. Anntix is not liable for event cancellations or changes.
                        </p>
                    </div>

                    <h3>3. Ticket Purchases & Payments</h3>
                    <ul>
                        <li><strong>Pricing:</strong> Prices are set by the Organizer. Anntix may charge a booking fee
                            which is non-refundable.</li>
                        <li><strong>Availability:</strong> Tickets are sold on a first-come, first-served basis.</li>
                        <li><strong>Refunds:</strong> All sales are final. Refunds are only issued if an event is
                            cancelled, subject to the Organizer's policy.</li>
                    </ul>

                    <h3>4. User Conduct</h3>
                    <p>
                        You agree not to use the Services for any unlawful purpose or to solicit others to perform or
                        participate in any unlawful acts. You are prohibited from violating or attempting to violate the
                        security of the Services.
                    </p>

                    <h3>5. Intellectual Property</h3>
                    <p>
                        The Service and its original content, features, and functionality are and will remain the
                        exclusive property of Anntix and its licensors.
                    </p>

                    <hr class="my-12 border-gray-100">

                    <h3>6. Contact Us</h3>
                    <p>
                        If you have any questions about these Terms, please contact us at <a
                            href="mailto:support@anntix.com">support@anntix.com</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>