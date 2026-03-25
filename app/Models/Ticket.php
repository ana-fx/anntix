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
        'reseller_fee_type',
        'reseller_fee_value',
        'handling_fee_type',
        'handling_fee_value',
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
     * Get the effective handling fee for this ticket.
     *
     * Priority:
     * 1. Ticket-level override (if handling_fee_type is explicitly set)
     * 2. Event-level override
     * 3. Global setting (Setting::getValue('handling_fee'))
     */
    public function getHandlingFee(): float
    {
        // 1. Ticket-level override first
        if (!empty($this->handling_fee_type) && $this->handling_fee_type !== 'default') {
            if ($this->handling_fee_type === 'percent') {
                return (float) ($this->price * ($this->handling_fee_value / 100));
            }
            if ($this->handling_fee_type === 'fixed') {
                return (float) $this->handling_fee_value;
            }
        }

        // 2. Fall back to event-level handling fee (which already falls back to global Setting)
        return (float) $this->event->getHandlingFee($this->price);
    }

    /**
     * Get rincian biaya (Breakdown) berdasarkan sumbernya.
     * Service Fee = Dari Setting Global (Rp 5.000)
     * Handling Fee = Dari Override di level Tiket atau Event
     */
    public function getFeeBreakdown(): array
    {
        // 1. Cek Override di Tiket
        if (!empty($this->handling_fee_type) && $this->handling_fee_type !== 'default') {
            return [
                'service' => 0,
                'handling' => $this->getHandlingFee(),
            ];
        }

        // 2. Cek Override di Event
        if (!empty($this->event->handling_fee_type) && $this->event->handling_fee_type !== 'default') {
            return [
                'service' => 0,
                'handling' => $this->getHandlingFee(),
            ];
        }

        // 3. Fallback ke Global (Semua masuk Service Fee)
        return [
            'service' => $this->getHandlingFee(),
            'handling' => 0,
        ];
    }

    /**
     * Get the effective organizer fee for this ticket.
     */
    public function getOrganizerFee($type = 'online'): float
    {
        $event = $this->event;
        $feeType = $type === 'online'
            ? ($this->organizer_fee_online_type ?? $event->organizer_fee_online_type)
            : ($this->organizer_fee_reseller_type ?? $event->organizer_fee_reseller_type);

        $feeValue = $type === 'online'
            ? ($this->organizer_fee_online ?? $event->organizer_fee_online)
            : ($this->organizer_fee_reseller ?? $event->organizer_fee_reseller);

        if ($feeType === 'percent') {
            return (float) ($this->price * ($feeValue / 100));
        }
        return (float) ($feeValue ?? 0);
    }

    /**
     * Get the effective reseller fee (commission added to buyer) for this ticket.
     */
    public function getResellerFee(): float
    {
        $event = $this->event;
        $feeType = $this->reseller_fee_type ?? $event->reseller_fee_type;
        $feeValue = $this->reseller_fee_value ?? $event->reseller_fee_value;

        if ($feeType === 'percent') {
            return (float) ($this->price * ($feeValue / 100));
        }
        return (float) ($feeValue ?? 0);
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
