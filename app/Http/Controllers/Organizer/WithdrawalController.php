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

        $totalAvailableSaldo = 0;
        foreach ($events as $event) {
            $totalAvailableSaldo += $event->available_saldo;
        }

        $withdrawals = \App\Models\Withdrawal::whereIn('event_id', $events->pluck('id'))
            ->with('event')
            ->latest()
            ->paginate(50);

        return view('organizer.withdrawals.global', compact('events', 'totalAvailableSaldo', 'withdrawals'));
    }

    public function index(Event $event)
    {
        $this->authorizeEvent($event);

        $availableSaldo = $event->available_saldo;

        // Load withdrawals including pending ones to show the history properly
        $withdrawals = $event->withdrawals()->latest()->get();

        return view('organizer.withdrawals.index', compact('event', 'availableSaldo', 'withdrawals'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $availableSaldo = $event->available_saldo;

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
