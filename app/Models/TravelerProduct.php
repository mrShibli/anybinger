<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerProduct extends Model
{
    use HasFactory;
    public function traveler()
    {
        return $this->belongsTo(Traveler::class, 'traveler_id');
    }

    public function productRequest()
    {
        return $this->belongsTo(ProductRequest::class, 'product_request_id');
    }

}
