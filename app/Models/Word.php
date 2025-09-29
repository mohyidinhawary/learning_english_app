<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Word extends Model
{
    /** @use HasFactory<\Database\Factories\WordFactory> */
    use HasFactory;

     protected $fillable = ['lesson_id','en_text','ar_text','image_url','audio_url','difficulty','is_active'];
    protected $casts = [ 'is_active' => 'boolean' ];

    public function lesson() { return $this->belongsTo(Lesson::class); }
    public function sentences() { return $this->hasMany(WordSentence::class); }

     public function exercises()
    {
        return $this->hasMany(ExercieseTemplate::class, 'word_id');
    }


    public function userStats()
{
    return $this->hasMany(UserWordStat::class);
}
}
