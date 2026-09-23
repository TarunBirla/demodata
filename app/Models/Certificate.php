<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'certificate_type',
        'certificate_number',
        'issue_date',
        'data_json',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'data_json' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
