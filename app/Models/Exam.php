<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'name',
        'start_date',
        'end_date',
        'is_published',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }
}
