<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'registration_number',
        'vehicle_type',
        'capacity',
        'driver_name',
        'driver_phone',
        'status',
    ];
}
