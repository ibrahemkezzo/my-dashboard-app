<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
protected $fillable = ['booking_id', 'salon_sub_service_id', 'quantity', 'notes'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function salonSubService()
    {
        return $this->belongsTo(SalonSubService::class);
    }
}
