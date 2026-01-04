<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function create(Event $event)
    {
        // Calculate Available Saldo
        $allTickets = $event->tickets()
            ->withSum(['transactions as online_qty' => fn($q) => $q->where('status', 'paid')->whereNull('reseller_id')], 'quantity')
            ->withSum(['transactions as reseller_qty' => fn($q) => $q->where('status', 'paid')->whereNotNull('reseller_id')], 'quantity')
            ->get();

        $totalTicketRevenue = 0;
        $totalOrgTax = 0;

        foreach ($allTickets as $t) {
            $qPaid = ($t->online_qty ?? 0) + ($t->reseller_qty ?? 0);
            $tRevenue = $qPaid * $t->price;

            $orgFeeUnit = $event->organizer_fee_type === 'percent'
                ? $t->price * ($event->organizer_fee / 100)
                : $event->organizer_fee;

            $totalTicketRevenue += $tRevenue;
            $totalOrgTax += ($qPaid * $orgFeeUnit);
        }

        $cumulativeSaldo = $totalTicketRevenue - $totalOrgTax;
        $totalWithdrawn = $event->withdrawals()->sum('amount');
        $availableSaldo = $cumulativeSaldo - $totalWithdrawn;

        $withdrawals = $event->withdrawals()->latest()->get();

        return view('admin.withdrawals.create', compact('event', 'availableSaldo', 'withdrawals'));
    }

    public function store(Request $request, Event $event)
    {
        // 1. Recalculate Total Saldo for validation
        $allTickets = $event->tickets()
            ->withSum(['transactions as online_qty' => fn($q) => $q->where('status', 'paid')->whereNull('reseller_id')], 'quantity')
            ->withSum(['transactions as reseller_qty' => fn($q) => $q->where('status', 'paid')->whereNotNull('reseller_id')], 'quantity')
            ->get();

        $totalTicketRevenue = 0;
        $totalOrgTax = 0;

        foreach ($allTickets as $t) {
            $qPaid = ($t->online_qty ?? 0) + ($t->reseller_qty ?? 0);
            $tRevenue = $qPaid * $t->price;

            $orgFeeUnit = $event->organizer_fee_type === 'percent'
                ? $t->price * ($event->organizer_fee / 100)
                : $event->organizer_fee;

            $totalTicketRevenue += $tRevenue;
            $totalOrgTax += ($qPaid * $orgFeeUnit);
        }

        $cumulativeSaldo = $totalTicketRevenue - $totalOrgTax;
        $totalWithdrawn = $event->withdrawals()->sum('amount');
        $availableSaldo = $cumulativeSaldo - $totalWithdrawn;

        // 2. Validate
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $availableSaldo,
            'note' => 'nullable|string|max:500',
        ]);

        // 3. Create Withdrawal record
        $event->withdrawals()->create([
            'amount' => $validated['amount'],
            'reference' => $event->name, // User request: withdraw refers to the event name
            'note' => $validated['note'],
        ]);

        return redirect()->route('admin.events.tickets.index', $event)->with('success', 'Withdrawal recorded successfully.');
    }
}
