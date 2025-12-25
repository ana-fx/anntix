<x-layouts.app>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="bg-primary/5 p-8 text-center border-b border-gray-100">
                    <p class="text-secondary text-sm font-bold uppercase tracking-widest mb-2">Total Amount</p>
                    <h1 class="text-4xl font-extrabold text-primary">
                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                    </h1>
                    <p class="text-xs text-gray-400 mt-2">Transaction ID: <span
                            class="font-mono text-dark">{{ $transaction->code }}</span></p>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Event Info -->
                    <div class="flex gap-4 items-start">
                        <img src="{{ $transaction->event->thumbnail_path ?? 'https://via.placeholder.com/100' }}"
                            class="w-20 h-20 rounded-xl object-cover bg-gray-100">
                        <div>
                            <h3 class="font-bold text-dark text-lg">{{ $transaction->event->name }}</h3>
                            <p class="text-sm text-secondary">
                                {{ $transaction->event->start_date->format('d M Y, H:i') }}
                            </p>
                            <p class="text-sm text-secondary">{{ $transaction->event->location }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-6"></div>

                    <!-- Customer Info -->
                    <div class="space-y-3">
                        <h4 class="font-bold text-dark text-sm uppercase tracking-wide">Customer Details</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-secondary">Name</p>
                                <p class="font-medium text-dark">{{ $transaction->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-secondary">Email</p>
                                <p class="font-medium text-dark">{{ $transaction->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-secondary">Phone</p>
                                <p class="font-medium text-dark">{{ $transaction->phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-secondary">Ticket Type</p>
                                <p class="font-medium text-dark">{{ $transaction->ticket->name }}
                                    (x{{ $transaction->quantity }})</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button id="pay-button"
                            class="w-full py-4 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-primary/90 transition-all hover:scale-[1.02] active:scale-95 text-lg flex items-center justify-center gap-2">
                            <span>Pay Now</span>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
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
                        // Send result to backend
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
                                console.error('Error:', error);
                                window.location.href = "{{ route('payment.success', $transaction->code) }}"; // Redirect anyway
                            });
                    },
                    onPending: function (result) {
                        alert("Waiting for your payment!"); console.log(result);
                    },
                    onError: function (result) {
                        alert("Payment failed!"); console.log(result);
                    },
                    onClose: function () {
                        alert('You closed the popup without finishing the payment');
                    }
                });
            };
        </script>
    @endpush
</x-layouts.app>