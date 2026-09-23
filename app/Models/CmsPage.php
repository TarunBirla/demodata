<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasFactory;

    protected $table = 'cms_pages';

    protected $fillable = [
        'school_id',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'status',
    ];
}
