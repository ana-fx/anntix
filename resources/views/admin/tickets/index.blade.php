<x-layouts.admin>
    <div>
        <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-8 gap-6">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-primary transition-colors gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Events
            </a>

            <!-- Aggregate Saldo Widget -->
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4">
                <div class="bg-white px-6 py-4 rounded-3xl shadow-xl shadow-primary/5 border border-gray-50 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 items-center justify-center text-primary hidden md:flex">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap items-center justify-center gap-4 md:gap-8 md:pr-4 w-full md:w-auto">
                        <div class="text-center md:text-left">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Total Saldo</h3>
                            <p class="text-xl font-black text-dark tracking-tight">
                                Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="hidden md:block w-px h-8 bg-gray-100"></div>
                        <div class="text-center md:text-left">
                            <h3 class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-0.5">Withdrawn</h3>
                            <p class="text-xl font-black text-red-500 tracking-tight">
                                Rp {{ number_format($totalWithdrawn, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="hidden md:block w-px h-8 bg-gray-100"></div>
                        <div class="text-center md:text-left">
                            <h3 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-0.5">Available</h3>
                            <p class="text-2xl font-black text-emerald-600 tracking-tight">
                                Rp {{ number_format($availableSaldo, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="{{ route('admin.events.withdrawals.create', $event) }}" class="inline-flex items-center justify-center w-full md:w-auto gap-3 h-full px-8 py-4 bg-dark text-white rounded-3xl font-black text-sm hover:bg-primary transition-all shadow-xl shadow-dark/10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Withdraw Funds
                    </a>
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
            <div class="mb-6 p-4 rounded-3xl bg-red-50 text-red-700 border border-red-100 font-bold text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <!-- Online Sales Report Section -->
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-black text-dark tracking-tight">Online Revenue Digest</h2>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Platform direct sales analytics</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="px-5 py-2.5 bg-primary/5 rounded-2xl border border-primary/10 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                        <span class="text-[10px] font-black text-primary uppercase tracking-widest">Online Channel</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary/5 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] uppercase tracking-[0.2em] text-gray-400 font-black">
                                <th class="px-6 py-6">No</th>
                                <th class="px-6 py-6 font-black text-dark">Ticket Variation</th>
                                <th class="px-6 py-6 text-center">Volume</th>
                                <th class="px-6 py-6 text-right">Ticket Revenue</th>
                                <th class="px-6 py-6 text-right">Org Tax</th>
                                <th class="px-6 py-6 text-right">Saldo</th>
                                <th class="px-6 py-6 text-right">Service Fee</th>
                                <th class="px-6 py-6 text-right">Handling Fee</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php
                                $oGrandQty = 0;
                                $oGrandTicketRevenue = 0;
                                $oGrandOrgTax = 0;
                                $oGrandNetRevenue = 0;
                                $oGrandService = 0;
                                $oGrandHandling = 0;
                            @endphp
                            @foreach($tickets as $index => $ticket)
                                @php
                                    $qty = (int)($ticket->online_qty_paid ?? 0);
                                    $totalPaid = (float)($ticket->online_total_paid ?? 0);

                                    // Original Ticket Revenue
                                    $ticketRevenue = $qty * $ticket->price;

                                    // Platform Tax Deduction
                                    $orgFeePerUnit = $event->organizer_fee_type === 'percent'
                                        ? $ticket->price * ($event->organizer_fee / 100)
                                        : $event->organizer_fee;

                                    $orgTaxTotal = $qty * $orgFeePerUnit;
                                    $netRevenue = $ticketRevenue - $orgTaxTotal;

                                    $handlingOnly = $qty * $handlingFeeValue;
                                    $serviceOnly = $totalPaid > 0 ? max(0, $totalPaid - ($ticketRevenue + $handlingOnly)) : 0;

                                    $oGrandQty += $qty;
                                    $oGrandTicketRevenue += $ticketRevenue;
                                    $oGrandOrgTax += $orgTaxTotal;
                                    $oGrandNetRevenue += $netRevenue;
                                    $oGrandService += $serviceOnly;
                                    $oGrandHandling += $handlingOnly;
                                @endphp
                                <tr class="hover:bg-primary/[0.02] transition-all group">
                                    <td class="px-6 py-6 text-xs font-bold text-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-6">
                                        <div class="font-black text-dark text-sm group-hover:text-primary transition-colors">{{ $ticket->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase mt-1">@ Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-black text-dark">
                                            {{ number_format($qty) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-right font-bold text-dark text-sm">
                                        Rp {{ number_format($ticketRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right text-xs text-red-500 font-bold">
                                        - Rp {{ number_format($orgTaxTotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right font-black text-primary text-sm">
                                        Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right text-xs text-primary font-black">
                                        Rp {{ number_format($serviceOnly, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right text-xs text-primary font-black">
                                        Rp {{ number_format($handlingOnly, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/80 border-t-2 border-primary/20 text-xs">
                            <tr class="font-black text-dark">
                                <td colspan="2" class="px-6 py-8 text-[11px] uppercase tracking-[0.25em] text-gray-400">Total Performance</td>
                                <td class="px-6 py-8 text-center text-lg text-dark">{{ number_format($oGrandQty) }}</td>
                                <td class="px-6 py-8 text-right">Rp {{ number_format($oGrandTicketRevenue, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-red-500">- Rp {{ number_format($oGrandOrgTax, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-primary font-black">Rp {{ number_format($oGrandNetRevenue, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-primary font-black text-sm">Rp {{ number_format($oGrandService, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-primary font-black text-sm">Rp {{ number_format($oGrandHandling, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reseller Sales Report Section -->
        <div class="mt-20 mb-32">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-black text-dark tracking-tight">Reseller Sales Performance</h2>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">B2B Channel Distribution Summary</p>
                </div>
                <div class="px-5 py-2.5 bg-primary/5 rounded-2xl border border-primary/10 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-[10px] font-black text-primary uppercase tracking-widest">Reseller Channel</span>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary/5 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] uppercase tracking-[0.2em] text-gray-400 font-black">
                                <th class="px-6 py-6">No</th>
                                <th class="px-6 py-6 font-black text-dark">Ticket Variation</th>
                                <th class="px-6 py-6 text-center">Volume</th>
                                <th class="px-6 py-6 text-right">Ticket Revenue</th>
                                <th class="px-6 py-6 text-right">Org Tax</th>
                                <th class="px-6 py-6 text-right">Saldo</th>
                                <th class="px-6 py-6 text-right">Commission Fee</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php
                                $rGrandQty = 0;
                                $rGrandTicketRevenue = 0;
                                $rGrandOrgTax = 0;
                                $rGrandNetRevenue = 0;
                                $rGrandCommission = 0;
                            @endphp
                            @foreach($tickets as $index => $ticket)
                                @php
                                    $qty = (int)($ticket->reseller_qty_paid ?? 0);
                                    $totalGross = (float)($ticket->reseller_total_paid ?? 0);

                                    // Original Ticket Revenue
                                    $ticketRevenue = $qty * $ticket->price;

                                    // Platform Tax Deduction
                                    $orgFeePerUnit = $event->organizer_fee_type === 'percent'
                                        ? $ticket->price * ($event->organizer_fee / 100)
                                        : $event->organizer_fee;

                                    $orgTaxTotal = $qty * $orgFeePerUnit;
                                    $netRevenue = $ticketRevenue - $orgTaxTotal;

                                    $commissionOnly = max(0, $totalGross - $ticketRevenue);

                                    $rGrandQty += $qty;
                                    $rGrandTicketRevenue += $ticketRevenue;
                                    $rGrandOrgTax += $orgTaxTotal;
                                    $rGrandNetRevenue += $netRevenue;
                                    $rGrandCommission += $commissionOnly;
                                @endphp
                                <tr class="hover:bg-primary/[0.02] transition-all group">
                                    <td class="px-6 py-6 text-xs font-bold text-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-6">
                                        <div class="font-black text-dark text-sm group-hover:text-primary transition-colors">{{ $ticket->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase mt-1">@ Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-black text-dark">
                                            {{ number_format($qty) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-right font-bold text-dark text-sm">
                                        Rp {{ number_format($ticketRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right text-xs text-red-500 font-bold">
                                        - Rp {{ number_format($orgTaxTotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right font-black text-emerald-600 text-sm">
                                        Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-6 text-right text-xs text-primary font-black">
                                        Rp {{ number_format($commissionOnly, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/80 border-t-2 border-primary/20 text-xs">
                            <tr class="font-black text-dark">
                                <td colspan="2" class="px-6 py-8 text-[11px] uppercase tracking-[0.25em] text-gray-400">Total Performance</td>
                                <td class="px-6 py-8 text-center text-lg text-dark">{{ number_format($rGrandQty) }}</td>
                                <td class="px-6 py-8 text-right">Rp {{ number_format($rGrandTicketRevenue, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-red-500">- Rp {{ number_format($rGrandOrgTax, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-primary font-black">Rp {{ number_format($rGrandNetRevenue, 0, ',', '.') }}</td>
                                <td class="px-6 py-8 text-right text-primary font-black text-sm">Rp {{ number_format($rGrandCommission, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
