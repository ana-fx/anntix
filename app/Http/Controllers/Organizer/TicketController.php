<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function allTickets()
    {
        $organizerEvents = Event::where('organizer_id', Auth::id())->pluck('id');
        $handlingFeeValue = (int) \App\Models\Setting::getValue('handling_fee', 0);

        $tickets = Ticket::whereIn('event_id', $organizerEvents)
            ->with(['event'])
            ->withSum(['transactions as online_qty_paid' => function($q) {
                $q->where('status', 'paid')->whereNull('reseller_id');
            }], 'quantity')
            ->withSum(['transactions as reseller_qty_paid' => function($q) {
                $q->where('status', 'paid')->whereNotNull('reseller_id');
            }], 'quantity')
            ->withSum(['transactions as transactions_sum_quantity_paid' => function($q) {
                $q->where('status', 'paid');
            }], 'quantity')
            ->withSum(['transactions as transactions_sum_quantity_pending' => function($q) {
                $q->where('status', 'pending')->where('created_at', '>=', now()->subDay());
            }], 'quantity')
            ->latest()
            ->paginate(15);

        return view('organizer.tickets.all', compact('tickets', 'handlingFeeValue'));
    }

    protected function authorizeEvent(Event $event)
    {
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'You do not own this event.');
        }
    }

    public function index(Event $event)
    {
        $this->authorizeEvent($event);

        $query = $event->tickets()->withTrashed()
            ->withSum([
                'transactions as online_qty_paid' => function ($query) {
                    $query->where('status', 'paid')->whereNull('reseller_id');
                }
            ], 'quantity')
            ->withSum([
                'transactions as reseller_qty_paid' => function ($query) {
                    $query->where('status', 'paid')->whereNotNull('reseller_id');
                }
            ], 'quantity')
            ->withSum([
                'transactions as online_total_paid' => function ($query) {
                    $query->where('status', 'paid')->whereNull('reseller_id');
                }
            ], 'total_price')
            ->withSum([
                'transactions as reseller_total_paid' => function ($query) {
                    $query->where('status', 'paid')->whereNotNull('reseller_id');
                }
            ], 'total_price')
            ->withSum([
                'transactions as transactions_sum_quantity_paid' => function ($query) {
                    $query->where('status', 'paid');
                }
            ], 'quantity')
            ->latest();

        $tickets = (clone $query)->get();
        // Pre-set event relation on each ticket to avoid N+1 in Blade when calling getHandlingFee()
        $tickets->each(fn($t) => $t->setRelation('event', $event));
        $allTickets = $tickets;

        $recentSales = $event->transactions()
            ->where('status', 'paid')
            ->with('ticket')
            ->latest()
            ->take(10)
            ->get();

        // Calculate Global Totals for this Event
        $totalTicketRevenue = 0;
        foreach ($event->tickets()->withTrashed()->get() as $t) {
            $qPaid = $t->transactions()->where('status', 'paid')->sum('quantity');
            $totalTicketRevenue += ($qPaid * $t->price);
        }

        $totalSaldo = $event->calculateSaldo();
        $totalWithdrawn = $event->total_withdrawn;
        $availableSaldo = $event->available_saldo;

        // Calculate Platform Revenue (Organizer Fees + Handling Fees + Service Fees + Midtrans Fees)
        $totalOrgTax = 0;
        $totalHandling = 0;
        $totalServiceFee = 0;
        $totalMidtrans = 0;

        foreach ($event->tickets()->withTrashed()->get() as $t) {
            // Set event relation to avoid N+1 when calling getHandlingFee()
            $t->setRelation('event', $event);

            // Get breakdown (Handling vs Service Fee)
            $breakdown = $t->getFeeBreakdown();
            $unitHandling = $breakdown['handling'];
            $unitService = $breakdown['service'];

            // Original Ticket Sales Logic
            $onlineQty = $t->transactions()->where('status', 'paid')->whereNull('reseller_id')->sum('quantity');
            $resellerQty = $t->transactions()->where('status', 'paid')->whereNotNull('reseller_id')->sum('quantity');

            // For Online Transactions only
            $onlineTransactions = $t->transactions()->where('status', 'paid')->whereNull('reseller_id')->get();

            foreach ($onlineTransactions as $trans) {
                $qty = $trans->quantity;
                $ticketSales = $qty * $t->price;
                $platformFees = $qty * ($unitHandling + $unitService);

                // Midtrans Fee = Selisih Total Bayar
                $transMidtrans = max(0, (float)$trans->total_price - ($ticketSales + $platformFees));

                $totalMidtrans += $transMidtrans;
                $totalHandling += ($qty * $unitHandling);
                $totalServiceFee += ($qty * $unitService);
            }

            // Organizer Tax Calculation
            $onlineFeeType = $t->organizer_fee_online_type ?? $event->organizer_fee_online_type;
            $onlineFeeValue = $t->organizer_fee_online ?? $event->organizer_fee_online;

            $onlinePlatformFee = $onlineFeeType === 'percent'
                ? $t->price * ($onlineFeeValue / 100)
                : $onlineFeeValue;

            $resellerFeeType = $t->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type;
            $resellerFeeValue = $t->organizer_fee_reseller ?? $event->organizer_fee_reseller;

            $resellerPlatformFee = $resellerFeeType === 'percent'
                ? $t->price * ($resellerFeeValue / 100)
                : $resellerFeeValue;

            $totalOrgTax += ($onlineQty * $onlinePlatformFee) + ($resellerQty * $resellerPlatformFee);
        }
        $totalPlatformRevenue = $totalOrgTax + $totalHandling + $totalServiceFee + $totalMidtrans;

        return view('organizer.tickets.index', compact(
            'event',
            'tickets',
            'recentSales',
            'totalTicketRevenue',
            'totalOrgTax',
            'totalHandling',
            'totalServiceFee',
            'totalMidtrans',
            'totalSaldo',
            'totalWithdrawn',
            'availableSaldo',
            'totalPlatformRevenue',
            'allTickets'
        ));
    }

    public function create(Event $event)
    {
        $this->authorizeEvent($event);
        return view('organizer.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'price'                 => 'required|numeric|min:0',
            'quota'                 => 'required|integer|min:1',
            'max_purchase_per_user' => 'required|integer|min:1',
            'max_scans'             => 'required|integer|min:1',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after:start_date',
            'description'           => 'nullable|string',
            'is_active'             => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['event_id'] = $event->id;

        Ticket::create($validated);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Ticket created successfully!');
    }

    public function edit(Event $event, Ticket $ticket)
    {
        $this->authorizeEvent($event);
        return view('organizer.tickets.edit', compact('event', 'ticket'));
    }

    public function update(Request $request, Event $event, Ticket $ticket)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'price'                 => 'required|numeric|min:0',
            'quota'                 => 'required|integer|min:1',
            'max_purchase_per_user' => 'required|integer|min:1',
            'max_scans'             => 'required|integer|min:1',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after:start_date',
            'description'           => 'nullable|string',
            'is_active'             => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $ticket->update($validated);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Ticket updated successfully!');
    }

    public function destroy(Event $event, Ticket $ticket)
    {
        $this->authorizeEvent($event);
        $ticket->delete();
        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Ticket deleted.');
    }
}
