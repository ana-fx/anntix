<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function index()
    {
        return view('scanner.index');
    }

    public function verify(Request $request)
    {
        if (\App\Models\Setting::getValue('local_server_mode', '0') === '1') {
            return response()->json([
                'status' => 'error',
                'message' => 'Scanner is disabled on this server. Please use the Local Server for scanning.'
            ], 403);
        }

        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->code;

        // Extract code from URL if it's a full URL
        if (filter_var($code, FILTER_VALIDATE_URL)) {
            if (str_contains($code, '/payment/success/')) {
                $segments = explode('/', parse_url($code, PHP_URL_PATH));
                $code = end($segments);
            }
            elseif (str_contains($code, '/payment/')) {
                $segments = explode('/', parse_url($code, PHP_URL_PATH));
                $code = end($segments);
            }
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check withTrashed to find voided/deleted tickets
        $transaction = Transaction::where('code', $code)->withTrashed()->with('ticket.event')->first();

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ticket code.'
            ], 404);
        }

        // Check if ticket is voided (soft deleted)
        if ($transaction->trashed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'TICKET VOID / HANGUS.'
            ], 400);
        }

        $eventId = $transaction->ticket->event_id;

        // Verify the scanner is assigned to THIS ticket's event
        if (!$user->scannedEvents()->where('events.id', $eventId)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to scan for this event: ' . $transaction->ticket->event->name
            ], 403);
        }


        if ($transaction->status !== 'paid') {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket is not paid (' . $transaction->status . ').'
            ], 400);
        }

        $scanCount = $transaction->scans()->count();
        $maxScans = $transaction->ticket->max_scans;
        $remainingScans = max(0, $maxScans - $scanCount);

        // Check if fully redeemed
        $alreadyRedeemed = $scanCount >= $maxScans;

        // Get scanner information for the latest scan (if any)
        $latestScan = $transaction->scans()->latest()->first();
        $scannedBy = null;
        if ($latestScan && $latestScan->scanner) {
            $scannedBy = $latestScan->scanner->name;
        }

        $nextScan = $scanCount + 1;
        $message = $alreadyRedeemed
            ? "Ticket sudah di claim sepenuhnya ({$scanCount}/{$maxScans})"
            : "Ticket day {$nextScan} siap di claim";

        return response()->json([
            'status' => $alreadyRedeemed ? 'warning' : 'pending',
            'message' => $message,
            'already_redeemed' => $alreadyRedeemed,
            'data' => [
                'transaction_id' => $transaction->id,
                'code' => $transaction->code,
                'name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
                'city' => $transaction->city,
                'nik' => $transaction->nik,
                'gender' => $transaction->gender,
                'event_name' => $transaction->ticket->event->name,
                'ticket_type' => $transaction->ticket->name,
                'quantity' => $transaction->quantity,
                'redeemed_at' => $latestScan ? $latestScan->created_at->format('d M Y, H:i:s') : null,
                'scanned_by' => $scannedBy,
                'max_scans' => $maxScans,
                'scan_count' => $scanCount,
            ]
        ]);
    }

    public function redeem(Request $request)
    {
        if (\App\Models\Setting::getValue('local_server_mode', '0') === '1') {
            return response()->json([
                'status' => 'error',
                'message' => 'Scanner is disabled on this server. Please use the Local Server for scanning.'
            ], 403);
        }

        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        $eventId = $transaction->ticket->event_id;

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verify scanner authorization for this event
        if (!$user->scannedEvents()->where('events.id', $eventId)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized for this event.'
            ], 403);
        }

        // Check max scans
        $scanCount = $transaction->scans()->count();
        $maxScans = $transaction->ticket->max_scans;

        if ($scanCount >= $maxScans) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket has reached maximum allowed scans (' . $maxScans . ').'
            ], 400);
        }

        // Ensure ticket is strictly PAID
        if ($transaction->status !== 'paid') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot redeem: Ticket status is ' . $transaction->status
            ], 400);
        }

        // Record the scan
        $scan = $transaction->scans()->create([
            'scanned_by' => Auth::id(),
        ]);

        // Update legacy redeemed_at/by to latest scan for compatibility with old reports
        $transaction->redeemed_at = now();
        $transaction->redeemed_by = Auth::id();
        $transaction->save();

        $newScanCount = $scanCount + 1;
        $remainingScans = max(0, $maxScans - $newScanCount);

        return response()->json([
            'status' => 'success',
            'message' => "Ticket day {$newScanCount} berhasil di claim",
            'data' => [
                'redeemed_at' => $scan->created_at->format('H:i:s'),
                'scan_count' => $newScanCount,
                'max_scans' => $maxScans,
            ]
        ]);
    }

    public function history()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $todayScansCount = $user->scannerScans()
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $scans = $user->scannerScans()
            ->with(['transaction.ticket.event'])
            ->latest()
            ->paginate(20);

        return view('scanner.history', compact('scans', 'todayScansCount'));
    }
}
