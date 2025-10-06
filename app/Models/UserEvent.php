<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    protected $fillable = ['user_id', 'event_name', 'event_data'];
    protected $casts = ['event_data' => 'array'];
}
