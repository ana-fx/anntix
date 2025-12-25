<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Basic Stats within Date Range
        $totalRevenue = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total_price');

        $ticketsSold = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('quantity');

        $totalTransactions = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        // Revenue by Event
        $revenueByEvent = Transaction::where('transactions.status', 'paid')
            ->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->join('events', 'transactions.event_id', '=', 'events.id')
            ->select('events.name', DB::raw('SUM(transactions.total_price) as total_revenue'), DB::raw('SUM(transactions.quantity) as total_tickets'))
            ->groupBy('events.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Daily Revenue Chart Data
        $dailyRevenue = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare chart data format
        $chartDates = $dailyRevenue->pluck('date');
        $chartRevenue = $dailyRevenue->pluck('revenue');

        // Detailed Transactions
        $transactions = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with('event:id,name')
            ->latest()
            ->paginate(20, ['*'], 'transactions_page');

        return view('admin.reports.index', compact(
            'totalRevenue',
            'ticketsSold',
            'totalTransactions',
            'revenueByEvent',
            'startDate',
            'endDate',
            'chartDates',
            'chartRevenue',
            'dailyRevenue',
            'transactions'
        ));
    }
}
