<x-layouts.admin>
    <x-slot name="title">Ticket Report - {{ $event->name }}</x-slot>

    <div class="pb-10">
        <!-- Header Section -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.events.index') }}"
                        class="group inline-flex items-center text-xs font-bold text-gray-400 hover:text-primary transition-all gap-2">
                        <div class="w-8 h-8 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center group-hover:border-primary/20 group-hover:bg-primary/5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-dark tracking-tight">{{ $event->name }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-md">Ticket Report</span>
                            <span class="text-gray-300 text-[10px] uppercase font-bold tracking-widest">•</span>
                            <span class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Global Analytics</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.events.withdrawals.create_for_event', $event) }}"
                        class="px-6 py-3 bg-dark text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-dark/10 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Withdraw
                    </a>
                    <button onclick="exportToExcel()"
                        class="px-6 py-3 bg-white text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-50 transition-all border border-gray-200 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-3xl bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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





        <div x-data="{ activeTab: 'all' }" class="w-full">
            <!-- Tabs Navigation -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div class="flex flex-wrap items-center gap-1 bg-white p-1 rounded-2xl w-full sm:w-fit shadow-sm border border-gray-100">
                    <button @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-400 hover:text-dark hover:bg-gray-50'"
                        class="flex-1 sm:flex-none px-6 sm:px-8 py-3 rounded-xl font-black text-[10px] sm:text-xs uppercase tracking-widest transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        All Sales
                    </button>
                    <button @click="activeTab = 'online'"
                        :class="activeTab === 'online' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-400 hover:text-dark hover:bg-gray-50'"
                        class="flex-1 sm:flex-none px-6 sm:px-8 py-3 rounded-xl font-black text-[10px] sm:text-xs uppercase tracking-widest transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        Online Sales
                    </button>
                    <button @click="activeTab = 'reseller'"
                        :class="activeTab === 'reseller' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-400 hover:text-dark hover:bg-gray-50'"
                        class="px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Reseller Sales
                    </button>
                </div>

                <a href="{{ route('admin.events.tickets-report.create', $event) }}"
                    class="inline-flex items-center px-6 py-3 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-primary-700 transition-all shadow-xl shadow-primary/20 gap-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Ticket
                </a>
            </div>

            <!-- All Sales Report Section -->
            <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-black text-dark tracking-tight">Consolidated Revenue</h2>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">Aggregate performance across all channels</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="px-5 py-2.5 bg-primary/5 rounded-2xl border border-primary/10 flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest">Global Overview</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm shadow-primary/5 border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3 font-black text-dark">Ticket Variation</th>
                                    <th class="px-4 py-3 text-center">Volume</th>
                                    <th class="px-4 py-3 text-right">Ticket Revenue</th>
                                    <th class="px-4 py-3 text-right">Saldo</th>
                                    <th class="px-4 py-3 text-right">Org Tax</th>
                                    <th class="px-4 py-3 text-right">Handling</th>
                                    <th class="px-4 py-3 text-right">Platform</th>
                                    <th class="px-4 py-3 text-right">Service</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @php
                                    $gGrandQty = 0;
                                    $gGrandTicketRevenue = 0;
                                    $gGrandOrgTax = 0;
                                    $gGrandNetRevenue = 0;
                                    $gGrandService = 0;
                                    $gGrandHandling = 0;
                                    $hFee = (float) \App\Models\Setting::getValue('handling_fee', 0);

                                    foreach($allTickets as $t) {
                                        $oQty = (int) ($t->online_qty_paid ?? 0);
                                        $rQty = (int) ($t->reseller_qty_paid ?? 0);
                                        $qty = $oQty + $rQty;

                                        $onlineTotalPaid = (float) ($t->online_total_paid ?? 0);
                                        $ticketPrice = $t->price;
                                        $ticketRevenue = $qty * $ticketPrice;

                                        // Online Tax
                                        $onlineFeeType = $t->organizer_fee_online_type ?? $event->organizer_fee_online_type;
                                        $onlineFeeValue = $t->organizer_fee_online ?? $event->organizer_fee_online;
                                        $onlineOrgFeePerUnit = $onlineFeeType === 'percent' ? $ticketPrice * ($onlineFeeValue / 100) : $onlineFeeValue;
                                        $onlineOrgTaxTotal = $oQty * $onlineOrgFeePerUnit;

                                        // Reseller Tax
                                        $resellerFeeType = $t->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
                                        $resellerFeeValue = $t->organizer_fee_reseller ?? $event->organizer_fee_reseller;
                                        $resellerOrgFeePerUnit = $resellerFeeType === 'percent' ? $ticketPrice * ($resellerFeeValue / 100) : $resellerFeeValue;
                                        $resellerOrgTaxTotal = $rQty * $resellerOrgFeePerUnit;

                                        $totalOrgTax = $onlineOrgTaxTotal + $resellerOrgTaxTotal;

                                        $handlingOnly = $oQty * $hFee;
                                        $serviceOnly = $onlineTotalPaid > 0 ? max(0, $onlineTotalPaid - (($oQty * $ticketPrice) + $handlingOnly)) : 0;

                                        $gGrandQty += $qty;
                                        $gGrandTicketRevenue += $ticketRevenue;
                                        $gGrandOrgTax += $totalOrgTax;
                                        $gGrandNetRevenue += ($ticketRevenue - $totalOrgTax);
                                        $gGrandService += $serviceOnly;
                                        $gGrandHandling += $handlingOnly;
                                    }
                                @endphp
                                @foreach($tickets as $index => $ticket)
                                    @php
                                        $oQty = (int) ($ticket->online_qty_paid ?? 0);
                                        $rQty = (int) ($ticket->reseller_qty_paid ?? 0);
                                        $qty = $oQty + $rQty;

                                        $onlineTotalPaid = (float) ($ticket->online_total_paid ?? 0);
                                        $ticketRevenue = $qty * $ticket->price;

                                        // Online Tax
                                        $onlineFeeType = $ticket->organizer_fee_online_type ?? $event->organizer_fee_online_type;
                                        $onlineFeeValue = $ticket->organizer_fee_online ?? $event->organizer_fee_online;
                                        $onlineOrgFeePerUnit = $onlineFeeType === 'percent' ? $ticket->price * ($onlineFeeValue / 100) : $onlineFeeValue;
                                        $onlineOrgTaxTotal = $oQty * $onlineOrgFeePerUnit;

                                        // Reseller Tax
                                        $resellerFeeType = $ticket->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
                                        $resellerFeeValue = $ticket->organizer_fee_reseller ?? $event->organizer_fee_reseller;
                                        $resellerOrgFeePerUnit = $resellerFeeType === 'percent' ? $ticket->price * ($resellerFeeValue / 100) : $resellerFeeValue;
                                        $resellerOrgTaxTotal = $rQty * $resellerOrgFeePerUnit;

                                        $totalOrgTax = $onlineOrgTaxTotal + $resellerOrgTaxTotal;
                                        $netRevenue = $ticketRevenue - $totalOrgTax;

                                        $handlingOnly = $oQty * $hFee;
                                        $serviceOnly = $onlineTotalPaid > 0 ? max(0, $onlineTotalPaid - (($oQty * $ticket->price) + $handlingOnly)) : 0;
                                        $platformRev = $totalOrgTax + $handlingOnly + $serviceOnly;
                                    @endphp
                                    <tr class="hover:bg-primary/[0.02] transition-all group">
                                        <td class="px-4 py-3 text-xs font-bold text-gray-300">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-black text-dark text-sm group-hover:text-primary transition-colors">
                                                {{ $ticket->name }}
                                            </div>
                                            <div class="text-[9px] text-gray-400 font-bold uppercase mt-1">@ Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-black text-dark">
                                                {{ number_format($qty) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right font-bold text-dark text-sm">
                                            Rp {{ number_format($ticketRevenue, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-black text-primary text-sm">
                                            Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-xs text-gray-500 font-bold">
                                            Rp {{ number_format($totalOrgTax, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-xs text-primary font-black">
                                            Rp {{ number_format($handlingOnly, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-xs text-gray-500 font-bold">
                                            Rp {{ number_format($platformRev, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-xs text-primary font-black">
                                            Rp {{ number_format($serviceOnly, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50/80 border-t-2 border-primary/20 text-xs">
                                <tr class="font-black text-dark">
                                    <td colspan="2" class="px-4 py-4 text-[11px] uppercase tracking-[0.25em] text-gray-400">Grand Total</td>
                                    <td class="px-4 py-4 text-center text-lg text-dark">{{ number_format($gGrandQty) }}</td>
                                    <td class="px-4 py-4 text-right">Rp {{ number_format($gGrandTicketRevenue, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right text-primary font-black">Rp {{ number_format($gGrandNetRevenue, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right text-gray-500">Rp {{ number_format($gGrandOrgTax, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right text-primary font-black">Rp {{ number_format($gGrandHandling, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right text-gray-500 font-bold">Rp {{ number_format($gGrandOrgTax + $gGrandHandling + $gGrandService, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right text-primary font-black">Rp {{ number_format($gGrandService, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Online Sales Report Section -->
            <div x-show="activeTab === 'online'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-black text-dark tracking-tight">Online Revenue Digest</h2>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">Platform direct sales
                        analytics</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="px-5 py-2.5 bg-primary/5 rounded-2xl border border-primary/10 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                        <span class="text-[9px] font-black text-primary uppercase tracking-widest">Online
                            Channel</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm shadow-primary/5 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="online-table" class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3 font-black text-dark">Ticket Variation</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Volume</th>
                                <th class="px-4 py-3 text-center">Stock</th>
                                <th class="px-4 py-3 text-right">Ticket Revenue</th>
                                <th class="px-4 py-3 text-right">Saldo</th>
                                <th class="px-4 py-3 text-right">Org Tax</th>
                                <th class="px-4 py-3 text-right">Handling Fee</th>
                                <th class="px-4 py-3 text-right">Service Fee</th>
                                <th class="px-4 py-3 text-right">Midtrans Fee</th>
                                <th class="px-4 py-3 text-right">Platform Rev</th>
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
                                    $oGrandMidtrans = 0;
                                    $oGrandAvailable = 0;
                                    $oGrandQuota = 0;

                                    /** @var \App\Models\Ticket $t */
                                    foreach ($allTickets as $t) {
                                        $t->setRelation('event', $event);
                                        $qty = (int) ($t->online_qty_paid ?? 0);
                                        $totalPaid = (float) ($t->online_total_paid ?? 0);
                                        $ticketPrice = $t->price;
                                        $ticketRevenue = $qty * $ticketPrice;

                                        $onlineFeeType = $t->organizer_fee_online_type ?? $event->organizer_fee_online_type;
                                        $onlineFeeValue = $t->organizer_fee_online ?? $event->organizer_fee_online;
                                        $orgFeePerUnit = $onlineFeeType === 'percent' ? $ticketPrice * ($onlineFeeValue / 100) : $onlineFeeValue;
                                        $orgTaxTotal = $qty * $orgFeePerUnit;

                                        $breakdown = $t->getFeeBreakdown();
                                        $handlingOnly = $qty * $breakdown['handling'];
                                        $serviceOnly = $qty * $breakdown['service'];

                                        // Midtrans Fee = Total Bayar - (Revenue + Admin/Platform Fees)
                                        $midtransOnly = $totalPaid > 0 ? max(0, $totalPaid - ($ticketRevenue + $handlingOnly + $serviceOnly)) : 0;

                                        $oGrandQty += $qty;
                                        $oGrandTicketRevenue += $ticketRevenue;
                                        $oGrandOrgTax += $orgTaxTotal;
                                        $oGrandNetRevenue += ($ticketRevenue - $orgTaxTotal);
                                        $oGrandService += $serviceOnly;
                                        $oGrandHandling += $handlingOnly;
                                        $oGrandMidtrans += $midtransOnly;

                                        $soldAll = $t->transactions_sum_quantity_paid ?? 0;
                                        $oGrandAvailable += max(0, $t->quota - $soldAll);
                                        $oGrandQuota += $t->quota;
                                    }
                                @endphp
                            @foreach($tickets as $index => $ticket)
                                @php
                                    /** @var \App\Models\Ticket $ticket */
                                    $qty = (int) ($ticket->online_qty_paid ?? 0);
                                    $totalPaid = (float) ($ticket->online_total_paid ?? 0);

                                    // Original Ticket Revenue
                                    $ticketRevenue = $qty * $ticket->price;

                                    // Platform Tax Deduction
                                    $onlineFeeType = $ticket->organizer_fee_online_type ?? $event->organizer_fee_online_type;
                                    $onlineFeeValue = $ticket->organizer_fee_online ?? $event->organizer_fee_online;

                                    $orgFeePerUnit = $onlineFeeType === 'percent'
                                        ? $ticket->price * ($onlineFeeValue / 100)
                                        : $onlineFeeValue;

                                    $orgTaxTotal = $qty * $orgFeePerUnit;
                                    $netRevenue = $ticketRevenue - $orgTaxTotal;

                                    $breakdown = $ticket->getFeeBreakdown();
                                    $handlingOnly = $qty * $breakdown['handling'];
                                    $serviceOnly = $qty * $breakdown['service'];

                                    // Midtrans Fee calculation
                                    $midtransOnly = $totalPaid > 0 ? max(0, $totalPaid - ($ticketRevenue + $handlingOnly + $serviceOnly)) : 0;

                                    $soldAll = $ticket->transactions_sum_quantity_paid ?? 0;
                                    $currentAvailable = max(0, $ticket->quota - $soldAll);
                                @endphp
                                <tr class="hover:bg-primary/[0.02] transition-all group">
                                    <td class="px-4 py-3 text-xs font-bold text-gray-300">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <div
                                            class="font-black text-dark text-sm group-hover:text-primary transition-colors">
                                            {{ $ticket->name }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase mt-1">@ Rp
                                            {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($ticket->is_active)
                                            <span
                                                class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold uppercase tracking-wider">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold uppercase tracking-wider">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-black text-dark">
                                            {{ number_format($qty) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="font-black text-dark text-sm">{{ number_format($currentAvailable) }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">/
                                            {{ number_format($ticket->quota) }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-dark text-sm">
                                        Rp {{ number_format($ticketRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-primary text-sm">
                                        Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-gray-500 font-bold">
                                        Rp {{ number_format($orgTaxTotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-primary font-black">
                                        Rp {{ number_format($handlingOnly, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-gray-400 font-bold">
                                        Rp {{ number_format($serviceOnly, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-amber-600 font-bold">
                                        Rp {{ number_format($midtransOnly, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-gray-500 font-black">
                                        Rp {{ number_format($orgTaxTotal + $handlingOnly + $serviceOnly + $midtransOnly, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/80 border-t-2 border-primary/20 text-xs">
                            <tr class="font-black text-dark">
                                <td colspan="2" class="px-4 py-4 text-[11px] uppercase tracking-[0.25em] text-gray-400">
                                    Total Performance</td>
                                <td class="px-4 py-4 text-center text-lg text-dark">{{ number_format($oGrandQty) }}</td>
                                <td class="px-4 py-4 text-center text-lg text-dark">
                                    {{ number_format($oGrandAvailable) }}
                                    <span class="text-[9px] text-gray-400 block font-bold uppercase mt-0.5">/
                                        {{ number_format($oGrandQuota) }}</span>
                                </td>
                                <td class="px-4 py-4 text-right">Rp
                                    {{ number_format($oGrandTicketRevenue, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-primary font-black">Rp
                                    {{ number_format($oGrandNetRevenue, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-gray-500">Rp
                                    {{ number_format($oGrandOrgTax, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-primary font-black">Rp
                                    {{ number_format($oGrandHandling, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-gray-400 font-bold">Rp
                                    {{ number_format($oGrandService, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-amber-600 font-bold">Rp
                                    {{ number_format($oGrandMidtrans, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-gray-500 font-black text-sm">Rp
                                    {{ number_format($oGrandOrgTax + $oGrandHandling + $oGrandService + $oGrandMidtrans, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            </div>

            <!-- Reseller Sales Report Section -->
            <div x-show="activeTab === 'reseller'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-black text-dark tracking-tight">Reseller Sales Performance</h2>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-2">B2B Channel Distribution
                        Summary</p>
                </div>
                <div class="px-5 py-2.5 bg-primary/5 rounded-2xl border border-primary/10 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-[9px] font-black text-primary uppercase tracking-widest">Reseller Channel</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm shadow-primary/5 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="reseller-table" class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 border-b border-gray-100 text-[9px] uppercase tracking-wider text-gray-400 font-black">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3 font-black text-dark">Ticket Variation</th>
                                <th class="px-4 py-3 text-center">Volume</th>
                                <th class="px-4 py-3 text-right">Ticket Revenue</th>
                                <th class="px-4 py-3 text-right">Saldo</th>
                                <th class="px-4 py-3 text-right">Org Tax</th>
                                <th class="px-4 py-3 text-right">Commission Fee</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php
                                $rGrandQty = 0;
                                $rGrandTicketRevenue = 0;
                                $rGrandOrgTax = 0;
                                $rGrandNetRevenue = 0;
                                $rGrandCommission = 0;

                                foreach($allTickets as $t) {
                                    $qty = (int) ($t->reseller_qty_paid ?? 0);
                                    $totalGross = (float) ($t->reseller_total_paid ?? 0);
                                    $ticketPrice = $t->price;
                                    $ticketRevenue = $qty * $ticketPrice;

                                    $resellerFeeType = $t->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
                                    $resellerFeeValue = $t->organizer_fee_reseller ?? $event->organizer_fee_reseller;
                                    $orgFeePerUnit = $resellerFeeType === 'percent' ? $ticketPrice * ($resellerFeeValue / 100) : $resellerFeeValue;
                                    $orgTaxTotal = $qty * $orgFeePerUnit;

                                    $rGrandQty += $qty;
                                    $rGrandTicketRevenue += $ticketRevenue;
                                    $rGrandOrgTax += $orgTaxTotal;
                                    $rGrandNetRevenue += ($ticketRevenue - $orgTaxTotal);
                                    $rGrandCommission += max(0, $totalGross - $ticketRevenue);
                                }
                            @endphp
                            @foreach($tickets as $index => $ticket)
                                @php
                                    $qty = (int) ($ticket->reseller_qty_paid ?? 0);
                                    $totalGross = (float) ($ticket->reseller_total_paid ?? 0);

                                    // Original Ticket Revenue
                                    $ticketRevenue = $qty * $ticket->price;

                                    // Platform Tax Deduction
                                    $resellerFeeType = $ticket->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
                                    $resellerFeeValue = $ticket->organizer_fee_reseller ?? $event->organizer_fee_reseller;

                                    $orgFeePerUnit = $resellerFeeType === 'percent'
                                        ? $ticket->price * ($resellerFeeValue / 100)
                                        : $resellerFeeValue;

                                    $orgTaxTotal = $qty * $orgFeePerUnit;
                                    $netRevenue = $ticketRevenue - $orgTaxTotal;

                                    $commissionOnly = max(0, $totalGross - $ticketRevenue);
                                @endphp
                                <tr class="hover:bg-primary/[0.02] transition-all group">
                                    <td class="px-4 py-3 text-xs font-bold text-gray-300">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <div
                                            class="font-black text-dark text-sm group-hover:text-primary transition-colors">
                                            {{ $ticket->name }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase mt-1">@ Rp
                                            {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-black text-dark">
                                            {{ number_format($qty) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-dark text-sm">
                                        Rp {{ number_format($ticketRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-primary text-sm">
                                        Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-gray-500 font-bold">
                                        Rp {{ number_format($orgTaxTotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-primary font-black">
                                        Rp {{ number_format($commissionOnly, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/80 border-t-2 border-primary/20 text-xs">
                            <tr class="font-black text-dark">
                                <td colspan="2" class="px-4 py-4 text-[11px] uppercase tracking-[0.25em] text-gray-400">
                                    Total Performance</td>
                                <td class="px-4 py-4 text-center text-lg text-dark">{{ number_format($rGrandQty) }}</td>
                                <td class="px-4 py-4 text-right">Rp
                                    {{ number_format($rGrandTicketRevenue, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-primary font-black">Rp
                                    {{ number_format($rGrandNetRevenue, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-gray-500">Rp
                                    {{ number_format($rGrandOrgTax, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-primary font-black text-sm">Rp
                                    {{ number_format($rGrandCommission, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Financial Performance Dashboard (Professional Redesign) -->
        <div class="mt-16 max-w-6xl mx-auto w-full px-4 sm:px-0">
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <!-- Dashboard Header -->
                <div class="px-10 py-8 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/30">
                    <div>
                        <h3 class="text-2xl font-black text-dark tracking-tight">Financial Performance</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-1">Real-time revenue & settlement analytics</p>
                    </div>
                    <div class="flex items-center gap-3 px-4 py-2 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Live Updates</span>
                    </div>
                </div>
                               <div class="p-8 sm:p-14">
                    <!-- Highlight: Settled Balance (Wide) -->
                    <div class="mb-14 bg-primary/5 rounded-[3rem] p-10 sm:p-12 border border-primary/10 relative overflow-hidden group">
                        <div class="absolute -right-12 -top-12 w-96 h-96 bg-primary/5 rounded-full blur-3xl transition-all duration-1000 group-hover:scale-110"></div>
                        <div class="relative flex flex-col xl:flex-row xl:items-center justify-between gap-10">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="text-[12px] uppercase tracking-[0.4em] text-primary font-black">Settled Balance</div>
                                </div>
                                <div class="flex items-baseline gap-3">
                                    <span class="text-2xl font-black text-primary/30">Rp</span>
                                    <span class="text-4xl sm:text-6xl lg:text-7xl font-black text-primary tracking-tightest leading-none tabular-nums">{{ number_format($availableSaldo, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-8 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Total funds available for immediate withdrawal
                                </p>
                            </div>
                            
                            <div class="hidden xl:block h-24 w-px bg-primary/10 mx-4"></div>
                            
                            <div class="flex flex-col sm:flex-row xl:flex-col gap-6 xl:gap-8 flex-1 xl:max-w-xs">
                                <div class="flex-1 bg-white/50 backdrop-blur-sm p-6 rounded-2xl border border-primary/5">
                                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Platform Revenue</div>
                                    <div class="text-xl font-black text-dark tracking-tight">Rp{{ number_format($totalPlatformRevenue, 0, ',', '.') }}</div>
                                </div>
                                <div class="flex-1 bg-white/50 backdrop-blur-sm p-6 rounded-2xl border border-primary/5">
                                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Withdrawn</div>
                                    <div class="text-xl font-black text-gray-500 tracking-tight">Rp{{ number_format($totalWithdrawn, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 sm:gap-16">
                        <div class="group px-8 border-l-4 border-gray-100 hover:border-primary/30 transition-all">
                            <div class="text-[10px] uppercase tracking-[0.25em] text-gray-400 font-black mb-4">Gross Revenue</div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-bold text-gray-300">Rp</span>
                                <span class="text-3xl font-black text-dark leading-none tracking-tight">{{ number_format($totalTicketRevenue, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="group px-8 border-l-4 border-red-100 hover:border-red-300 transition-all">
                            <div class="text-[10px] uppercase tracking-[0.25em] text-red-400 font-black mb-4">Total Fee / Tax</div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-bold text-red-200">- Rp</span>
                                <span class="text-3xl font-black text-red-500 leading-none tracking-tight">{{ number_format($totalOrgTax, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="group px-8 border-l-4 border-emerald-100 hover:border-emerald-300 transition-all">
                            <div class="text-[10px] uppercase tracking-[0.25em] text-emerald-400 font-black mb-4">Organizer Saldo</div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-bold text-emerald-200">Rp</span>
                                <span class="text-3xl font-black text-emerald-600 leading-none tracking-tight">{{ number_format($totalSaldo, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
>
            </div>
        </div>
    </div>

    <!-- EXPORT TABLES (HIDDEN) -->
    <div class="hidden">
        <!-- All Sales Export Table -->
        <table id="all-table-export">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ticket Variation</th>
                    <th>Volume</th>
                    <th>Ticket Revenue</th>
                    <th>Saldo</th>
                    <th>Org Tax</th>
                    <th>Handling Fee</th>
                    <th>Platform Rev</th>
                    <th>Service Fee</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hFeeGlobal = (float) \App\Models\Setting::getValue('handling_fee', 0);
                @endphp
                @foreach($allTickets as $index => $ticket)
                    @php
                        $oQty = (int) ($ticket->online_qty_paid ?? 0);
                        $rQty = (int) ($ticket->reseller_qty_paid ?? 0);
                        $qty = $oQty + $rQty;

                        $onlineTotalPaid = (float) ($ticket->online_total_paid ?? 0);
                        $ticketPrice = $ticket->price;
                        $ticketRevenue = $qty * $ticketPrice;

                        // Online Tax
                        $onlineFeeType = $ticket->organizer_fee_online_type ?? $event->organizer_fee_online_type;
                        $onlineFeeValue = $ticket->organizer_fee_online ?? $event->organizer_fee_online;
                        $onlineOrgFeePerUnit = $onlineFeeType === 'percent' ? $ticketPrice * ($onlineFeeValue / 100) : $onlineFeeValue;
                        $onlineOrgTaxTotal = $oQty * $onlineOrgFeePerUnit;

                        // Reseller Tax
                        $resellerFeeType = $ticket->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
                        $resellerFeeValue = $ticket->organizer_fee_reseller ?? $event->organizer_fee_reseller;
                        $resellerOrgFeePerUnit = $resellerFeeType === 'percent' ? $ticketPrice * ($resellerFeeValue / 100) : $resellerFeeValue;
                        $resellerOrgTaxTotal = $rQty * $resellerOrgFeePerUnit;

                        $totalOrgTax = $onlineOrgTaxTotal + $resellerOrgTaxTotal;
                        $netRevenue = $ticketRevenue - $totalOrgTax;

                        $handlingOnly = $oQty * $hFeeGlobal;
                        $serviceOnly = $onlineTotalPaid > 0 ? max(0, $onlineTotalPaid - (($oQty * $ticket->price) + $handlingOnly)) : 0;
                        $platformRev = $totalOrgTax + $handlingOnly + $serviceOnly;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ticket->name }}</td>
                        <td>{{ $qty }}</td>
                        <td>{{ $ticketRevenue }}</td>
                        <td>{{ $netRevenue }}</td>
                        <td>{{ $totalOrgTax }}</td>
                        <td>{{ $handlingOnly }}</td>
                        <td>{{ $platformRev }}</td>
                        <td>{{ $serviceOnly }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Online Export Table -->
        <table id="online-table-export">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ticket Variation</th>
                    <th>Status</th>
                    <th>Volume</th>
                    <th>Stock</th>
                    <th>Ticket Revenue</th>
                    <th>Saldo</th>
                    <th>Org Tax</th>
                    <th>Handling Fee</th>
                    <th>Platform Rev</th>
                    <th>Service Fee</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allTickets as $index => $ticket)
                    @php
                        $qty = (int) ($ticket->online_qty_paid ?? 0);
                        $totalPaid = (float) ($ticket->online_total_paid ?? 0);

                        // Original Ticket Revenue
                        $ticketRevenue = $qty * $ticket->price;

                        // Platform Tax Deduction
                        $onlineFeeType = $ticket->organizer_fee_online_type ?? $event->organizer_fee_online_type;
                        $onlineFeeValue = $ticket->organizer_fee_online ?? $event->organizer_fee_online;

                        $orgFeePerUnit = $onlineFeeType === 'percent'
                            ? $ticket->price * ($onlineFeeValue / 100)
                            : $onlineFeeValue;

                        $orgTaxTotal = $qty * $orgFeePerUnit;
                        $netRevenue = $ticketRevenue - $orgTaxTotal;

                        $handlingOnly = $qty * $ticket->getHandlingFee();
                        $serviceOnly = $totalPaid > 0 ? max(0, $totalPaid - ($ticketRevenue + $handlingOnly)) : 0;

                        $platformRev = $orgTaxTotal + $handlingOnly;

                        // Stock Calculation
                        $soldAll = $ticket->transactions_sum_quantity_paid ?? 0;
                        $pendingAll = $ticket->transactions_sum_quantity_pending ?? 0;
                        $currentAvailable = max(0, $ticket->quota - $soldAll - $pendingAll);
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ticket->name }}</td>
                        <td>{{ $ticket->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $qty }}</td>
                        <td>{{ $currentAvailable }} / {{ $ticket->quota }}</td>
                        <td>{{ $ticketRevenue }}</td>
                        <td>{{ $netRevenue }}</td>
                        <td>{{ $orgTaxTotal }}</td>
                        <td>{{ $handlingOnly }}</td>
                        <td>{{ $platformRev }}</td>
                        <td>{{ $serviceOnly }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Reseller Export Table -->
        <table id="reseller-table-export">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ticket Variation</th>
                    <th>Volume</th>
                    <th>Ticket Revenue</th>
                    <th>Saldo</th>
                    <th>Org Tax</th>
                    <th>Commission Fee</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allTickets as $index => $ticket)
                    @php
                        $qty = (int) ($ticket->reseller_qty_paid ?? 0);
                        $totalGross = (float) ($ticket->reseller_total_paid ?? 0);

                        // Original Ticket Revenue
                        $ticketRevenue = $qty * $ticket->price;

                        // Platform Tax Deduction
                        $resellerFeeType = $ticket->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
                        $resellerFeeValue = $ticket->organizer_fee_reseller ?? $event->organizer_fee_reseller;

                        $orgFeePerUnit = $resellerFeeType === 'percent'
                            ? $ticket->price * ($resellerFeeValue / 100)
                            : $resellerFeeValue;

                        $orgTaxTotal = $qty * $orgFeePerUnit;
                        $netRevenue = $ticketRevenue - $orgTaxTotal;

                        $commissionOnly = max(0, $totalGross - $ticketRevenue);
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ticket->name }}</td>
                        <td>{{ $qty }}</td>
                        <td>{{ $ticketRevenue }}</td>
                        <td>{{ $netRevenue }}</td>
                        <td>{{ $orgTaxTotal }}</td>
                        <td>{{ $commissionOnly }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
        <script>
            function exportToExcel() {
                const wb = XLSX.utils.book_new();

                const allTable = document.getElementById('all-table-export');
                if (allTable) {
                    const ws0 = XLSX.utils.table_to_sheet(allTable);
                    XLSX.utils.book_append_sheet(wb, ws0, "All Sales");
                }

                const onlineTable = document.getElementById('online-table-export');
                if (onlineTable) {
                    const ws1 = XLSX.utils.table_to_sheet(onlineTable);
                    XLSX.utils.book_append_sheet(wb, ws1, "Online Sales");
                }

                const resellerTable = document.getElementById('reseller-table-export');
                if (resellerTable) {
                    const ws2 = XLSX.utils.table_to_sheet(resellerTable);
                    XLSX.utils.book_append_sheet(wb, ws2, "Reseller Sales");
                }

                XLSX.writeFile(wb, "Ticket_Report_{{ $event->slug }}_" + new Date().toISOString().split('T')[0] + ".xlsx");
            }
        </script>
    @endpush
</x-layouts.admin>
