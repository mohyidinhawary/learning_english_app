<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
     protected $fillable = [
        'user_id',
        'experience',
        'easy_to_understand',
        'continue_next_level',
    ];
}
