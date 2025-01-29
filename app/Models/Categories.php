<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'category_name',
        'category_images',
        'category_description',
        'is_deleted'
    ];
}
