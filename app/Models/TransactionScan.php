<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'scanned_by',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
