<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'application_no',
        'student_name',
        'dob',
        'gender',
        'applying_class_id',
        'previous_school',
        'parent_name',
        'parent_phone',
        'parent_email',
        'address',
        'document_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function applyingClass()
    {
        return $this->belongsTo(SchoolClass::class, 'applying_class_id');
    }
}
