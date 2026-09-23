<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'audience',
        'attachment',
        'publish_date',
        'expiry_date',
        'status',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
