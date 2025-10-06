<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExercieseTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\ExercieseTemplateFactory> */
    use HasFactory;

     protected $fillable = ['lesson_id','word_id','type','question','settings','status','difficulty'];
    protected $casts = ['settings' => 'array'];

    public function lesson() { return $this->belongsTo(Lesson::class); }
    public function instances() { return $this->hasMany(ExerciseInstance::class, 'template_id'); }
    public function options()
    {
        return $this->hasMany(ExerciseOption::class, 'template_id');
    }
    public function word()
{
    return $this->belongsTo(Word::class, 'word_id');
}
}
