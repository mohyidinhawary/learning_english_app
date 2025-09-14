<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    /** @use HasFactory<\Database\Factories\AttemptFactory> */
    use HasFactory;

     protected $fillable = [
        'exercise_instance_id','attempt_no','is_correct','used_hint','selected_option_id','answer_text','time_ms'
    ];
    protected $casts = ['is_correct'=>'boolean','used_hint'=>'boolean'];

    public function instance() { return $this->belongsTo(ExerciseInstance::class,'exercise_instance_id'); }
    public function selectedOption() { return $this->belongsTo(ExerciseOption::class,'selected_option_id'); }
}
