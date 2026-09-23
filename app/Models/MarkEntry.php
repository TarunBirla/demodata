<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_subject_id',
        'student_id',
        'marks_obtained',
        'grade',
        'result_status',
        'remarks',
        'is_locked',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    public function examSubject()
    {
        return $this->belongsTo(ExamSubject::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
