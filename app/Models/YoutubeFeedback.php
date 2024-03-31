<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeFeedback extends Model
{
    use HasFactory;

    protected $table = 'youtube_feedbacks';
    protected $fillable = [
        'feedback1',
        'shopper1',
        'feedback2',
        'shopper2',
        'feedback3',
        'shopper3',
    ];
}
