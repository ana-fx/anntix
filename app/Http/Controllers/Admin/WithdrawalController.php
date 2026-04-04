<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PlatformWithdrawal;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $events = Event::with('organizer')->orderBy('name')->get();

        $totals = [
            'gross_revenue'         => 0,
            'handling_fees'         => 0,
            'organizer_fees'        => 0,
            'total_platform_income' => 0,
            'net_revenue'           => 0,
            'withdrawn_approved'    => 0,
            'withdrawn_pending'     => 0,
            'available_saldo'       => 0,
        ];

        foreach ($events as $event) {
            $f = $event->calculateFinancialBreakdown();
            $event->financial = $f;
            foreach ($totals as $key => $_) {
                $totals[$key] += $f[$key];
            }
        }

        $pendingCount = Withdrawal::where('status', 'pending')->count();

        return view('admin.withdrawals.index', compact('events', 'totals', 'pendingCount'));
    }

    public function eventShow(Event $event)
    {
        $financial = $event->calculateFinancialBreakdown();
        $withdrawals = $event->withdrawals()->latest()->get();
        $platformWithdrawals = $event->platformWithdrawals()->latest()->get();

        return view('admin.withdrawals.show', compact('event', 'financial', 'withdrawals', 'platformWithdrawals'));
    }

    public function create(Event $event = null)
    {
        $events = [];
        $eventFinancials = [];
        if (!$event) {
            $events = Event::orderBy('name')->get();
            foreach ($events as $e) {
                $f = $e->calculateFinancialBreakdown();
                $eventFinancials[$e->id] = [
                    'org_available'      => $f['available_saldo'],
                    'org_net'            => $f['net_revenue'],
                    'org_withdrawn'      => $f['withdrawn_approved'],
                    'org_pending'        => $f['withdrawn_pending'],
                    'platform_income'    => $f['total_platform_income'],
                    'platform_recorded'  => $f['platform_withdrawn'],
                    'platform_available' => $f['platform_available'],
                ];
            }
        }

        $availableSaldo = $event ? $event->available_saldo : 0;
        $withdrawals = $event ? $event->withdrawals()->latest()->get() : collect();

        return view('admin.withdrawals.create', compact('event', 'events', 'availableSaldo', 'withdrawals', 'eventFinancials'));
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
            return redirect()->route('admin.events.withdrawals.show', $event)->with('success', 'Withdrawal recorded and approved successfully.');
        }

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal recorded and approved successfully.');
    }

    public function storePlatformWithdrawal(Request $request, Event $event)
    {
        $financial = $event->calculateFinancialBreakdown();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $financial['platform_available'],
            'note'   => 'nullable|string|max:500',
        ]);

        $event->platformWithdrawals()->create($validated);

        return redirect()->route('admin.events.withdrawals.show', $event)
            ->with('success', 'Platform revenue recorded successfully.');
    }

    public function destroyPlatformWithdrawal(PlatformWithdrawal $platformWithdrawal)
    {
        $event = $platformWithdrawal->event;
        $platformWithdrawal->delete();

        return redirect()->route('admin.events.withdrawals.show', $event)
            ->with('success', 'Platform withdrawal record deleted.');
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
