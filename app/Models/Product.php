<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'name',
        'description',
        'price',
        'location',
        'quantity',
        'size',
        'status',
        'color',
        'delete_reason',
        'state'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
