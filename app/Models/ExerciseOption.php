<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseOption extends Model
{
    /** @use HasFactory<\Database\Factories\ExerciseOptionFactory> */
    use HasFactory;

     protected $fillable = ['exercise_instance_id','label','value','is_correct'];
    protected $casts = ['is_correct' => 'boolean'];

    public function instance() { return $this->belongsTo(ExerciseInstance::class, 'exercise_instance_id'); }
    public function attemptsSelected() { return $this->hasMany(Attempt::class, 'selected_option_id'); }

    public function template()
    {
        return $this->belongsTo(ExercieseTemplate::class, 'template_id');
    }
}

