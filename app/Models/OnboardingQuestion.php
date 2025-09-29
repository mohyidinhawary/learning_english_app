<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingQuestion extends Model
{
     protected $fillable = [

        'reason_to_learn',
        'country',
        'proficiency_level',
        'daily_plan',
    ];
}
