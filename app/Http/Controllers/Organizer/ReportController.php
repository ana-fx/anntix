<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $organizerEvents = Event::where('organizer_id', Auth::id())->pluck('id');

        if ($organizerEvents->isEmpty()) {
            return view('organizer.reports.index', [
                'totalRevenue' => 0,
                'ticketsSold' => 0,
                'ticketsRedeemed' => 0,
                'totalTransactions' => 0,
                'revenueByEvent' => collect(),
                'startDate' => $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d')),
                'endDate' => $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d')),
                'chartDates' => collect(),
                'chartRevenue' => collect(),
                'dailyRevenue' => collect()
            ]);
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Basic Stats within Date Range
        $totalRevenue = Transaction::where('status', 'paid')
            ->whereIn('event_id', $organizerEvents)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total_price');

        $ticketsSold = Transaction::where('status', 'paid')
            ->whereIn('event_id', $organizerEvents)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('quantity');

        $totalTransactions = Transaction::where('status', 'paid')
            ->whereIn('event_id', $organizerEvents)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        // Revenue by Event
        $revenueByEvent = Transaction::where('transactions.status', 'paid')
            ->whereIn('transactions.event_id', $organizerEvents)
            ->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->join('events', 'transactions.event_id', '=', 'events.id')
            ->select('events.name', DB::raw('SUM(transactions.total_price) as total_revenue'), DB::raw('SUM(transactions.quantity) as total_tickets'))
            ->groupBy('events.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Daily Revenue Chart Data
        $dailyRevenue = Transaction::where('status', 'paid')
            ->whereIn('event_id', $organizerEvents)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare chart data format
        $chartDates = $dailyRevenue->pluck('date');
        $chartRevenue = $dailyRevenue->pluck('revenue');

        // Scanned Stats within Date Range
        $ticketsRedeemed = Transaction::whereNotNull('redeemed_at')
            ->whereIn('event_id', $organizerEvents)
            ->whereBetween('redeemed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('quantity');

        return view('organizer.reports.index', compact(
            'totalRevenue',
            'ticketsSold',
            'ticketsRedeemed',
            'totalTransactions',
            'revenueByEvent',
            'startDate',
            'endDate',
            'chartDates',
            'chartRevenue',
            'dailyRevenue'
        ));
    }

    public function transactions(Request $request)
    {
        $organizerEvents = Event::where('organizer_id', Auth::id())->pluck('id');

        $search = $request->input('search');
        $status = $request->input('status');
        $eventId = $request->input('event_id');

        $query = Transaction::whereIn('event_id', $organizerEvents)
            ->with(['event:id,name', 'ticket:id,name,price'])
            ->latest();

        if ($eventId) {
            $query->where('event_id', $eventId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($request->has('source')) {
            if ($request->source === 'reseller') {
                $query->whereNotNull('reseller_id');
            } elseif ($request->source === 'online') {
                $query->whereNull('reseller_id');
            }
        }

        $transactions = $query->paginate(15)->withQueryString();
        $handlingFeeValue = (int) \App\Models\Setting::getValue('handling_fee', 0);

        return view('organizer.reports.transactions', compact('transactions', 'handlingFeeValue'));
    }

    public function showTransaction(Transaction $transaction)
    {
        // Guard: Ensure transaction belongs to organizer's event
        if ($transaction->event->organizer_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load(['event', 'ticket', 'logs.user', 'scans.scanner']);
        $handlingFeeValue = (int) \App\Models\Setting::getValue('handling_fee', 0);

        $ticketSales = $transaction->quantity * ($transaction->ticket->price ?? 0);
        $handlingTotal = $transaction->quantity * $handlingFeeValue;
        $serviceFee = (float) $transaction->total_price - ($ticketSales + $handlingTotal);
        if ($serviceFee < 0)
            $serviceFee = 0;

        return view('organizer.reports.transaction-show', compact('transaction', 'serviceFee', 'handlingTotal'));
    }

}
