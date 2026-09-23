<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'staff_id',
        'month_year',
        'basic_salary',
        'allowances',
        'deductions',
        'net_salary',
        'payment_date',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
