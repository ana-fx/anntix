<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'code',
        'event_id',
        'ticket_id',
        'name',
        'email',
        'phone',
        'city',
        'nik',
        'gender',
        'quantity',
        'total_price',
        'status',
        'snap_token',
        'payment_type',
        'midtrans_transaction_id',
        'redeemed_at',
        'redeemed_by',
        'reseller_id',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'redeemed_by');
    }

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    public function getCommissionAttribute()
    {
        if (!$this->reseller_id || !$this->event || !$this->ticket) {
            return 0;
        }

        $feePerTicket = 0;
        if ($this->event->reseller_fee_type === 'fixed') {
            $feePerTicket = $this->event->reseller_fee_value;
        } else {
            $feePerTicket = ($this->ticket->price * ($this->event->reseller_fee_value / 100));
        }

        return $feePerTicket * $this->quantity;
    }
}
