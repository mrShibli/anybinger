<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'notes',
        'qty',
        'original_price',
        'estimated_price',
        'image',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
