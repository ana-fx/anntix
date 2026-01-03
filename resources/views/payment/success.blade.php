<x-layouts.app title="Order Confirmed">
    @php
        $subtotal = $transaction->ticket->price * $transaction->quantity;

        // Handling/Reseller Fee Logic
        $isReseller = $transaction->reseller_id ? true : false;
        $handlingFee = 0;

        if ($isReseller) {
            // Reseller Commission / Fee
            if ($transaction->event->reseller_fee_type === 'percent') {
                $handlingFee = ($transaction->ticket->price * ($transaction->event->reseller_fee_value / 100));
            } else {
                $handlingFee = $transaction->event->reseller_fee_value;
            }
        } else {
            $handlingFee = (int) \App\Models\Setting::getValue('handling_fee', 0);
        }

        // Service fee remainder calculation
        $serviceFee = $transaction->total_price - $subtotal - ($handlingFee * $transaction->quantity);
    @endphp
    <div class="bg-white min-h-screen pt-32 pb-20 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

                <!-- LEFT COLUMN: Success Message & Actions -->
                <div class="lg:col-span-7">


                    <h1 class="text-3xl md:text-5xl font-heading font-bold text-dark mb-6 uppercase tracking-tight">
                        Thank you for your purchase!
                    </h1>

                    <div class="space-y-2 text-lg text-black/70 mb-8">
                        <p>You will receive an order confirmation email with details of your order.</p>
                        <div class="flex flex-col gap-1">
                            <p>Your order # is: <span class="font-bold text-dark">{{ $transaction->code }}</span></p>
                            @if($transaction->reseller_id)
                                <p>Processed by: <span class="font-bold text-dark">{{ $transaction->reseller->name }}</span></p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mb-16">
                        <a href="{{ route('home') }}"
                            class="inline-block text-primary font-bold hover:underline hover:text-primary/80 transition-colors">
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Banner / Promo Area (Mimicking the image) -->
                    <div class="relative rounded-xl overflow-hidden group mb-12">
                        <img src="{{
                            Str::startsWith($transaction->event->thumbnail_path, 'http')
                            ? $transaction->event->thumbnail_path
                            : (file_exists(public_path($transaction->event->thumbnail_path))
                                ? asset($transaction->event->thumbnail_path)
                                : asset('storage/' . $transaction->event->thumbnail_path))
                        }}"
                            class="w-full h-64 object-cover brightness-75 group-hover:brightness-50 transition-all duration-500">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3 class="text-4xl font-heading font-bold text-white tracking-widest uppercase">
                                {{ $transaction->event->name }}
                            </h3>
                        </div>
                    </div>

                    <!-- Create Account / Additional Info (Optional placeholder) -->
                    <div>
                        <h3 class="font-bold text-dark text-xl mb-4 uppercase">Important Information</h3>
                        <p class="text-black/70 mb-4">
                            Please arrive 30 minutes before the event starts. Show the QR code on the right (or in your
                            email) at the entrance.
                        </p>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Order Details -->
                <div class="lg:col-span-5 space-y-12">

                    <!-- QR Code Section (Moved here for easy access) -->
                    <div class="bg-white p-6 rounded-xl border-2 border-dashed border-gray-200 text-center">
                        <p class="font-bold text-dark mb-4 text-sm uppercase tracking-wider">Your Ticket QR</p>
                        <div class="flex justify-center mb-4">
                            @php
                                $qrCode = (new Endroid\QrCode\Builder\Builder(
                                    writer: new Endroid\QrCode\Writer\SvgWriter(),
                                    validateResult: false,
                                    data: $transaction->code,
                                    encoding: new Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                    errorCorrectionLevel: Endroid\QrCode\ErrorCorrectionLevel::High,
                                    size: 150,
                                    margin: 0,
                                    foregroundColor: new Endroid\QrCode\Color\Color(0, 0, 0)
                                ))->build();
                            @endphp
                            <img src="{{ $qrCode->getDataUri() }}" alt="Transaction QR" class="w-32 h-32">
                        </div>

                    </div>

                    <!-- Items Ordered -->
                    <div>
                        <h2 class="font-bold text-dark text-xl mb-6 uppercase border-b border-gray-100 pb-2">Items
                            Ordered</h2>

                        <div class="space-y-4">
                            <!-- Table Header -->
                            <div
                                class="grid grid-cols-12 text-xs font-bold text-black/70 uppercase tracking-wider pb-2 border-b border-gray-100">
                                <div class="col-span-8">Product Name</div>
                                <div class="col-span-2 text-right">Qty</div>
                                <div class="col-span-2 text-right">Subtotal</div>
                            </div>

                            <!-- Item Row -->
                            <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                <div class="col-span-8 pr-4">
                                    <div class="font-bold text-dark">{{ $transaction->ticket->name }}</div>
                                    <div class="text-xs text-black/70 mt-1">{{ $transaction->event->name }}</div>
                                </div>
                                <div class="col-span-2 text-right font-medium text-dark">
                                    {{ $transaction->quantity }}
                                </div>
                                <div class="col-span-2 text-right font-bold text-dark">
                                    {{ number_format($subtotal, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Totals -->
                            <div class="pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-black/70">Subtotal</span>
                                    <span class="font-medium text-dark">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-black/70">{{ $transaction->reseller_id ? 'Reseller Fee' : 'Handling Fee' }}</span>
                                    <span class="font-medium text-dark">Rp
                                        {{ number_format($handlingFee * $transaction->quantity, 0, ',', '.') }}</span>
                                </div>
                                @if($serviceFee > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-black/70">Service Fee</span>
                                        <span class="font-medium text-dark">Rp
                                            {{ number_format($serviceFee, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-lg font-bold pt-4 border-t border-gray-100">
                                    <span class="text-dark">Grand Total</span>
                                    <span class="text-primary">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="grid grid-cols-1 gap-8">

                        <!-- Billing / Ticket Holder -->
                        <div>
                            <h3 class="font-bold text-dark text-xl mb-6 uppercase border-b border-gray-100 pb-2">
                                Buyer Details</h3>

                            <div class="space-y-4">
                                <!-- Table Header -->
                                <div
                                    class="grid grid-cols-12 text-xs font-bold text-black/70 uppercase tracking-wider pb-2 border-b border-gray-100">
                                    <div class="col-span-4">Information</div>
                                    <div class="col-span-8">Details</div>
                                </div>

                                <!-- Rows -->
                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">Passport / NIK</div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->nik }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">Full Name</div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->name }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">Email Address</div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->email }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">Phone Number</div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->phone }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">City / Address</div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->city }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">Payment Method</div>
                                    <div class="col-span-8 font-bold text-primary">
                                        {{ strtoupper($transaction->payment_type ?? 'Online Payment') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
