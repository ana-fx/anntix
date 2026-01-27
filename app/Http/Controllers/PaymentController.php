<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccess;
use App\Mail\PaymentRequired;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function show(Transaction $transaction)
    {
        // Send Payment Required email if pending, not a reseller transaction, and not already sent in this session
        if (!$transaction->reseller_id && $transaction->status === 'pending' && !session()->has('payment_mail_sent_' . $transaction->id)) {
            try {
                Mail::to($transaction->email)->send(new PaymentRequired($transaction));
                session()->put('payment_mail_sent_' . $transaction->id, true);
            } catch (\Exception $e) {
                logger()->error('Failed to send payment required email from payment page: ' . $e->getMessage());
            }
        }

        return view('payment.show', compact('transaction'));
    }

    public function generateToken(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,bank_transfer,gopay',
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // Fees from Settings
        $handlingFee = (int) \App\Models\Setting::getValue('handling_fee', 0);
        $qrisFeePercent = (float) \App\Models\Setting::getValue('fee_qris_percent', 0); // e.g. 0.7
        $bankFeeFixed = (int) \App\Models\Setting::getValue('fee_bank_fixed', 0);

        $subtotal = $transaction->ticket->price * $transaction->quantity;
        $baseTotal = $subtotal + ($handlingFee * $transaction->quantity);

        // No manual fee calculation - Midtrans handles it automatically
        // Show only GoPay (QRIS included) and Bank Transfer options
        $enabledPayments = ['gopay', 'qris', 'other_qris', 'bni_va', 'bri_va', 'echannel', 'permata_va', 'cimb_va'];

        // Update Transaction with base total (Midtrans adds fee automatically)
        $transaction->update([
            'total_price' => $baseTotal,
        ]);

        // Build Details
        $itemDetails = [
            [
                'id' => $transaction->ticket_id,
                'price' => (int) $transaction->ticket->price,
                'quantity' => $transaction->quantity,
                'name' => substr($transaction->ticket->name, 0, 50),
            ]
        ];

        if ($handlingFee > 0) {
            $itemDetails[] = [
                'id' => 'HANDLING-FEE',
                'price' => $handlingFee,
                'quantity' => $transaction->quantity,
                'name' => 'Handling Fee',
            ];
        }

        // No payment fee in item_details - Midtrans adds it automatically

        // Build parameters with automatic fee imposition
        // Midtrans will automatically calculate and add MDR fees
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code . '-' . time(),
                'gross_amount' => (int) $baseTotal, // Base amount WITHOUT manual fee
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
            ],
            'item_details' => $itemDetails, // Only ticket + handling fee
            'enabled_payments' => $enabledPayments,
            'expiry' => [
                'unit' => 'day',
                'duration' => 1,
            ],
            // Enable automatic fee imposition - Midtrans calculates the fee
            'customer_imposed_payment_fee' => [
                'enable' => true,
                'payment_fee_configs' => [
                    [
                        'payment_type' => 'gopay',
                        'customer_percentage' => 100
                    ],


                    [
                        'payment_type' => 'bni_va',
                        'customer_percentage' => 100
                    ],
                    [
                        'payment_type' => 'bri_va',
                        'customer_percentage' => 100
                    ],
                    [
                        'payment_type' => 'echannel', // Mandiri
                        'customer_percentage' => 100
                    ],
                    [
                        'payment_type' => 'permata_va',
                        'customer_percentage' => 100
                    ],
                    [
                        'payment_type' => 'cimb_va',
                        'customer_percentage' => 100
                    ],
                ]
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'handling_fee' => $handlingFee,
                'base_total' => $baseTotal, // Midtrans will add MDR fee automatically
                'message' => 'Midtrans will automatically calculate payment fees'
            ]);
        } catch (\Exception $e) {
            logger()->error('Midtrans Snap Error: ' . $e->getMessage(), [
                'params' => $params,
                'transaction_code' => $transaction->code
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Validate incoming data from frontend (midtrans result)
        // Note: In production, rely on Webhooks for security. This is for immediate UI update.

        if ($transaction->status !== 'paid') {
            $transaction->update([
                'status' => 'paid',
                'payment_type' => $request->payment_type,
                'midtrans_transaction_id' => $request->transaction_id,
            ]);

            // Send Ticket Confirmation Email
            try {
                Mail::to($transaction->email)->send(new PaymentSuccess($transaction));
            } catch (\Exception $e) {
                logger()->error('Failed to send payment success email: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function resellerComplete(Request $request, Transaction $transaction)
    {
        // 1. Authorization
        if (!Auth::check() || Auth::id() !== $transaction->reseller_id) {
            abort(403, 'Unauthorized. Only the assigned reseller can confirm this payment.');
        }

        /** @var \App\Models\User $reseller */
        $reseller = Auth::user();

        // 2. Mark as Paid
        if ($transaction->status !== 'paid') {
            // Check balance check removed as per request to allow negative balance/credit

            DB::transaction(function () use ($transaction, $reseller) {
                // Deduct balance
                $reseller->decrement('balance', $transaction->total_price);

                // Update transaction
                $transaction->update([
                    'status' => 'paid',
                    'payment_type' => 'reseller_deposit',
                    'midtrans_transaction_id' => 'RES-' . strtoupper(\Illuminate\Support\Str::random(10)),
                ]);
            });

            // 3. Send Email
            try {
                Mail::to($transaction->email)->send(new PaymentSuccess($transaction));
            } catch (\Exception $e) {
                logger()->error('Failed to send payment success email: ' . $e->getMessage());
            }
        }

        // 4. Redirect to Success
        return redirect()->route('payment.success', $transaction->code);
    }

    public function success(Transaction $transaction)
    {
        // Guard: Redirect if not paid
        if ($transaction->status !== 'paid') {
            return redirect()->route('payment.show', $transaction->code)
                ->with('error', 'Please complete your payment first.');
        }

        // Simple success page
        return view('payment.success', compact('transaction'));
    }

    public function notification(Request $request)
    {
        // 1. Configure Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Parse Order ID: ANNTIX-RANDOM-TIMESTAMP
        // We need to extract ANNTIX-RANDOM

        $parts = explode('-', $order_id);
        // Assuming format is ANNTIX-RANDOMSTRING-TIMESTAMP (3 parts)
        // OR ANNTIX-RANDOMSTRING (2 parts, old format)
        // Let's rely on finding the DB record that matches the code prefix

        $code = $parts[0] . '-' . $parts[1];

        $trx = Transaction::where('code', $code)->first();

        if (!$trx) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $trx->update(['status' => 'pending']);
            } else {
                $this->markAsPaid($trx, $type, $order_id);
            }
        } else if ($transaction == 'settlement') {
            $this->markAsPaid($trx, $type, $order_id);
        } else if ($transaction == 'pending') {
            $trx->update(['status' => 'pending']);
        } else if ($transaction == 'deny') {
            $trx->update(['status' => 'failed']);
        } else if ($transaction == 'expire') {
            $trx->update(['status' => 'expired']);
        } else if ($transaction == 'cancel') {
            $trx->update(['status' => 'canceled']);
        }

        return response()->json(['status' => 'ok']);
    }

    private function markAsPaid(Transaction $trx, $type, $midtransId)
    {
        if ($trx->status !== 'paid') {
            $trx->update([
                'status' => 'paid',
                'payment_type' => $type,
                'midtrans_transaction_id' => $midtransId,
            ]);

            try {
                Mail::to($trx->email)->send(new PaymentSuccess($trx));
            } catch (\Exception $e) {
            }
        }
    }
}
