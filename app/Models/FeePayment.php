<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_fee_id',
        'student_id',
        'receipt_number',
        'amount',
        'payment_date',
        'payment_mode',
        'reference_number',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class);
    }
}
