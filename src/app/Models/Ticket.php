<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['booking_detail_id', 'ticket_code', 'qr_code', 'is_used', 'used_at'];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function bookingDetail()
    {
        return $this->belongsTo(BookingDetail::class);
    }
}
