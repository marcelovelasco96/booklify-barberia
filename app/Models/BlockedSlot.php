<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedSlot extends Model
{
    protected $fillable = [
        'service_id',
        'blocked_date',
        'blocked_time',
        'reason',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
