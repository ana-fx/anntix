<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'event_id',
        'amount',
        'status',
        'reference',
        'note',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
