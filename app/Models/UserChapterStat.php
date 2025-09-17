<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChapterStat extends Model
{
   protected $fillable = [
        'user_id',
        'chapter_id',
        'xp_earned',
        'lessons_completed',
         'badges_count',
        'mastered_at',
    ];

    protected $casts = [
        'mastered_at' => 'datetime',
    ];

    // 🔹 العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
