<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TransactionScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScannerManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $scanners = User::where('role', 'scanner')
            ->withCount('scannerScans')
            ->with(['scannerScans' => function($query) {
                $query->latest()->limit(1);
            }])
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.scanners.management', compact('scanners'));
    }

    public function show(User $scanner, Request $request)
    {
        if ($scanner->role !== 'scanner') {
            abort(404);
        }

        $search = $request->input('search');

        $scans = $scanner->scannerScans()
            ->with(['transaction.event', 'transaction.ticket'])
            ->when($search, function($query, $search) {
                $query->whereHas('transaction', function($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhereHas('event', function($e) use ($search) {
                          $e->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(20);

        return view('admin.scanners.scanner-detail', compact('scanner', 'scans'));
    }
}
