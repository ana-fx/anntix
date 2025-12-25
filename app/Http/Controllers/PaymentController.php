<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Transaction $transaction)
    {
        // Ensure transaction belongs to the user or valid session? 
        // For public guest checkout, we might assume the UUID/code path is enough securely obscure for now.

        // Ensure Snap Token exists or generate it
        if (!$transaction->snap_token && $transaction->status === 'pending') {

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->code,
                    'gross_amount' => (int) $transaction->total_price,
                ],
                'customer_details' => [
                    'first_name' => $transaction->name,
                    'email' => $transaction->email,
                    'phone' => $transaction->phone,
                    'billing_address' => [
                        'first_name' => $transaction->name,
                        'phone' => $transaction->phone,
                        'address' => $transaction->city,
                        'city' => $transaction->city,
                    ],
                ],
                'item_details' => [
                    [
                        'id' => $transaction->ticket_id,
                        'price' => (int) $transaction->ticket->price,
                        'quantity' => $transaction->quantity,
                        'name' => $transaction->ticket->name,
                    ]
                ]
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return back()->with('error', 'Payment gateway error: ' . $e->getMessage());
            }
        }

        return view('payment.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Validate incoming data from frontend (midtrans result)
        // Note: In production, rely on Webhooks for security. This is for immediate UI update.

        $transaction->update([
            'status' => 'paid',
            'payment_type' => $request->payment_type,
            'midtrans_transaction_id' => $request->transaction_id,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function success(Transaction $transaction)
    {
        // Simple success page
        return view('payment.success', compact('transaction'));
    }
}
