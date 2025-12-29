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
            'total_sales' => 0,
            'total_commission' => 0,
            'active_events' => \App\Models\Event::where('status', 'published')->count(),
            'tickets_sold' => 0,
        ];

        return view('reseller.dashboard', compact('stats'));
    }
}
