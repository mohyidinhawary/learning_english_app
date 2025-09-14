<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    /** @use HasFactory<\Database\Factories\ChapterFactory> */
    use HasFactory;
     protected $fillable = ['level_id','title','position','is_active'];

    public function level() { return $this->belongsTo(Level::class); }
    public function lessons() { return $this->hasMany(Lesson::class); }
}
