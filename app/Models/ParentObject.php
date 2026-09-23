<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentObject extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'school_id',
        'user_id',
        'father_name',
        'mother_name',
        'guardian_name',
        'phone',
        'email',
        'occupation',
        'address',
        'photo',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
                    ->withPivot('relationship');
    }
}
