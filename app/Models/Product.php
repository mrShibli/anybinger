<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'subcategory_id',
        'brand_id',
        'price',
        'compare_price',
        'short_description',
        'description',
        'tags',
        'meta_keyword',
        'meta_description',
        'track_quantity',
        'quantity',
        'status'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function productImage(){
        return $this->hasMany(ProductImage::class);
    }


    public function specialProduct()
    {
        return $this->hasOne(SpecialProduct::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function review(){
        return $this->hasMany(Review::class);
    }

}
