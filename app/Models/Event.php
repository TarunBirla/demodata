<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'image',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}
