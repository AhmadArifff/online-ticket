<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = ['booking_id', 'payment_method', 'transaction_id', 'amount', 'status', 'paid_at'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];
    
    public static function booted()
    {
        static::creating(function ($payment) {
            if (empty($payment->transaction_id)) {
                $payment->transaction_id = 'TX-' . now()->format('YmdHis') . '-' . Str::random(8);
            }
        });
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
