<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordSentence extends Model
{
    /** @use HasFactory<\Database\Factories\WordSentenceFactory> */
    use HasFactory;

     protected $fillable = ['word_id','en_sentence','ar_sentence','audio_url'];
    public function word() { return $this->belongsTo(Word::class); }

    public function userStats()
{
    return $this->hasMany(UserWordSentenceStat::class);
}
}
