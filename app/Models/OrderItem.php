<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'r_product_id',
        'name',
        'price',
        'qty',
        'total',
        'image'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

     public function order(){
        return $this->belongsTo(Order::class);
    }
}
