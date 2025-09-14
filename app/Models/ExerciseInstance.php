<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseInstance extends Model
{
    /** @use HasFactory<\Database\Factories\ExerciseInstanceFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id','lesson_id','template_id','word_id','status','display_order','shown_at','answered_at'
    ];
    protected $casts = [ 'shown_at' => 'datetime', 'answered_at' => 'datetime' ];

    public function user() { return $this->belongsTo(User::class); }
    public function lesson() { return $this->belongsTo(Lesson::class); }
    public function template() { return $this->belongsTo(ExercieseTemplate::class, 'template_id'); }
    public function word() { return $this->belongsTo(Word::class); }
    public function options() { return $this->hasMany(ExerciseOption::class); }
    public function attempts() { return $this->hasMany(Attempt::class); }
}

