<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quota',
        'max_scans',
        'max_purchase_per_user',
        'start_date',
        'end_date',
        'description',
        'is_active',
        'organizer_fee_online_type',
        'organizer_fee_online',
        'organizer_fee_reseller_type',
        'organizer_fee_reseller',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope a query to only include tickets that are active and currently valid based on date.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope a query to include tickets that should be expired.
     */
    public function scopeExpired($query)
    {
        return $query->where('is_active', true)
            ->where('end_date', '<', now());
    }
}
