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
}
