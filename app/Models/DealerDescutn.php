<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerDescutn extends Model
{
    use HasFactory;
    protected $fillable = [
        'descount_dealer',
    ];
}
