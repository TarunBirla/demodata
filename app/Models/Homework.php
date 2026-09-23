<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homework';

    protected $fillable = [
        'school_id',
        'class_id',
        'section_id',
        'subject_id',
        'teacher_id',
        'title',
        'description',
        'attachment_path',
        'assigned_date',
        'due_date',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'due_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
