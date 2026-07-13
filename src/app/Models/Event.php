<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['category_id', 'venue_id', 'name', 'slug', 'description', 'banner_image', 'start_date', 'end_date', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function bookingDetails()
    {
        return $this->hasManyThrough(BookingDetail::class, TicketType::class);
    }
}
