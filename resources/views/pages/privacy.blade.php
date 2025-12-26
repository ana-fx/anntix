<x-layouts.app>
    <div class="bg-gray-50 min-h-screen">
        <!-- Creative Header -->
        <div class="bg-dark relative overflow-hidden h-[400px] flex items-center justify-center">
            <div class="absolute inset-0">
                <div
                    class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-l from-accent/20 to-primary/10 rounded-full blur-3xl">
                </div>
                <!-- Grid Pattern -->
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;">
                </div>
            </div>

            <div class="relative z-10 text-center max-w-2xl px-6">
                <div
                    class="inline-block px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-widest text-accent mb-6">
                    Data Protection
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-white tracking-tight mb-4">
                    Privacy Policy
                </h1>
                <p class="text-gray-400 text-lg">
                    Transparent details about how we handle your personal information.
                </p>
            </div>
        </div>

        <!-- Content Container -->
        <div class="max-w-4xl mx-auto px-6 -mt-20 relative z-20 pb-20">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <!-- Last Updated Bar -->
                <div
                    class="bg-accent/5 border-b border-gray-100 px-8 py-4 flex items-center gap-2 text-sm text-gray-500 font-medium">
                    <svg class="w-4 h-4 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Effective Date: December 25, 2025
                </div>

                <div
                    class="p-8 md:p-12 prose prose-lg prose-headings:font-bold prose-headings:text-dark prose-p:text-gray-600 prose-a:text-primary max-w-none">

                    <h3>1. Information We Collect</h3>
                    <p>
                        When you use Anntix, we collect information that you provide to us directly, information we
                        collect automatically, and information from third-party sources.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 not-prose my-6">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="font-bold text-dark mb-2 text-sm uppercase">Direct Information</h4>
                            <p class="text-sm text-gray-500">Name, email, phone number, billing address, and identity
                                numbers (NIK) for event verification.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="font-bold text-dark mb-2 text-sm uppercase">Usage Data</h4>
                            <p class="text-sm text-gray-500">Device info, IP address, browsing behavior, and purchase
                                history.</p>
                        </div>
                    </div>

                    <h3>2. How We Use Your Information</h3>
                    <p>We use your data to deliver and improve our services, including:</p>
                    <ul>
                        <li>Processing ticket purchases and issuing unique QR codes.</li>
                        <li>Sending event updates, cancellations, or venue changes.</li>
                        <li>Preventing fraud and ensuring platform security.</li>
                        <li>Responding to customer support requests.</li>
                    </ul>

                    <h3>3. Data Sharing & Disclosure</h3>
                    <p>
                        We do not sell your personal data. However, we share necessary data with:
                    </p>
                    <ul>
                        <li><strong>Event Organizers:</strong> To facilitate check-in and event management.</li>
                        <li><strong>Service Providers:</strong> For payment processing (e.g., Midtrans), email delivery,
                            and hosting.</li>
                        <li><strong>Legal Authorities:</strong> If required by law or to protect our rights.</li>
                    </ul>

                    <h3>4. Your Rights</h3>
                    <p>
                        Depending on your location, you may have rights regarding your personal data, including
                        accessing, correcting, or deleting your data.
                    </p>

                    <div
                       class="bg-accent/5 border border-accent/20 p-6 rounded-2xl flex items-start gap-4 not-prose my-8">
                        <div class="p-2 bg-accent/10 rounded-lg text-accent">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark">Data Security</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                We use industry-standard encryption to protect your data during transmission and storage.
                            </p>
                        </div>
                    </div>

                    <h3>5. Contact Us</h3>
                    <p>
                        For any privacy-related inquiries, please reach out to our Data Protection Officer at <a
                            href="mailto:privacy@anntix.com">privacy@anntix.com</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>