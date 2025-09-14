<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLessonStat extends Model
{
    /** @use HasFactory<\Database\Factories\UserLessonStatFactory> */
    use HasFactory;

     protected $fillable = [
        'user_id','lesson_id','xp_earned','attempts_count','first_try_count','hints_count','mastered_at','repeats_count'
    ];
    protected $casts = ['mastered_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function lesson() { return $this->belongsTo(Lesson::class); }
}
