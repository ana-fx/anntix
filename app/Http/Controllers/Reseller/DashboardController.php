<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dummy data for reseller dashboard
        $stats = [
            'total_sales' => \App\Models\Transaction::where('reseller_id', auth()->id())->where('status', 'paid')->sum('total_price'),
            'total_commission' => 0, // Implement commission logic later if needed
            'active_events' => auth()->user()->resellerEvents()->where('status', 'active')->count(),
            'tickets_sold' => \App\Models\Transaction::where('reseller_id', auth()->id())->where('status', 'paid')->sum('quantity'),
        ];

        $events = auth()->user()->resellerEvents()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->get();

        return view('reseller.dashboard', compact('stats', 'events'));
    }
}
