<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ResellerManagementController extends Controller
{
    public function index()
    {
        $resellers = User::where('role', 'reseller')
            ->where(function ($query) {
                $query->where('created_by', Auth::id())
                    ->orWhereHas('resellerEvents', function ($q) {
                        $q->where('organizer_id', Auth::id());
                    });
            })
            ->withSum([
                'resellerTransactions as total_sales_sum' => function ($query) {
                    $query->where('status', 'paid')
                        ->whereIn('event_id', Auth::user()->organizerEvents()->pluck('id'));
                }
            ], 'total_price')
            ->withSum([
                'deposits as total_deposit_sum' => function ($query) {
                    $query->where('created_by', Auth::id());
                }
            ], 'amount')
            ->latest()
            ->paginate(10);

        return view('organizer.reseller-management.index', compact('resellers'));
    }
}
