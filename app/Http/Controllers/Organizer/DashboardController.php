<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Stats Cards (Scoped to Organizer)
        $eventIds = Event::where('organizer_id', $user->id)->pluck('id');

        $totalRevenue = Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->sum('total_price');

        $ticketsSold = Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->sum('quantity');

        $activeEvents = Event::where('organizer_id', $user->id)
            ->where(function ($query) {
                $query->where('start_date', '>=', now())
                    ->orWhere('end_date', '>=', now());
            })->count();

        // Count resellers who have sold tickets for this organizer's events
        $totalResellers = Transaction::whereIn('event_id', $eventIds)
            ->whereNotNull('reseller_id')
            ->where('status', 'paid')
            ->distinct('reseller_id')
            ->count('reseller_id');

        // 2. Chart Data: Daily Revenue (Last 30 Days)
        $dailyRevenue = Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(\Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'), \Illuminate\Support\Facades\DB::raw('SUM(total_price) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $dailyRevenue->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
        $chartData = $dailyRevenue->pluck('revenue');

        // 3. Recent Transactions
        $recentTransactions = Transaction::with(['event', 'reseller'])
            ->whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->latest()
            ->limit(5)
            ->get();

        // Legacy/Existing Dashboard Data for "My Events" table if still needed
        $recentEvents = Event::where('organizer_id', $user->id)
            ->withCount(['tickets', 'transactions' => fn($q) => $q->where('status', 'paid')])
            ->latest()
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'totalResellers',
            'chartLabels',
            'chartData',
            'recentTransactions',
            'recentEvents'
        ));
    }
}
