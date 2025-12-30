<x-layouts.app title="Payment">
    @php
        // Base values
        $subtotal = $transaction->ticket->price * $transaction->quantity;
        $handlingFee = (int) \App\Models\Setting::getValue('handling_fee', 0);
        $baseTotal = $subtotal + $handlingFee;

        // Fee Constants
        $qrisPercent = (float) \App\Models\Setting::getValue('fee_qris_percent', 0);
        $bankFixed = (int) \App\Models\Setting::getValue('fee_bank_fixed', 0);

        // Potential Fees
        $qrisFee = floor($baseTotal * ($qrisPercent / 100)); // 0.7% of base total
    @endphp
    <div class="bg-white min-h-screen pt-28 pb-20 px-4 sm:px-6">
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

                    <div class="space-y-2 text-lg text-black/70 mb-8">
                        <p>To secure your tickets, please complete the payment using your preferred method.</p>
                        <p>Transaction ID: <span class="font-bold text-dark">{{ $transaction->code }}</span></p>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-12 space-y-4">
                        <h3 class="font-bold text-dark text-lg uppercase mb-4">Select Payment Method</h3>

                        <!-- QRIS Option -->
                        <div class="relative">
                            <input type="radio" name="payment_method" id="method_qris" value="qris"
                                data-fee="{{ $qrisFee }}" class="peer hidden">
                            <label for="method_qris"
                                class="block p-6 bg-white border-2 border-gray-100 rounded-2xl cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5 transition-all group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gray-100 p-2 rounded-lg group-hover:bg-white transition-colors">
                                            <svg class="w-8 h-8 text-dark" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-black text-dark text-lg">QRIS</div>
                                            <div class="text-sm text-gray-500">Scan via GoPay, OVO, Dana, etc.</div>
                                        </div>
                                    </div>
                                    <div class="text-xs font-bold px-3 py-1 bg-gray-100 rounded-full text-gray-600">
                                        + {{ $qrisPercent }}% Fee
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Bank Transfer Option -->
                        <div class="relative">
                            <input type="radio" name="payment_method" id="method_bank" value="bank_transfer"
                                data-fee="{{ $bankFixed }}" class="peer hidden">
                            <label for="method_bank"
                                class="block p-6 bg-white border-2 border-gray-100 rounded-2xl cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5 transition-all group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-gray-100 p-2 rounded-lg group-hover:bg-white transition-colors">
                                            <svg class="w-8 h-8 text-dark" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-black text-dark text-lg">Bank Transfer</div>
                                            <div class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</div>
                                        </div>
                                    </div>
                                    <div class="text-xs font-bold px-3 py-1 bg-gray-100 rounded-full text-gray-600">
                                        + Rp {{ number_format($bankFixed, 0, ',', '.') }} Fee
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-16">
                        <button id="pay-button" disabled
                            class="w-full md:w-auto px-12 py-5 bg-dark text-white font-black rounded-2xl shadow-xl disabled:opacity-50 disabled:cursor-not-allowed hover:bg-primary transition-all duration-300 transform hover:-translate-y-1 active:scale-95 text-lg flex items-center justify-center gap-3">
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
                        <p class="text-black/70 mb-4 leading-relaxed">
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
                                class="grid grid-cols-12 text-xs font-bold text-black/70 uppercase tracking-wider pb-2 border-b border-gray-100">
                                <div class="col-span-8">Ticket Type</div>
                                <div class="col-span-2 text-right">Qty</div>
                                <div class="col-span-2 text-right">Subtotal</div>
                            </div>

                            <!-- Item Row -->
                            <div class="grid grid-cols-12 text-sm py-4 border-b border-gray-100 items-center">
                                <div class="col-span-8 pr-4">
                                    <div class="font-bold text-dark">{{ $transaction->ticket->name }}</div>
                                    <div class="text-xs text-black/70 mt-1">{{ $transaction->event->name }}</div>
                                </div>
                                <div class="col-span-2 text-right font-medium text-dark">
                                    {{ $transaction->quantity }}
                                </div>
                                <div class="col-span-2 text-right font-bold text-dark">
                                    {{ number_format($transaction->ticket->price * $transaction->quantity, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Totals -->
                            <div class="pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-black/70">Subtotal</span>
                                    <span class="font-medium text-dark">Rp
                                        {{ number_format($transaction->ticket->price * $transaction->quantity, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-black/70">Handling Fee</span>
                                    <span class="font-medium text-dark">Rp
                                        {{ number_format($handlingFee, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-primary font-bold">
                                    <span>Service Fee</span>
                                    <span id="service-fee-display">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-xl font-black pt-4 border-t border-gray-100">
                                    <span class="text-dark uppercase">Grand Total</span>
                                    <span class="text-primary tracking-tighter" id="grand-total-display">Rp
                                        {{ number_format($baseTotal, 0, ',', '.') }}</span>
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
                                <div class="col-span-4 font-bold text-black/70 uppercase text-[10px] tracking-widest">
                                    NIK</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->nik }}</div>
                            </div>

                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-black/70 uppercase text-[10px] tracking-widest">
                                    Full Name</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->name }}</div>
                            </div>

                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-black/70 uppercase text-[10px] tracking-widest">
                                    Email</div>
                                <div class="col-span-8 font-medium text-dark">{{ $transaction->email }}</div>
                            </div>

                            <div class="grid grid-cols-12 text-sm py-3 border-b border-gray-50 items-center">
                                <div class="col-span-4 font-bold text-black/70 uppercase text-[10px] tracking-widest">
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
            const payButton = document.getElementById('pay-button');
            const radioButtons = document.querySelectorAll('input[name="payment_method"]');
            const serviceFeeDisplay = document.getElementById('service-fee-display');
            const grandTotalDisplay = document.getElementById('grand-total-display');

            // Base Total (Subtotal + Handling Fee) from PHP
            const baseTotal = {{ $baseTotal }};
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Enable button on selection and update totals
            radioButtons.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    payButton.disabled = false;

                    // Calculate Fee
                    const fee = parseFloat(e.target.getAttribute('data-fee'));
                    const total = baseTotal + fee;

                    // Update UI
                    serviceFeeDisplay.textContent = formatter.format(fee).replace('Rp', 'Rp ');
                    grandTotalDisplay.textContent = formatter.format(total).replace('Rp', 'Rp ');
                });
            });

            payButton.onclick = function () {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

                // Show loading state
                payButton.innerHTML = 'Processing...';
                payButton.disabled = true;

                // Fetch Token
                fetch("{{ route('payment.token', $transaction->code) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ payment_method: selectedMethod })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            payButton.disabled = false;
                            payButton.innerHTML = 'Secure Payment Now';
                            return;
                        }

                        // Open Snap
                        snap.pay(data.snap_token, {
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
                                    .then(() => {
                                        window.location.href = "{{ route('payment.success', $transaction->code) }}";
                                    });
                            },
                            onPending: function (result) { alert("Waiting for your payment!"); },
                            onError: function (result) { alert("Payment failed!"); },
                            onClose: function () {
                                payButton.disabled = false;
                                payButton.innerHTML = 'Secure Payment Now';
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                        payButton.disabled = false;
                        payButton.innerHTML = 'Secure Payment Now';
                    });
            };
        </script>
    @endpush
</x-layouts.app>