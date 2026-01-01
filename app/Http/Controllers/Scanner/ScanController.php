<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function index()
    {
        // Get events assigned to this scanner
        $events = Auth::user()->scannedEvents()
            ->where('end_date', '>=', now())
            ->get();

        return view('scanner.index', compact('events'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        $code = $request->code;
        $eventId = $request->event_id;

        // Verify the scanner is assigned to this event
        if (!Auth::user()->scannedEvents()->where('events.id', $eventId)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to scan for this event.'
            ], 403);
        }

        // Find transaction/ticket by code
        // Assuming the 'code' corresponds to a transaction code or a specific ticket identifier.
        // For simplicity, let's assume transaction code for now, or we might need a unique ticket code if single transaction has multiple tickets.
        // But usually, anntix likely generates a code per transaction or per ticket.
        // Let's check Transaction model to see if it has 'code'.
        $transaction = Transaction::where('code', $code)->first();

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ticket code.'
            ], 404);
        }

        // Check if transaction belongs to the event (via ticket relationship usually)
        if ($transaction->ticket->event_id != $eventId) {
            return response()->json([
                'status' => 'error',
                'message' => 'This ticket does not belong to the selected event.'
            ], 400);
        }

        if ($transaction->status !== 'paid') {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket is not paid (' . $transaction->status . ').'
            ], 400);
        }

        if ($transaction->redeemed_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket already scanned at ' . $transaction->redeemed_at->format('H:i:s')
            ], 400);
        }

        // Mark as redeemed
        $transaction->redeemed_at = now();
        $transaction->redeemed_by = Auth::id();
        $transaction->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket verified successfully!',
            'data' => [
                'code' => $transaction->code,
                'name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
                'city' => $transaction->city,
                'nik' => $transaction->nik,
                'gender' => $transaction->gender,
                'ticket_type' => $transaction->ticket->name,
                'quantity' => $transaction->quantity,
                'redeemed_at' => $transaction->redeemed_at->format('H:i:s'),
            ]
        ]);
    }
}
