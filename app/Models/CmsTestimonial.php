<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsTestimonial extends Model
{
    use HasFactory;

    protected $table = 'cms_testimonials';

    protected $fillable = [
        'school_id',
        'name',
        'role',
        'photo',
        'content',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
