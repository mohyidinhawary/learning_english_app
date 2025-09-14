<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrsQueue extends Model
{
    /** @use HasFactory<\Database\Factories\SrsQueueFactory> */
    use HasFactory;

     protected $table = 'srs_queue';
    protected $fillable = ['user_id','word_id','exercise_instance_id','due_at','reason','last_result'];
    protected $casts = ['due_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function word() { return $this->belongsTo(Word::class); }
    public function exerciseInstance() { return $this->belongsTo(ExerciseInstance::class); }
}

