<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'invoice_id',
        'custom_amount',
        'payment_type',
        'discount',
        'fees',
        'total',
        'paid',
        'notes',
        'status',
    ];

    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
