<x-layouts.admin title="Transaction Details | {{ $transaction->code }}">
    <!-- Header Section (Premium) -->
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.reports.transactions') }}"
                class="w-14 h-14 rounded-3xl bg-white border border-gray-100 flex items-center justify-center text-secondary hover:text-primary hover:shadow-2xl hover:-translate-x-1 transition-all active:scale-95 group">
                <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-4xl font-black text-dark tracking-tighter">Transaction Dossier</h2>
                    <span
                        class="px-3 py-1 bg-primary/5 text-primary text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-primary/10">ID:{{ $transaction->id }}</span>
                    @if($transaction->reseller_id)
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-purple-100">Reseller: {{ $transaction->reseller->name }}</span>
                    @else
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-blue-100">Online Checkout</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">RECORD REFERENCE</span>
                    <span
                        class="font-mono text-sm font-black text-primary bg-primary/5 px-2 py-0.5 rounded-lg border border-primary/5">{{ $transaction->code }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4" x-data="{ showConfirmModal: false, showVoidModal: false }">
            @if($transaction->status === 'paid')
                <a href="{{ route('payment.success', $transaction->code) }}" target="_blank"
                    class="hidden md:flex items-center gap-2 bg-white text-emerald-600 px-5 py-3 rounded-2xl border border-emerald-100 hover:bg-emerald-50 hover:border-emerald-200 transition-all font-bold text-xs shadow-sm group h-14">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>View Success Page</span>
                </a>
            @endif

            @if($transaction->status === 'pending')
                <button @click="showConfirmModal = true"
                    class="hidden md:flex items-center gap-2 bg-emerald-500 text-white px-5 py-3 rounded-2xl border border-emerald-400 hover:bg-emerald-600 transition-all font-bold text-xs shadow-lg shadow-emerald-500/20 group h-14 cursor-pointer">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Confirm Payment</span>
                </button>

                <!-- Modal -->
                <div x-show="showConfirmModal" style="display: none;" class="relative z-[999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <!-- Background backdrop -->
                    <div x-show="showConfirmModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900/75 transition-opacity z-[999]"></div>

                    <div class="fixed inset-0 z-[999] w-screen overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <div x-show="showConfirmModal"
                                x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                @click.away="showConfirmModal = false"
                                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                                <form method="POST" action="{{ route('admin.reports.transactions.confirm-payment', $transaction->id) }}">
                                    @csrf
                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                                <h3 class="text-lg font-black leading-6 text-gray-900" id="modal-title">Confirm Payment</h3>
                                                <div class="mt-2">
                                                    <div class="bg-emerald-50 rounded-xl p-4 mb-4 border border-emerald-100">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <span class="text-xs font-bold text-emerald-800 uppercase tracking-wide">Customer</span>
                                                            <span class="text-sm font-black text-dark">{{ $transaction->name }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center text-emerald-900">
                                                            <span class="text-xs font-bold text-emerald-800 uppercase tracking-wide">Total</span>
                                                            <span class="text-lg font-black">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="notes" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirmation Notes</label>
                                                        <textarea name="notes" id="notes" rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm font-medium" placeholder="e.g. Paid via Bank Transfer, Verified by Admin..."></textarea>
                                                    </div>

                                                    <div class="flex gap-3 p-3 bg-amber-50 rounded-xl border border-amber-100 text-amber-800">
                                                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <div class="text-xs leading-relaxed">
                                                            <span class="font-bold block mb-1">Confirming will immediately:</span>
                                                            <ul class="list-disc pl-3 space-y-0.5 opacity-90">
                                                                <li>Mark status as <strong>PAID</strong></li>
                                                                <li>Send QR ticket to customer</li>
                                                                <li>Record in audit log</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                                        <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-emerald-600 px-3 py-2.5 text-sm font-black text-white shadow-sm hover:bg-emerald-500 sm:w-auto transition-colors">Confirm & Send Ticket</button>
                                        <button type="button" @click="showConfirmModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Void Button (Visible for all non-voided transactions) -->
            <button @click="showVoidModal = true"
                class="hidden md:flex items-center gap-2 bg-white text-rose-500 px-5 py-3 rounded-2xl border border-rose-100 hover:bg-rose-50 hover:border-rose-200 transition-all font-bold text-xs shadow-sm group h-14 cursor-pointer ml-2">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Void</span>
            </button>

            <!-- Void Modal -->
            <div x-show="showVoidModal" style="display: none;" class="relative z-[999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div x-show="showVoidModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/75 transition-opacity z-[999]"></div>

                <div class="fixed inset-0 z-[999] w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="showVoidModal"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            @click.away="showVoidModal = false"
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                            <form method="POST" action="{{ route('admin.reports.transactions.destroy', $transaction->id) }}">
                                @csrf
                                @method('DELETE')
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                            <h3 class="text-lg font-black leading-6 text-gray-900">Void Transaction?</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500 mb-4">
                                                    Are you sure you want to void this transaction? This will soft-delete the record and remove it from revenue reports.
                                                </p>

                                                <div class="mb-4">
                                                    <label for="void_notes" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Reason for Void</label>
                                                    <textarea name="notes" id="void_notes" rows="2" required class="w-full rounded-xl border-gray-200 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 text-sm font-medium" placeholder="e.g. Test transaction, duplicate payment..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-3 py-2.5 text-sm font-black text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors">Confirm Void</button>
                                    <button type="button" @click="showVoidModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($transaction->status === 'paid')
                <div
                    class="flex items-center gap-4 bg-white p-2 pr-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-emerald-500/5">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em]">Settled</div>
                        <div class="text-sm font-black text-dark tracking-tight">Payment Verified</div>
                    </div>
                </div>
            @elseif($transaction->status === 'pending')
                <div
                    class="flex items-center gap-4 bg-white p-2 pr-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-amber-500/5">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-400 flex items-center justify-center text-white animate-pulse shadow-lg shadow-amber-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em]">Awaiting</div>
                        <div class="text-sm font-black text-dark tracking-tight">Processing Entry</div>
                    </div>
                </div>
            @else
                <div
                    class="flex items-center gap-4 bg-white p-2 pr-6 rounded-[2rem] border border-gray-100 shadow-xl shadow-rose-500/5">
                    <div
                        class="w-12 h-12 rounded-2xl bg-rose-500 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-rose-600 uppercase tracking-[0.2em]">Voided</div>
                        <div class="text-sm font-black text-dark tracking-tight">Record Terminated</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($transaction->status === 'paid')
        <!-- Top Level Spotlight: Digital Access Pass -->
        <div class="mb-12">
            <div
                class="bg-white rounded-[3rem] shadow-2xl shadow-primary/5 border border-gray-100 p-2 overflow-hidden relative group">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32 blur-3xl transition-all group-hover:scale-110">
                </div>
                <div class="flex flex-col lg:flex-row items-center gap-12 p-10 lg:p-16 relative z-10">
                    <div class="flex-shrink-0">
                        @php
                            $qrCode = (new Endroid\QrCode\Builder\Builder(
                                writer: new Endroid\QrCode\Writer\SvgWriter(),
                                validateResult: false,
                                data: $transaction->code,
                                encoding: new Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                errorCorrectionLevel: Endroid\QrCode\ErrorCorrectionLevel::High,
                                size: 280,
                                margin: 10,
                                foregroundColor: new Endroid\QrCode\Color\Color(17, 24, 39)
                            ))->build();
                        @endphp
                        <div class="relative">
                            <div class="absolute inset-0 bg-primary/10 blur-[40px] rounded-full scale-75 animate-pulse">
                            </div>
                            <div
                                class="relative p-6 bg-white rounded-[2.5rem] border-2 border-gray-50 shadow-2xl flex items-center justify-center group-hover:scale-[1.02] transition-transform duration-500">
                                <img src="{{ $qrCode->getDataUri() }}" class="w-56 h-56 lg:w-64 lg:h-64">
                                <div
                                    class="absolute -bottom-4 bg-dark text-white text-[9px] font-black px-4 py-2 rounded-full uppercase tracking-widest shadow-xl">
                                    Verified Identity</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col items-center lg:items-start text-center lg:text-left">
                        <div class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-4">Digital Access
                            Credential</div>
                        <h3 class="text-5xl font-black text-dark tracking-tighter leading-tight mb-6">This access pass is
                            <span class="text-emerald-500">active.</span></h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 w-full max-w-2xl">
                            <div class="space-y-1">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Entry Key</div>
                                <div class="text-sm font-mono font-black text-dark uppercase select-all">
                                    {{ $transaction->code }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Verification
                                    Status</div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                    <span class="text-sm font-black text-dark uppercase tracking-tighter">Settled</span>
                                </div>
                            </div>
                            <div class="space-y-1 col-span-2 md:col-span-1">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Authorized By
                                </div>
                                <div class="text-sm font-black text-dark uppercase tracking-tighter">System Intelligence
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Content Architecture -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Intel: Dossier & Matrix -->
        <div class="lg:col-span-8 space-y-10">
            <!-- Customer Dossier Card -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 border border-gray-100 p-10 lg:p-12">
                <div class="flex items-center justify-between mb-12">
                    <h3 class="text-2xl font-black text-dark tracking-tight flex items-center gap-4">
                        <span class="w-2 h-10 bg-primary rounded-full"></span>
                        Customer Profile
                    </h3>
                    <div
                        class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-secondary border border-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-1 group">
                        <div
                            class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] group-hover:text-primary transition-colors">
                            Identified Name</div>
                        <div class="text-2xl font-black text-dark tracking-tight">{{ $transaction->name }}</div>
                    </div>
                    <div class="space-y-1 group">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] group-hover:text-primary transition-colors">Digital Handle</div>
                        <a href="mailto:{{ $transaction->email }}" class="block text-2xl font-bold text-dark tracking-tight hover:text-primary transition-colors cursor-pointer">{{ $transaction->email }}</a>
                        <a href="tel:{{ $transaction->phone }}" class="block text-xs font-black text-primary uppercase tracking-widest mt-1 hover:opacity-70 transition-opacity cursor-pointer">{{ $transaction->phone }}</a>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">National ID (NIK)
                        </div>
                        <div
                            class="text-xl font-mono font-black text-dark bg-gray-50 px-4 py-3 rounded-2xl border border-gray-100 inline-block tracking-tighter">
                            {{ $transaction->nik ?? 'NOT PROVIDED' }}</div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Demographics
                            Architecture</div>
                        <div class="flex items-center gap-3 mt-2">
                            <div
                                class="px-5 py-2.5 bg-dark text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-dark/10">
                                {{ $transaction->gender ?? '-' }}</div>
                            <div
                                class="px-5 py-2.5 bg-gray-50 text-dark rounded-xl text-xs font-black uppercase tracking-widest border border-gray-100">
                                {{ $transaction->city ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Matrix Card -->
            <div
                class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 border border-gray-100 p-10 lg:p-12 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-2 h-full bg-emerald-500/20"></div>
                <div class="flex items-center justify-between mb-12">
                    <h3 class="text-2xl font-black text-dark tracking-tight flex items-center gap-4">
                        <span class="w-2 h-10 bg-emerald-500 rounded-full"></span>
                        Event Matrix
                    </h3>
                </div>

                <div class="flex flex-col md:flex-row gap-12">
                    <div class="w-full md:w-2/5">
                        <div
                            class="aspect-[4/5] rounded-[2.5rem] overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,0,0,0.15)] border-8 border-white bg-gray-50">
                            @if($transaction->event && $transaction->event->thumbnail_path)
                                <img src="{{ Str::startsWith($transaction->event->thumbnail_path, ['http', 'https']) ? $transaction->event->thumbnail_path : (file_exists(public_path($transaction->event->thumbnail_path)) ? asset($transaction->event->thumbnail_path) : asset('storage/' . $transaction->event->thumbnail_path)) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center opacity-20 bg-gray-100">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 space-y-10">
                        <div>
                            <div class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-2">
                                INTELLIGENCE SUBJECT</div>
                            <h4 class="text-4xl font-black text-dark tracking-tighter leading-none">
                                {{ $transaction->event->name ?? 'SYSTEM ARCHIVE' }}</h4>
                        </div>

                        <div class="grid grid-cols-2 gap-10">
                            <div class="group">
                                <div
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-primary">
                                    Tier Logic</div>
                                <div class="text-xl font-black text-dark">{{ $transaction->ticket->name ?? 'N/A' }}
                                </div>
                                <div class="text-xs font-bold text-primary mt-0.5">@ Rp
                                    {{ number_format($transaction->ticket->price ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="group">
                                <div
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-primary">
                                    Volume Matrix</div>
                                <div class="text-3xl font-black text-dark">x{{ $transaction->quantity }}</div>
                                <div class="text-[10px] font-black text-secondary uppercase tracking-[0.2em]">Units
                                    Confirmed</div>
                            </div>
                        </div>

                        <div class="p-8 bg-gray-50 rounded-[2rem] border border-gray-100/50">
                            <div class="text-[10px] font-black text-secondary uppercase tracking-[0.2em] mb-3">Protocol
                                Overview</div>
                            <p class="text-sm font-medium text-secondary/80 leading-relaxed italic">
                                "{{ Str::limit(strip_tags($transaction->event->description) ?? 'No subject protocol details recorded for this archive.', 180) }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audit Log Card -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 border border-gray-100 p-10 lg:p-12">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-dark tracking-tight flex items-center gap-4">
                        <span class="w-2 h-10 bg-gray-800 rounded-full"></span>
                        Audit Log
                    </h3>
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">History</div>
                </div>

                @if($transaction->logs && $transaction->logs->count() > 0)
                    <div class="space-y-6">
                        @foreach($transaction->logs as $log)
                            <div class="border-l-2 border-gray-100 pl-6 relative">
                                <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full {{ $log->action === 'manual_payment_confirm' ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <div class="text-xs font-black text-dark uppercase tracking-wide">
                                            @if($log->action === 'manual_payment_confirm')
                                                Manual Payment Confirmed
                                            @elseif($log->action === 'resend_email')
                                                Email Resent
                                            @else
                                                {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                            @endif
                                        </div>
                                        <div class="text-[10px] font-bold text-gray-400">
                                            by <span class="text-primary">{{ $log->user->name ?? 'System' }}</span>
                                        </div>
                                    </div>
                                    <div class="text-[10px] font-mono text-gray-400">{{ $log->created_at->format('d M H:i') }}</div>
                                </div>

                                @if($log->old_status && $log->new_status && $log->old_status !== $log->new_status)
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $log->old_status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600' }}">{{ $log->old_status }}</span>
                                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $log->new_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">{{ $log->new_status }}</span>
                                    </div>
                                @endif

                                @if($log->notes)
                                    <div class="bg-gray-50 p-2.5 rounded-xl text-xs text-gray-600 italic border border-gray-100">
                                        "{{ $log->notes }}"
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-300 mb-2">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">No audit history found</div>
                    </div>
                @endif
            </div>
            <!-- Scan History Card -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 border border-gray-100 p-10 lg:p-12">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-dark tracking-tight flex items-center gap-4">
                        <span class="w-2 h-10 bg-indigo-500 rounded-full"></span>
                        Scan History
                    </h3>
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        {{ $transaction->scans->count() }} / {{ $transaction->ticket->max_scans }} Scans
                    </div>
                </div>

                @if($transaction->scans && $transaction->scans->count() > 0)
                    <div class="space-y-6">
                        @foreach($transaction->scans as $index => $scan)
                            <div class="border-l-2 border-indigo-100 pl-6 relative">
                                <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <div class="text-xs font-black text-dark uppercase tracking-wide">
                                            Scan #{{ $index + 1 }}
                                        </div>
                                        <div class="text-[10px] font-bold text-gray-400">
                                            by <span class="text-primary">{{ $scan->scanner->name ?? 'System' }}</span>
                                        </div>
                                    </div>
                                    <div class="text-[10px] font-mono text-gray-400">{{ $scan->created_at->format('d M y, H:i:s') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-300 mb-2">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">No scans recorded yet</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Financial & Timeline -->
        <div class="lg:col-span-4 space-y-10">
            <!-- Settlement Insight (Creative Dark Card) -->
            <div
                class="bg-dark rounded-[3rem] shadow-[0_40px_80px_-20px_rgba(17,24,39,0.3)] overflow-hidden text-white relative">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>
                <div class="relative p-10">
                    <div
                        class="text-[10px] font-black text-teal-400 uppercase tracking-[0.3em] mb-8 border-b border-white/5 pb-4 text-center">
                        Settlement Breakout</div>

                    <div class="space-y-6 mb-10">
                        <div class="flex justify-between items-center group">
                            <span
                                class="text-[10px] font-black text-teal-100/30 uppercase tracking-[0.2em] group-hover:text-teal-400 transition-colors">Core
                                Asset</span>
                            <span class="text-base font-bold text-teal-50">Rp
                                {{ number_format($transaction->quantity * ($transaction->ticket->price ?? 0), 0, ',', '.') }}</span>
                        </div>
                        @if(!$transaction->reseller_id)
                        <div class="flex justify-between items-center group">
                            <span
                                class="text-[10px] font-black text-teal-100/30 uppercase tracking-[0.2em] group-hover:text-teal-400 transition-colors">Handling
                                Fee</span>
                            <span class="text-base font-bold text-teal-50">Rp
                                {{ number_format($handlingTotal, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center group/item">
                            <span
                                class="text-[10px] font-black text-teal-100/30 uppercase tracking-[0.2em] group-hover/item:text-teal-400 transition-colors">Gateway
                                IQ</span>
                            <span class="text-base font-bold text-teal-50">Rp
                                {{ number_format($serviceFee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-10 border-t-2 border-dashed border-white/10 mb-8">
                        <div
                            class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.4em] mb-4 text-center opacity-70">
                            Unified Total</div>
                        <div class="text-5xl font-black text-white tracking-tighter text-center">
                            <span
                                class="text-2xl align-top mr-1 text-teal-400 opacity-50">Rp</span>{{ number_format($transaction->total_price, 0, ',', '.') }}
                        </div>
                    </div>

                    @if($transaction->reseller_id)
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-6 bg-white/[0.03] rounded-3xl text-center border border-white/5">
                                <div class="text-[9px] font-black text-teal-500 uppercase tracking-widest mb-1 italic">Reseller Agent</div>
                                <div class="text-xs font-black text-white/90 uppercase tracking-widest truncate" title="{{ $transaction->reseller->name }}">
                                    {{ Str::limit($transaction->reseller->name, 15) }}
                                </div>
                            </div>
                            <div class="p-6 bg-white/[0.03] rounded-3xl text-center border border-white/5">
                                <div class="text-[9px] font-black text-teal-500 uppercase tracking-widest mb-1 italic">Channel</div>
                                <div class="text-xs font-black text-white/90 uppercase tracking-widest">
                                    {{ $transaction->payment_type ?? 'MANUAL' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="p-6 bg-white/[0.03] rounded-3xl text-center border border-white/5">
                            <div class="text-[9px] font-black text-teal-500 uppercase tracking-widest mb-1 italic">Channel
                                Strategy</div>
                            <div class="text-sm font-black text-white/90 uppercase tracking-widest">
                                {{ $transaction->payment_type ?? 'PENDING' }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lifecycle Intelligence -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 border border-gray-100 p-10">
                <h3 class="text-sm font-black text-dark uppercase tracking-[0.25em] mb-10 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-primary mb-0.5"></span>
                    Ledger Lifecycle
                </h3>
                <div class="space-y-12 relative">
                    <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-gray-100"></div>

                    <!-- Stage 1 -->
                    <div class="flex gap-8 relative group">
                        <div
                            class="w-6 h-6 rounded-full bg-white border-4 border-primary group-hover:scale-125 transition-transform shadow-lg z-10">
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Entry
                                Initialized</div>
                            <div class="text-sm font-black text-dark mt-0.5">Record established</div>
                            <div class="text-[10px] font-bold text-primary/60 mt-1 uppercase tracking-tighter">
                                {{ $transaction->created_at->format('d M Y | H:i:s') }}</div>
                        </div>
                    </div>

                    <!-- Stage 2 -->
                    @if($transaction->status === 'paid')
                        <div class="flex gap-8 relative group">
                            <div
                                class="w-6 h-6 rounded-full bg-white border-4 border-emerald-500 group-hover:scale-125 transition-transform shadow-lg z-10">
                            </div>
                            <div>
                                <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Global
                                    Verified</div>
                                <div class="text-sm font-black text-dark mt-0.5">Settlement confirmed</div>
                                <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">
                                    {{ $transaction->updated_at->format('d M Y | H:i:s') }}</div>
                                <div
                                    class="mt-4 px-4 py-2.5 bg-gray-50 rounded-2xl border border-gray-100 text-[10px] font-mono font-black text-dark break-all leading-relaxed shadow-inner">
                                    MID: {{ $transaction->midtrans_transaction_id ?? 'INT-SEQ-9921' }}
                                </div>
                            </div>
                        </div>
                    @elseif($transaction->status === 'pending')
                        <div class="flex gap-8 relative opacity-40 group">
                            <div
                                class="w-6 h-6 rounded-full bg-white border-4 border-amber-400 group-hover:scale-125 transition-transform shadow-lg z-10 animate-pulse">
                            </div>
                            <div>
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">In Suspension
                                </div>
                                <div class="text-sm font-black text-dark mt-0.5">Awaiting gateway sync</div>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-8 relative group">
                            <div
                                class="w-6 h-6 rounded-full bg-white border-4 border-rose-500 group-hover:scale-125 transition-transform shadow-lg z-10">
                            </div>
                            <div>
                                <div class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Entry Terminated
                                </div>
                                <div class="text-sm font-black text-dark mt-0.5">Operational pulse lost</div>
                                <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">
                                    {{ $transaction->updated_at->format('d M Y | H:i:s') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- System Key Intelligence -->
            <div class="bg-gray-50 rounded-[2.5rem] border border-gray-100 p-8 group">
                <div class="flex items-center gap-3 mb-5">
                    <div
                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-secondary border border-gray-100 group-hover:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                    <h5 class="text-[10px] font-black text-secondary uppercase tracking-[0.2em]">Snap System Key</h5>
                </div>
                <div
                    class="bg-white px-6 py-5 rounded-[2rem] border border-gray-100 font-mono text-[10px] font-black text-primary break-all shadow-inner select-all leading-relaxed">
                    {{ $transaction->snap_token ?? 'UNSENT-SEQ-ARCHIVE-0X9' }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
