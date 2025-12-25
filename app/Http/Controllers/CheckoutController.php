<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

use App\Models\Transaction;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $event->load('ticket');

        if (!$event->ticket) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Tickets are not available for this event.');
        }

        return view('checkout.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . ($event->ticket->max_purchase_per_user ?? 5),
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[\d\+\-\s]+$/|min:10|max:20',
            'city' => 'required|string|max:255',
            'nik' => 'required|digits:16|numeric',
            'gender' => 'required|in:male,female',
        ]);

        $totalPrice = $event->ticket->price * $validated['quantity'];

        $transaction = Transaction::create([
            'code' => 'TRX-' . strtoupper(Str::random(10)), // Simplified code
            'event_id' => $event->id,
            'ticket_id' => $event->ticket->id,
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

        // Here we would normally redirect to payment gateway
        // For now, redirect home with success

        return redirect()->route('payment.show', $transaction->code);
    }
}
