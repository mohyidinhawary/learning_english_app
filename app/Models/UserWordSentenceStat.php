<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWordSentenceStat extends Model
{
    protected $fillable = [
        'user_id',
        'word_sentece_id',
        'status',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sentence()
    {
        return $this->belongsTo(WordSentence::class);
    }
}
