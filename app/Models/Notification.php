<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $guarded = [];
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }
}
