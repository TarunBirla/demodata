<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'dob',
        'gender',
        'photo',
        'address',
        'qualification',
        'joining_date',
        'designation',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
