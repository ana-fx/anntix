<x-layouts.organizer>
    <x-slot name="title">Withdrawal Requests - {{ $event->name }}</x-slot>
    <div x-data="{ showRequestForm: false }">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-8 gap-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('organizer.events.tickets-report.index', $event) }}"
                    class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-primary transition-colors gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Ticket Report
                </a>
            </div>

            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between px-5 py-2 min-w-[200px]">
                    <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Available Saldo</div>
                    <div class="font-black text-primary text-xl leading-tight">
                        Rp {{ number_format($availableSaldo, 0, ',', '.') }}
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full md:w-auto">
                    <button @click="showRequestForm = !showRequestForm" x-show="!showRequestForm && {{ $availableSaldo > 0 ? 'true' : 'false' }}"
                        class="group flex items-center justify-center w-full px-5 py-3 bg-primary text-white hover:bg-primary-600 rounded-2xl font-bold text-xs transition-all shadow-sm gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Request
                    </button>
                    @if($availableSaldo <= 0)
                        <button disabled
                            class="group flex items-center justify-center w-full px-5 py-3 bg-gray-100 text-gray-400 rounded-2xl font-bold text-xs shadow-sm gap-2 whitespace-nowrap opacity-50 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Request
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-3xl bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-3xl bg-red-50 text-red-700 border border-red-100 font-bold text-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Request Form Modal / Section -->
        <div x-show="showRequestForm" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            style="display: none;" class="mb-8">
            <div class="bg-white rounded-3xl shadow-sm border border-primary/20 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-black text-dark tracking-tight">Request Withdrawal</h3>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Specify amount and destination bank details</p>
                    </div>
                    <button @click="showRequestForm = false" class="text-gray-400 hover:text-dark transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('organizer.events.withdrawals.store', $event) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="amount" class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider">Amount (Rp)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold">Rp</span>
                            </div>
                            <input type="number" name="amount" id="amount" value="{{ old('amount', $availableSaldo) }}" min="1" max="{{ $availableSaldo }}" step="0.01" required
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 text-sm font-black text-dark bg-gray-50 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1.5 font-bold">Maximum available: Rp {{ number_format($availableSaldo, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <label for="note" class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider">Note / Bank Details</label>
                        <textarea name="note" id="note" rows="3" placeholder="e.g. Please transfer to BCA 1234567890 (A/N John Doe)"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-medium text-dark bg-gray-50 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="px-8 py-3 bg-primary text-white hover:bg-primary-600 rounded-xl font-bold text-sm shadow-sm hover:shadow-md transition-all">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-black text-dark tracking-tight">Withdrawal Ledger</h2>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">History of requests and payouts</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Reference</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Notes</th>
                                <th class="px-6 py-4 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($withdrawals as $withdrawal)
                                <tr class="hover:bg-primary/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-dark text-sm">
                                            {{ $withdrawal->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">
                                            {{ $withdrawal->created_at->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-black text-dark text-sm group-hover:text-primary transition-colors">
                                        {{ $withdrawal->reference ?: 'Manual Payout' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($withdrawal->status === 'approved')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-emerald-200">Approved</span>
                                        @elseif($withdrawal->status === 'rejected')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-red-200">Rejected</span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-amber-200">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-gray-500 max-w-xs truncate" title="{{ $withdrawal->note }}">
                                        {{ $withdrawal->note ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-dark text-sm">
                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold text-sm bg-gray-50/30">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        No withdrawals recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.organizer>
