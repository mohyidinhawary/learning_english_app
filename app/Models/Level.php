<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;

     protected $fillable = ['title','position','is_active'];

    public function chapters() { return $this->hasMany(Chapter::class); }
}

