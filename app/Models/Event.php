<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Added this line
use Illuminate\Database\Eloquent\SoftDeletes; // Added this line

/**
 * @property int $id
 * @property string $organizer_fee_online_type
 * @property float $organizer_fee_online
 * @property string|null $reseller_fee_type
 * @property float|null $reseller_fee_value
 * @property string $organizer_fee_reseller_type
 * @property float $organizer_fee_reseller
 * @property-read float $total_withdrawn
 * @property-read float $available_saldo
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'organizer_id',
        'category',
        'status',
        'banner_path',
        'thumbnail_path',
        'start_date',
        'end_date',
        'description',
        'terms',
        'location',
        'province',
        'city',
        'zip',
        'google_map_embed',
        'seo_title',
        'seo_description',
        'organizer_name',
        'organizer_logo_path',
        'reseller_fee_type',
        'reseller_fee_value',
        'handling_fee_type',
        'handling_fee_value',
        'organizer_fee_online_type',
        'organizer_fee_online',
        'organizer_fee_reseller_type',
        'organizer_fee_reseller',
        'is_online_sales_enabled',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_online_sales_enabled' => 'boolean',
    ];

    public function getHandlingFee($totalTicketPrice)
    {
        if ($this->handling_fee_type === 'percent') {
            return $totalTicketPrice * ($this->handling_fee_value / 100);
        }

        if ($this->handling_fee_type === 'fixed') {
            return $this->handling_fee_value;
        }

        // Default: use global setting
        return (int) \App\Models\Setting::getValue('handling_fee', 0);
    }



    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scanners()
    {
        return $this->belongsToMany(User::class, 'event_scanner', 'event_id', 'user_id')->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function resellers()
    {
        return $this->belongsToMany(User::class, 'event_reseller', 'event_id', 'user_id')->withTimestamps();
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function platformWithdrawals()
    {
        return $this->hasMany(PlatformWithdrawal::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function calculateSaldo()
    {
        // Use a fresh query directly on the tickets table to avoid any cached relationship data
        $tickets = \Illuminate\Support\Facades\DB::table('tickets')
            ->where('event_id', $this->id)
            ->get();

        $totalSaldo = 0;

        foreach ($tickets as $t) {
            // Fetch all paid transactions for this specific ticket
            $paidTransactions = \Illuminate\Support\Facades\DB::table('transactions')
                ->where('ticket_id', $t->id)
                ->where('status', 'paid')
                ->whereNull('deleted_at')
                ->get();

            foreach ($paidTransactions as $trans) {
                $qty = $trans->quantity;
                $isReseller = !empty($trans->reseller_id);

                // 1. Revenue
                $uPrice = isset($trans->unit_price) ? (float) $trans->unit_price : (float) $t->price;
                $revenue = $qty * $uPrice;

                // 2. Platform Fees (Potongan Platform dari Organizer)
                if (isset($trans->unit_price)) {
                    // NEW LOGIC: Use stored organizer_fee
                    $totalPlatformFee = $qty * (float) ($trans->organizer_fee ?? 0);
                } else {
                    // OLD LOGIC: Dynamic fallback
                    if (!$isReseller) {
                        $onlineFeeType = $t->organizer_fee_online_type ?? $this->organizer_fee_online_type;
                        $onlineFeeValue = $t->organizer_fee_online ?? $this->organizer_fee_online;
                        $onlinePlatformFee = ($onlineFeeType === 'percent') ? ($uPrice * ($onlineFeeValue / 100)) : $onlineFeeValue;
                        $totalPlatformFee = $qty * ($onlinePlatformFee ?? 0);
                    } else {
                        $resellerFeeType = $t->organizer_fee_reseller_type ?? $this->organizer_fee_reseller_type;
                        $resellerFeeValue = $t->organizer_fee_reseller ?? $this->organizer_fee_reseller;
                        $resellerPlatformFee = ($resellerFeeType === 'percent') ? ($uPrice * ($resellerFeeValue / 100)) : $resellerFeeValue;
                        $totalPlatformFee = $qty * ($resellerPlatformFee ?? 0);
                    }
                }

                // 3. Final calculation for this transaction
                $totalSaldo += ($revenue - $totalPlatformFee);
            }
        }

        return (float) $totalSaldo;
    }

    public function calculateFinancialBreakdown(): array
    {
        // Fee breakdown:
        // - handling_fee / service_fee : same concept, different levels (global/event/ticket).
        //   Paid by buyer, goes to platform. Never both set at once.
        // - organizer_fee : platform's cut FROM organizer (admin tax). Deducted from organizer net.
        // - reseller_fee  : reseller's commission, paid by buyer to reseller.
        //   No relation to organizer or platform saldo — excluded.
        // - gateway_fee   : Midtrans fee — excluded.
        //
        // Organizer net = unit_price - organizer_fee
        // Platform income per transaction = handling_fee + service_fee + organizer_fee

        $tickets = \Illuminate\Support\Facades\DB::table('tickets')
            ->where('event_id', $this->id)
            ->get();

        $grossRevenue       = 0; // Σ unit_price × qty (ticket revenue only)
        $handlingFees       = 0; // Σ (handling_fee + service_fee) × qty — platform earns from buyer
        $organizerFees      = 0; // Σ organizer_fee × qty — platform earns from organizer
        $onlineRevenue      = 0;
        $resellerRevenue    = 0;
        $onlineTicketsSold  = 0;
        $resellerTicketsSold= 0;

        foreach ($tickets as $t) {
            $paidTransactions = \Illuminate\Support\Facades\DB::table('transactions')
                ->where('ticket_id', $t->id)
                ->where('status', 'paid')
                ->whereNull('deleted_at')
                ->get();

            foreach ($paidTransactions as $trans) {
                $qty         = $trans->quantity;
                $isReseller  = !empty($trans->reseller_id);
                $uPrice      = isset($trans->unit_price) ? (float) $trans->unit_price : (float) $t->price;
                $revenue     = $qty * $uPrice;

                $grossRevenue += $revenue;

                if ($isReseller) {
                    $resellerRevenue      += $revenue;
                    $resellerTicketsSold  += $qty;
                } else {
                    $onlineRevenue        += $revenue;
                    $onlineTicketsSold    += $qty;
                }

                if (isset($trans->unit_price)) {
                    // ── New transactions: all fees are stored per-unit ──────────────
                    // handling_fee and service_fee are mutually exclusive (one is always 0)
                    $handlingFees  += $qty * ((float) ($trans->handling_fee ?? 0) + (float) ($trans->service_fee ?? 0));
                    $organizerFees += $qty * (float) ($trans->organizer_fee ?? 0);
                } else {
                    // ── Legacy transactions: fee columns default to 0, derive dynamically ──
                    // Handling / service fee — online only (resellers have no handling fee)
                    if (!$isReseller) {
                        // Mirror Ticket::getHandlingFee() using raw ticket data
                        $hType  = $t->handling_fee_type  ?? null;
                        $hValue = $t->handling_fee_value ?? null;

                        if (!empty($hType) && $hType !== 'default') {
                            // Ticket-level override
                            $hFee = ($hType === 'percent') ? ($uPrice * ($hValue / 100)) : (float) $hValue;
                        } elseif (!empty($this->handling_fee_type) && $this->handling_fee_type !== 'default') {
                            // Event-level override
                            $eType  = $this->handling_fee_type;
                            $eValue = $this->handling_fee_value;
                            $hFee = ($eType === 'percent') ? ($uPrice * ($eValue / 100)) : (float) $eValue;
                        } else {
                            // Global setting fallback
                            $hFee = (float) \App\Models\Setting::getValue('handling_fee', 0);
                        }
                        $handlingFees += $qty * $hFee;
                    }

                    // Organizer fee — dynamic fallback (same as calculateSaldo)
                    if (!$isReseller) {
                        $type  = $t->organizer_fee_online_type  ?? $this->organizer_fee_online_type;
                        $value = $t->organizer_fee_online        ?? $this->organizer_fee_online;
                    } else {
                        $type  = $t->organizer_fee_reseller_type ?? $this->organizer_fee_reseller_type;
                        $value = $t->organizer_fee_reseller       ?? $this->organizer_fee_reseller;
                    }
                    $organizerFees += $qty * (($type === 'percent') ? ($uPrice * ($value / 100)) : (float) ($value ?? 0));
                }
            }
        }

        $withdrawnApproved = (float) (\Illuminate\Support\Facades\DB::table('withdrawals')
            ->where('event_id', $this->id)
            ->where('status', 'approved')
            ->sum('amount') ?: 0);

        $withdrawnPending = (float) (\Illuminate\Support\Facades\DB::table('withdrawals')
            ->where('event_id', $this->id)
            ->where('status', 'pending')
            ->sum('amount') ?: 0);

        // Net revenue = what organizer can withdraw (ticket price minus platform tax)
        $netRevenue = $grossRevenue - $organizerFees;

        $platformWithdrawn = (float) (\Illuminate\Support\Facades\DB::table('platform_withdrawals')
            ->where('event_id', $this->id)
            ->sum('amount') ?: 0);

        $totalPlatformIncome = $handlingFees + $organizerFees;

        return [
            'gross_revenue'          => $grossRevenue,
            'handling_fees'          => $handlingFees,
            'organizer_fees'         => $organizerFees,
            'total_platform_income'  => $totalPlatformIncome,
            'net_revenue'            => $netRevenue,
            'online_revenue'         => $onlineRevenue,
            'reseller_revenue'       => $resellerRevenue,
            'online_tickets_sold'    => $onlineTicketsSold,
            'reseller_tickets_sold'  => $resellerTicketsSold,
            'withdrawn_approved'     => $withdrawnApproved,
            'withdrawn_pending'      => $withdrawnPending,
            'available_saldo'        => $netRevenue - $withdrawnApproved - $withdrawnPending,
            'platform_withdrawn'     => $platformWithdrawn,
            'platform_available'     => $totalPlatformIncome - $platformWithdrawn,
        ];
    }

    public function getTotalWithdrawnAttribute()
    {
        // Use a fresh query directly on the withdrawals table
        // We include both 'approved' and 'pending' to prevent double-withdrawing the same funds
        return (float) (\Illuminate\Support\Facades\DB::table('withdrawals')
            ->where('event_id', $this->id)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount') ?: 0);
    }

    public function getAvailableSaldoAttribute()
    {
        // Re-calculate everything fresh
        return (float) ($this->calculateSaldo() - $this->total_withdrawn);
    }
}
