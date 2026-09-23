<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'parent_name',
        'phone',
        'email',
        'student_name',
        'grade_seeking',
        'message',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
