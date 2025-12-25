<x-layouts.app>
    <div class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-primary/5 p-8 text-center border-b border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>

                <div class="mb-6 flex justify-center">

                </div>

                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-heading font-extrabold text-dark mb-2">Payment Successful!</h1>
                <p class="text-secondary">Your transaction has been confirmed.</p>
            </div>

            <!-- Receipt Content -->
            <div class="p-8">
                <!-- Transaction Info -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-dashed border-gray-200">
                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        <!-- QR Code -->
                        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 flex-shrink-0">
                            @php
                                $qrCode = (new Endroid\QrCode\Builder\Builder(
                                    writer: new Endroid\QrCode\Writer\SvgWriter(),
                                    writerOptions: [],
                                    validateResult: false,
                                    data: $transaction->code,
                                    encoding: new Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                    errorCorrectionLevel: Endroid\QrCode\ErrorCorrectionLevel::High,
                                    size: 100,
                                    margin: 0,
                                    foregroundColor: new Endroid\QrCode\Color\Color(29, 78, 216)
                                ))
                                    ->build();
                            @endphp
                            <img src="{{ $qrCode->getDataUri() }}" alt="Transaction QR" class="w-24 h-24">
                        </div>

                        <!-- Details -->
                        <div class="flex-1 w-full text-center md:text-left space-y-4">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <div>
                                    <p class="text-xs text-secondary uppercase tracking-wider mb-1">Transaction ID</p>
                                    <p class="font-mono font-bold text-dark text-lg md:text-xl">{{ $transaction->code }}
                                    </p>
                                </div>
                                <div class="mt-4 md:mt-0 text-center md:text-right">
                                    <p class="text-xs text-secondary uppercase tracking-wider mb-1">Total Paid</p>
                                    <p class="font-bold text-primary text-2xl">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold uppercase tracking-widest rounded-full">
                                Payment Confirmed
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Event Details -->
                    <div>
                        <h3 class="font-bold text-dark mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Event Details
                        </h3>
                        <div class="flex gap-4">
                            <img src="{{ $transaction->event->thumbnail_path ?? 'https://via.placeholder.com/100' }}"
                                class="w-16 h-16 rounded-xl object-cover bg-gray-100 flex-shrink-0">
                            <div>
                                <h4 class="font-bold text-dark text-sm">{{ $transaction->event->name }}</h4>
                                <p class="text-xs text-secondary mt-1">{{ $transaction->event->category }}</p>
                                <p class="text-xs text-secondary mt-1">
                                    {{ $transaction->event->start_date->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div>
                        <h3 class="font-bold text-dark mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Customer Info
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-secondary">Name</span>
                                <span class="font-medium text-dark">{{ $transaction->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary">Email</span>
                                <span
                                    class="font-medium text-dark truncate max-w-[150px]">{{ $transaction->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary">Ticket</span>
                                <span class="font-medium text-dark">{{ $transaction->ticket->name }}
                                    (x{{ $transaction->quantity }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3">
                    <button onclick="window.print()"
                        class="w-full py-4 bg-white border border-gray-200 text-dark font-bold rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Download / Print Receipt
                    </button>
                    <a href="{{ route('home') }}"
                        class="block w-full py-4 bg-dark text-white text-center font-bold rounded-xl hover:bg-black transition-colors">
                        Back to Home
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-4 text-center text-xs text-gray-400">
                <p>A confirmation email has been sent to {{ $transaction->email }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>