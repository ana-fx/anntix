<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccess;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function show(Transaction $transaction)
    {
        // Guard: Check transaction status and redirect accordingly
        $redirectResponse = match ($transaction->status) {
            'paid' => redirect()->route('payment.success', $transaction->code),
            'failed', 'expired', 'canceled' => redirect()->route('home')->with('error', 'This transaction is ' . $transaction->status . '.'),
            'pending' => !$transaction->ticket->is_active
            ? redirect()->route('home')->with('error', 'Maaf, tipe tiket untuk transaksi ini sudah tidak tersedia.')
            : null,
            default => null,
        };

        if ($redirectResponse) {
            return $redirectResponse;
        }

        return view('payment.show', compact('transaction'));
    }

    public function generateToken(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,bank_transfer',
        ]);

        if ($transaction->status !== 'pending') {
            return response()->json(['error' => 'Transaction cannot be processed (Status: ' . $transaction->status . ')'], 400);
        }

        if (!$transaction->ticket->is_active) {
            return response()->json(['error' => 'Maaf, tipe tiket ini sudah tidak tersedia.'], 400);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // Fees from Ticket Settings (ticket-level > event-level > global fallback)
        $unitPrice = $transaction->ticket->price;
        $handlingFeePerUnit = (int) $transaction->ticket->getHandlingFee();

        $subtotal = $unitPrice * $transaction->quantity;
        $baseTotal = $subtotal + ($handlingFeePerUnit * $transaction->quantity);

        $finalTotal = $baseTotal;
        $enabledPayments = [];
        $customerImposedFeeConfig = [];

        $itemDetails = [
            [
                'id' => $transaction->ticket_id,
                'price' => (int) $transaction->ticket->price,
                'quantity' => $transaction->quantity,
                'name' => substr($transaction->ticket->name, 0, 50),
            ]
        ];

        if ($handlingFeePerUnit > 0) {
            $itemDetails[] = [
                'id' => 'HANDLING-FEE',
                'price' => $handlingFeePerUnit,
                'quantity' => $transaction->quantity,
                'name' => 'Handling Fee',
            ];
        }

        // --- SPLIT LOGIC ---
        if ($request->payment_method === 'qris') {
            // MANUAL FEE CALCULATION FOR QRIS
            // Adds fee manually to total to bypass API limitation for other_qris

            $qrisFeePercent = 0.7; // 0.7%
            $manualFeeAmount = floor($baseTotal * ($qrisFeePercent / 100));

            if ($manualFeeAmount > 0) {
                $itemDetails[] = [
                    'id' => 'QRIS-FEE',
                    'price' => $manualFeeAmount,
                    'quantity' => 1,
                    'name' => 'QRIS Processing Fee',
                ];
                $finalTotal += $manualFeeAmount;
            }

            // Enable QRIS methods (including other_qris for mobile visibility)
            $enabledPayments = ['qris', 'gopay', 'other_qris'];

            // DISABLE automatic fee config for QRIS
            $customerImposedFeeConfig = [
                'enable' => false,
                'payment_fee_configs' => []
            ];

        } else {
            // BANK TRANSFER (Automatic Fee)
            // Let Midtrans add the fee in popup

            $enabledPayments = ['bni_va', 'bri_va', 'echannel', 'permata_va', 'cimb_va'];

            // ENABLE automatic fee config
            $customerImposedFeeConfig = [
                'enable' => true,
                'payment_fee_configs' => [
                    ['payment_type' => 'bni_va', 'customer_percentage' => 100],
                    ['payment_type' => 'bri_va', 'customer_percentage' => 100],
                    ['payment_type' => 'echannel', 'customer_percentage' => 100],
                    ['payment_type' => 'permata_va', 'customer_percentage' => 100],
                    ['payment_type' => 'cimb_va', 'customer_percentage' => 100],
                ]
            ];
        }

        // Update Transaction
        $transaction->update([
            'total_price' => $finalTotal,
        ]);

        // Build parameters
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code . '-' . time(),
                'gross_amount' => (int) $finalTotal,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
            ],
            'item_details' => $itemDetails,
            'enabled_payments' => $enabledPayments,
            'expiry' => [
                'unit' => 'day',
                'duration' => 1,
            ],
            'customer_imposed_payment_fee' => $customerImposedFeeConfig
        ];

        // Remove customer_imposed_payment_fee if not enabled
        if (!$customerImposedFeeConfig['enable']) {
            unset($params['customer_imposed_payment_fee']);
        }

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'handling_fee' => $handlingFeePerUnit,
                'base_total' => $finalTotal,
                'message' => 'Token generated'
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
                \Illuminate\Support\Facades\Log::info('Payment success email queued from updateStatus', [
                    'transaction_code' => $transaction->code,
                    'email' => $transaction->email,
                    'payment_type' => $request->payment_type
                ]);
            } catch (\Exception $e) {
                logger()->error('Failed to send payment success email from updateStatus: ' . $e->getMessage(), [
                    'transaction_code' => $transaction->code,
                    'email' => $transaction->email
                ]);
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

        if ($transaction->status === 'pending' && !$transaction->ticket->is_active) {
            return redirect()->route('home')->with('error', 'Maaf, tipe tiket untuk transaksi ini sudah tidak tersedia.');
        }

        // 2. Mark as Paid
        if ($transaction->status === 'pending') {
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
                \Illuminate\Support\Facades\Log::info('Payment success email queued from resellerComplete', [
                    'transaction_code' => $transaction->code,
                    'email' => $transaction->email,
                    'reseller_id' => $reseller->id
                ]);
            } catch (\Exception $e) {
                logger()->error('Failed to send payment success email from resellerComplete: ' . $e->getMessage(), [
                    'transaction_code' => $transaction->code,
                    'email' => $transaction->email
                ]);
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
        // Log incoming webhook with full payload
        \Illuminate\Support\Facades\Log::info('🔔 Midtrans Webhook Received', [
            'timestamp' => now()->toDateTimeString(),
            'ip' => $request->ip(),
            'payload' => $request->all()
        ]);

        // 1. Configure Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        try {
            $notif = new \Midtrans\Notification();
            \Illuminate\Support\Facades\Log::info('✅ Midtrans notification parsed successfully');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('❌ Failed to parse Midtrans notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        \Illuminate\Support\Facades\Log::info('📋 Webhook Details', [
            'order_id' => $order_id,
            'transaction_status' => $transaction,
            'payment_type' => $type,
            'fraud_status' => $fraud
        ]);

        // Parse Order ID: ANNTIX-RANDOM-TIMESTAMP
        // We need to extract ANNTIX-RANDOM

        $parts = explode('-', $order_id);

        // Handle different formats:
        // - ANNTIX-RANDOM-TIMESTAMP (3 parts)
        // - ANNTIX-RANDOM (2 parts)
        // - RES-ANNTIX-RANDOM-TIMESTAMP (4 parts for reseller)

        if (count($parts) >= 2) {
            // If starts with RES-, it's a reseller transaction
            if ($parts[0] === 'RES' && count($parts) >= 3) {
                $code = $parts[0] . '-' . $parts[1] . '-' . $parts[2];
            } else {
                $code = $parts[0] . '-' . $parts[1];
            }
        } else {
            \Illuminate\Support\Facades\Log::error('❌ Invalid order_id format', [
                'order_id' => $order_id,
                'parts_count' => count($parts)
            ]);
            return response()->json(['message' => 'Invalid order_id format'], 400);
        }

        \Illuminate\Support\Facades\Log::info('🔍 Searching for transaction', [
            'extracted_code' => $code,
            'original_order_id' => $order_id
        ]);

        $trx = Transaction::where('code', $code)->first();

        if (!$trx) {
            \Illuminate\Support\Facades\Log::error('❌ Transaction not found in database', [
                'code' => $code,
                'order_id' => $order_id
            ]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        \Illuminate\Support\Facades\Log::info('✅ Transaction found', [
            'code' => $trx->code,
            'current_status' => $trx->status,
            'email' => $trx->email
        ]);

        // Process based on transaction status
        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                \Illuminate\Support\Facades\Log::warning('⚠️ Payment challenged', [
                    'code' => $trx->code,
                    'fraud_status' => $fraud
                ]);
                $trx->update(['status' => 'pending']);
            } else {
                \Illuminate\Support\Facades\Log::info('💰 Processing capture payment', [
                    'code' => $trx->code
                ]);
                $this->markAsPaid($trx, $type, $order_id);
            }
        } else if ($transaction == 'settlement') {
            \Illuminate\Support\Facades\Log::info('💰 Processing settlement payment', [
                'code' => $trx->code
            ]);
            $this->markAsPaid($trx, $type, $order_id);
        } else if ($transaction == 'pending') {
            \Illuminate\Support\Facades\Log::info('⏳ Payment pending', [
                'code' => $trx->code
            ]);
            $trx->update(['status' => 'pending']);
        } else if ($transaction == 'deny') {
            \Illuminate\Support\Facades\Log::warning('❌ Payment denied', [
                'code' => $trx->code
            ]);
            $trx->update(['status' => 'failed']);
        } else if ($transaction == 'expire') {
            \Illuminate\Support\Facades\Log::info('⏰ Payment expired', [
                'code' => $trx->code
            ]);
            $trx->update(['status' => 'expired']);
        } else if ($transaction == 'cancel') {
            \Illuminate\Support\Facades\Log::info('🚫 Payment canceled', [
                'code' => $trx->code
            ]);
            $trx->update(['status' => 'canceled']);
        } else {
            \Illuminate\Support\Facades\Log::warning('⚠️ Unknown transaction status', [
                'code' => $trx->code,
                'status' => $transaction
            ]);
        }

        \Illuminate\Support\Facades\Log::info('✅ Webhook processed successfully', [
            'code' => $trx->code,
            'final_status' => $trx->fresh()->status
        ]);

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
                \Illuminate\Support\Facades\Log::info('Payment success email queued', [
                    'transaction_code' => $trx->code,
                    'email' => $trx->email,
                    'payment_type' => $type
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to queue payment success email', [
                    'transaction_code' => $trx->code,
                    'email' => $trx->email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }
}
