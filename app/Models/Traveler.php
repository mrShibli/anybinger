<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#travelers

class Traveler extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'out_cunt_num',
        'bd_number',
        'barth',
        'out_address',
        'bd_address',
        'city',
        'state',
        'zip_code',
        'passport',
        // Add other fields as needed
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
