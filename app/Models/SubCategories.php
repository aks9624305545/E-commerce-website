<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = [
        'category_id',
        'sub_category_name',
        'sub_category_images',
        'sub_category_description',
        'is_deleted'
    ];
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
