<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function globalIndex()
    {
        $organizerId = Auth::id();
        $events = Event::where('organizer_id', $organizerId)->get();

        $totals = [
            'gross_revenue'     => 0,
            'organizer_fees'    => 0,
            'net_revenue'       => 0,
            'withdrawn_approved'=> 0,
            'withdrawn_pending' => 0,
            'available_saldo'   => 0,
        ];

        foreach ($events as $event) {
            $breakdown = $event->calculateFinancialBreakdown();
            $event->financial = $breakdown;
            foreach ($totals as $key => $_) {
                $totals[$key] += $breakdown[$key];
            }
        }

        // Attach withdrawals grouped by event (only events that have at least one withdrawal)
        foreach ($events as $event) {
            $event->withdrawalHistory = $event->withdrawals()->latest()->get();
        }

        return view('organizer.withdrawals.global', compact('events', 'totals'));
    }

    public function index(Event $event)
    {
        $this->authorizeEvent($event);

        $financial = $event->calculateFinancialBreakdown();
        $withdrawals = $event->withdrawals()->latest()->get();

        return view('organizer.withdrawals.index', compact('event', 'financial', 'withdrawals'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $financial = $event->calculateFinancialBreakdown();
        $availableSaldo = $financial['available_saldo'];

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $availableSaldo,
            'note' => 'nullable|string|max:500',
        ]);

        $event->withdrawals()->create([
            'amount' => $validated['amount'],
            'status' => 'pending',
            'reference' => 'Requested by Organizer',
            'note' => $validated['note'],
        ]);

        return redirect()->route('organizer.events.withdrawals.index', $event)->with('success', 'Withdrawal request submitted successfully.');
    }

    protected function authorizeEvent(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'You are not assigned to this event.');
        }
    }
}
