<x-layouts.app>
    <div class="bg-white min-h-screen pt-32 pb-20 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

                <!-- LEFT COLUMN: Payment Action & Event Info -->
                <div class="lg:col-span-7">

                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/5 text-primary text-xs font-bold uppercase tracking-widest mb-6">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Awaiting Payment
                    </div>

                    <h1 class="text-3xl md:text-5xl font-heading font-bold text-dark mb-6 uppercase tracking-tight">
                        Complete Your Payment
                    </h1>

                    <div class="space-y-2 text-lg text-secondary mb-8">
                        <p>To secure your tickets, please complete the payment using your preferred method.</p>
                        <p>Transaction ID: <span class="font-bold text-dark">{{ $transaction->code }}</span></p>
                    </div>

                    <!-- Payment Button -->
                    <div class="mb-12">
                        <button id="pay-button"
                            class="w-full md:w-auto px-12 py-5 bg-dark text-white font-black rounded-2xl shadow-xl hover:bg-primary transition-all duration-300 transform hover:-translate-y-1 active:scale-95 text-lg flex items-center justify-center gap-3">
                            Secure Payment Now
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Event Banner -->
                    <div class="relative rounded-xl overflow-hidden group mb-12">
                        <img src="{{ $transaction->event->thumbnail_path ? Storage::url($transaction->event->thumbnail_path) : 'https://via.placeholder.com/800x400' }}"
                            class="w-full h-80 object-cover brightness-75 group-hover:brightness-50 transition-all duration-500">
                        <div class="absolute inset-0 flex items-center justify-center p-8 text-center">
                            <h3
                                class="text-4xl md:text-5xl font-heading font-bold text-white tracking-widest uppercase shadow-black drop-shadow-2xl">
                                {{ $transaction->event->name }}
                            </h3>
                        </div>
                    </div>

                    <!-- Information -->
                    <div>
                        <h3 class="font-bold text-dark text-xl mb-4 uppercase">Important Information</h3>
                        <p class="text-secondary mb-4 leading-relaxed">
                            Once payment is confirmed, your e-ticket and QR code will be sent to
                            <strong>{{ $transaction->email }}</strong>.
                            Please ensure you show the QR code at the gate for scanning.
                        </p>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Order Details -->
                <div class="lg:col-span-5 space-y-12">

                    <!-- Price Summary Highlight -->
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 text-center">
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Total Payable Amount
                        </p>
                        <h2 class="text-5xl font-black text-primary tracking-tighter">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </h2>
                    </div>

                    <!-- Items Summary -->
                    <div>
                        <h2 class="font-bold text-dark text-xl mb-6 uppercase border-b border-gray-100 pb-2">Your
                            Selection</h2>

                        <div class="space-y-4">
                            <!-- Table Header -->
                            <div
                                class="grid grid-cols-12 text-xs font-bold text-secondary uppercase tracking-wider pb-2 border-b border-gray-100">
                                <div class="col-span-8">Ticket Type</div>
                                <div class="col-span-2 text-right">Qty</div>
                                <div class="col-span-2 text-right">Subtotal</div>
                            </div>

                            <!-- Item Row -->
                            <div class="grid grid-cols-12 text-sm py-4 border-b border-gray-100 items-center">
                                <div class="col-span-8 pr-4">
                                    <div class="font-bold text-dark">{{ $transaction->ticket->name }}</div>
                                    <div class="text-xs text-secondary mt-1">{{ $transaction->event->name }}</div>
                                </div>
                                <div class="col-span-2 text-right font-medium text-dark">
                                    {{ $transaction->quantity }}
                                </div>
                                <div class="col-span-2 text-right font-bold text-dark">
                                    {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Totals -->
                            <div class="pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-secondary">Subtotal</span>
                                    <span class="font-medium text-dark">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-secondary">Handling Fee</span>
                                    <span class="font-medium text-dark">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-xl font-black pt-4 border-t border-gray-100">
                                    <span class="text-dark uppercase">Grand Total</span>
                                    <span class="text-primary tracking-tighter">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Identity -->
                    <div>
                        <h3 class="font-bold text-dark text-xl mb-6 uppercase border-b border-gray-100 pb-2">Holder
                            Details</h3>

                        <div class="space-y-4">
                            <!-- Rows -->
                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-secondary uppercase text-[10px] tracking-widest">
                                    NIK</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->nik }}</div>
                            </div>

                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-secondary uppercase text-[10px] tracking-widest">
                                    Full Name</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->name }}</div>
                            </div>

                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-secondary uppercase text-[10px] tracking-widest">
                                    Email</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->email }}</div>
                            </div>

                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-secondary uppercase text-[10px] tracking-widest">
                                    Phone</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->phone }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script
            src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function () {
                snap.pay('{{ $transaction->snap_token }}', {
                    onSuccess: function (result) {
                        fetch("{{ route('payment.update', $transaction->code) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(result)
                        })
                            .then(response => response.json())
                            .then(data => {
                                window.location.href = "{{ route('payment.success', $transaction->code) }}";
                            })
                            .catch(error => {
                                window.location.href = "{{ route('payment.success', $transaction->code) }}";
                            });
                    },
                    onPending: function (result) { alert("Waiting for your payment!"); },
                    onError: function (result) { alert("Payment failed!"); },
                    onClose: function () { console.log('closed'); }
                });
            };
        </script>
    @endpush
</x-layouts.app>