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
                $uPrice = $trans->unit_price !== null ? (float) $trans->unit_price : (float) $t->price;
                $revenue = $qty * $uPrice;

                // 2. Platform Fees (Potongan Platform dari Organizer)
                if ($trans->unit_price !== null) {
                    // NEW LOGIC: Use stored organizer_fee
                    $totalPlatformFee = $qty * (float) $trans->organizer_fee;
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
