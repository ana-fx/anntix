<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('event')->latest()->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function create(Event $event = null)
    {
        $events = [];
        if (!$event) {
            $events = Event::orderBy('name')->get();
        }

        $availableSaldo = $event ? $event->available_saldo : 0;
        $withdrawals = $event ? $event->withdrawals()->latest()->get() : collect();

        return view('admin.withdrawals.create', compact('event', 'events', 'availableSaldo', 'withdrawals'));
    }

    public function store(Request $request, Event $event = null)
    {
        // If event is not in route, it must be in request
        $eventId = $event ? $event->id : $request->event_id;
        $event = $event ?: Event::findOrFail($eventId);

        $availableSaldo = $event->available_saldo;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $availableSaldo,
            'note' => 'nullable|string|max:500',
        ]);

        $event->withdrawals()->create([
            'amount' => $validated['amount'],
            'status' => 'approved', // Admin manually creating is auto-approved
            'reference' => 'Admin Manual',
            'note' => $validated['note'],
        ]);

        if ($request->has('from_event')) {
            return redirect()->route('admin.events.withdrawals.create_for_event', $event)->with('success', 'Withdrawal recorded and approved successfully.');
        }

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal recorded and approved successfully.');
    }

    public function approve(Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Withdrawal request approved.');
    }

    public function reject(Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Withdrawal request rejected.');
    }

    public function edit(Withdrawal $withdrawal)
    {
        $event = $withdrawal->event;
        $availableSaldo = $event->available_saldo + $withdrawal->amount;
        return view('admin.withdrawals.edit', compact('event', 'withdrawal', 'availableSaldo'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $event = $withdrawal->event;
        $availableSaldo = $event->available_saldo + $withdrawal->amount;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $availableSaldo,
            'status' => 'nullable|in:pending,approved,rejected',
            'note' => 'nullable|string|max:500',
        ]);

        $withdrawal->update([
            'amount' => $validated['amount'],
            'status' => $validated['status'] ?? $withdrawal->status,
            'note' => $validated['note'] ?? $withdrawal->note,
        ]);

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal updated successfully.');
    }

    public function destroy(Withdrawal $withdrawal)
    {
        $withdrawal->delete();
        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal deleted successfully.');
    }
}
