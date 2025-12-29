<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentRequired;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $event->load([
            'tickets' => function ($query) {
                $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->orderBy('price', 'asc');
            }
        ]);

        if ($event->tickets->isEmpty()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'No tickets are currently available for this event.');
        }

        return view('checkout.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[\d\+\-\s]+$/|min:10|max:20',
            'city' => 'required|string|max:255',
            'nik' => 'required|digits:16|numeric',
            'gender' => 'required|in:male,female',
        ]);

        $ticket = $event->tickets()->findOrFail($validated['ticket_id']);

        // Validate Max Purchase
        if ($validated['quantity'] > $ticket->max_purchase_per_user) {
            return back()->withErrors(['quantity' => 'Max purchase for this ticket is ' . $ticket->max_purchase_per_user]);
        }

        // Validate Quota
        if ($ticket->quota < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough tickets available.']);
        }

        $handlingFee = (int) \App\Models\Setting::getValue('handling_fee', 0);
        $totalPrice = ($ticket->price * $validated['quantity']) + $handlingFee;

        $transaction = Transaction::create([
            'code' => 'ANNTIX-' . strtoupper(Str::random(10)),
            'event_id' => $event->id,
            'ticket_id' => $ticket->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'nik' => $validated['nik'],
            'gender' => $validated['gender'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Send Payment Required Email
        try {
            Mail::to($transaction->email)->send(new PaymentRequired($transaction));
        } catch (\Exception $e) {
            // Log error but continue to payment
            logger()->error('Failed to send payment required email: ' . $e->getMessage());
        }

        return redirect()->route('payment.show', $transaction->code);
    }
}
