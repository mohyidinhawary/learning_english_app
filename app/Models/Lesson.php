<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;
     protected $fillable = ['chapter_id','title','position','is_free','difficulty','status','xp'];
    protected $casts = [ 'is_free' => 'boolean' ];

    public function chapter() { return $this->belongsTo(Chapter::class); }
    public function words() { return $this->hasMany(Word::class); }
    public function exerciseTemplates() { return $this->hasMany(ExercieseTemplate::class); }
    public function exerciseInstances() { return $this->hasMany(ExerciseInstance::class); }
}

