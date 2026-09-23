<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'isbn',
        'title',
        'author',
        'publisher',
        'category',
        'quantity',
        'available_quantity',
        'shelf_location',
        'price',
    ];
}
