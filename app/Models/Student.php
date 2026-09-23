<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'admission_number',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'dob',
        'blood_group',
        'photo',
        'address',
        'phone',
        'email',
        'emergency_contact',
        'academic_year_id',
        'class_id',
        'section_id',
        'roll_number',
        'admission_date',
        'previous_school',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function parents()
    {
        return $this->belongsToMany(ParentObject::class, 'parent_student', 'student_id', 'parent_id')
                    ->withPivot('relationship');
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function fees()
    {
        return $this->hasMany(StudentFee::class);
    }

    public function markEntries()
    {
        return $this->hasMany(MarkEntry::class);
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
