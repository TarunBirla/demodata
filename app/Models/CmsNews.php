<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsNews extends Model
{
    use HasFactory;

    protected $table = 'cms_news';

    protected $fillable = [
        'school_id',
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];
}
