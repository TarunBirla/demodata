<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'route_name',
        'vehicle_id',
        'fee',
        'pickup_time',
        'drop_time',
        'stops',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
