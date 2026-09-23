<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'school_id',
        'user_id',
        'employee_id',
        'name',
        'department',
        'designation',
        'phone',
        'email',
        'joining_date',
        'basic_salary',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
