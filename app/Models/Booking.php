<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
        'barber_id',
        'full_name',
        'phone',
        'email',
        'booking_date',
        'booking_time',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
