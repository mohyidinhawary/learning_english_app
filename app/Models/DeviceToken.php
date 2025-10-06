<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DeviceToken extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function deviceable(): MorphTo
    {
        return $this->morphTo();
    }
}
