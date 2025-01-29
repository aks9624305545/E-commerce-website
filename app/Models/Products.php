<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'sub_category_id',
        'products_name',
        'products_images',
        'products_description',
        'is_deleted'
    ];
    public function subCategory()
    {
        return $this->belongsTo(SubCategories::class, 'sub_category_id');
    }
}
