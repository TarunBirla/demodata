<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsGallery extends Model
{
    use HasFactory;

    protected $table = 'cms_galleries';

    protected $fillable = [
        'school_id',
        'title',
        'image_path',
        'category',
        'description',
    ];
}
