<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'route_id',
        'pickup_stop',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
