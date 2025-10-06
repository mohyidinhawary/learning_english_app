<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWordStat extends Model
{
    protected $table = 'user_word_stats';

    protected $fillable = [
        'user_id',
        'word_id',
        'status',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
