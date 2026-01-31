<x-layouts.app :title="__('common.order_confirmed')">
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
            // Standard User Fee (Centralized Logic)
            $handlingFee = $transaction->event->getHandlingFee($transaction->ticket->price);
        }

        // Service fee remainder calculation
        $serviceFee = $transaction->total_price - $subtotal - ($handlingFee * $transaction->quantity);

        // QR Code Visibility Logic
        // Show if NOT reseller, OR if setting is enabled for resellers
        $showQrForReseller = \App\Models\Setting::getValue('show_qr_for_reseller', 0);
        $showQrCode = !$isReseller || $showQrForReseller;
    @endphp
    <div class="bg-white min-h-screen pt-32 pb-20 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

                <!-- LEFT COLUMN: Success Message & Actions -->
                <div class="lg:col-span-7">


                    <h1 class="text-3xl md:text-5xl font-heading font-bold text-dark mb-6 uppercase tracking-tight">
                        {{ __('common.thank_you_purchase') }}
                    </h1>

                    <div class="space-y-2 text-lg text-black/70 mb-8">
                        <p>{{ __('common.order_confirmation_email_desc') }}</p>
                        <div class="flex flex-col gap-1">
                            <p>{{ __('common.your_order_no') }}: <span
                                    class="font-bold text-dark">{{ $transaction->code }}</span></p>
                            @if($transaction->reseller_id)
                                <p>{{ __('common.processed_by') }}: <span
                                        class="font-bold text-dark">{{ $transaction->reseller->name }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mb-16">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-dark hover:shadow-primary/50 hover:-translate-y-0.5 transition-all duration-300">
                            {{ __('common.continue_shopping') }}
                        </a>
                    </div>

                    <!-- Banner / Promo Area -->
                    <div class="relative rounded-xl overflow-hidden group mb-12 bg-gray-200">
                        @php
                            $thumbnail = $transaction->event->thumbnail_path;
                            $imageUrl = null;

                            if (Str::startsWith($thumbnail, ['http', 'https'])) {
                                $imageUrl = $thumbnail;
                            } elseif (file_exists(public_path($thumbnail))) {
                                $imageUrl = asset($thumbnail);
                            } elseif (file_exists(storage_path('app/public/' . $thumbnail))) {
                                $imageUrl = asset('storage/' . $thumbnail);
                            }
                        @endphp

                        @if($imageUrl)
                            <img src="{{ $imageUrl }}"
                                onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');"
                                class="w-full h-64 object-cover brightness-75 group-hover:brightness-50 transition-all duration-500">
                        @endif

                        <!-- Fallback SVG -->
                        <div class="{{ $imageUrl ? 'hidden' : 'flex' }} w-full h-64 items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>

                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3
                                class="text-4xl font-heading font-bold text-white tracking-widest uppercase shadow-black drop-shadow-md">
                                {{ $transaction->event->name }}
                            </h3>
                        </div>
                    </div>

                    <!-- Create Account / Additional Info (Optional placeholder) -->
                    <div>
                        <h3 class="font-bold text-dark text-xl mb-4 uppercase">{{ __('common.important_information') }}
                        </h3>
                        <p class="text-black/70 mb-4">
                            @if(!$isReseller)
                                {{ __('common.arrival_instruction') }}
                            @else
                                {{ __('common.check_email_ticket_desc') }}
                            @endif
                        </p>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Order Details -->
                <div class="lg:col-span-5 space-y-12">

                    <!-- QR Code Section (Moved here for easy access) -->
                    @if($showQrCode)
                        <div class="bg-white p-6 rounded-xl border-2 border-dashed border-gray-200 text-center">
                            <p class="font-bold text-dark mb-4 text-sm uppercase tracking-wider">
                                {{ __('common.your_ticket_qr') }}
                            </p>
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
                    @endif

                    <!-- Items Ordered -->
                    <div>
                        <h2 class="font-bold text-dark text-xl mb-6 uppercase border-b border-gray-100 pb-2">
                            {{ __('common.items_ordered') }}
                        </h2>

                        <div class="space-y-4">
                            <!-- Table Header -->
                            <div
                                class="grid grid-cols-12 text-xs font-bold text-black/70 uppercase tracking-wider pb-2 border-b border-gray-100">
                                <div class="col-span-8">{{ __('common.product_name') }}</div>
                                <div class="col-span-2 text-right">{{ __('common.ticket_quantity') }}</div>
                                <div class="col-span-2 text-right">{{ __('common.subtotal') }}</div>
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
                                    <span class="text-black/70">{{ __('common.subtotal') }}</span>
                                    <span class="font-medium text-dark">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                @if($handlingFee * $transaction->quantity > 0)
                                    <div class="flex justify-between text-sm">
                                        <span
                                            class="text-black/70">{{ $transaction->reseller_id ? __('common.reseller_fee') : __('common.handling_fee') }}</span>
                                        <span class="font-medium text-dark">Rp
                                            {{ number_format($handlingFee * $transaction->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                @if($serviceFee > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-black/70">{{ __('common.service_fee') }}</span>
                                        <span class="font-medium text-dark">Rp
                                            {{ number_format($serviceFee, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-lg font-bold pt-4 border-t border-gray-100">
                                    <span class="text-dark">{{ __('common.grand_total') }}</span>
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
                                    <div class="col-span-4">{{ __('common.information') }}</div>
                                    <div class="col-span-8">{{ __('common.details') }}</div>
                                </div>

                                <!-- Rows -->
                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">{{ __('common.passport_nik') }}
                                    </div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->nik }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">{{ __('common.full_name') }}</div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->name }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">{{ __('common.email_address') }}
                                    </div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->email }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">{{ __('common.phone_number') }}
                                    </div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->phone }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">{{ __('common.city_address') }}
                                    </div>
                                    <div class="col-span-8 font-medium text-dark">{{ $transaction->city }}</div>
                                </div>

                                <div class="grid grid-cols-12 text-sm py-2 border-b border-gray-100 items-center">
                                    <div class="col-span-4 font-bold text-black/70">{{ __('common.payment_method') }}
                                    </div>
                                    <div class="col-span-8 font-bold text-primary">
                                        {{ strtoupper($transaction->payment_type ?? __('common.online_payment')) }}
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