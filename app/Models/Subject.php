<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'name', 'code', 'type', 'status'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject', 'subject_id', 'class_id')
                    ->withPivot('teacher_id', 'subject_type');
    }
}
