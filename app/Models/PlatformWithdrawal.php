<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformWithdrawal extends Model
{
    protected $fillable = ['event_id', 'amount', 'note'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
