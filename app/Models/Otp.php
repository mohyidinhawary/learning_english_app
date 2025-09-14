<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    /** @use HasFactory<\Database\Factories\OtpFactory> */
    use HasFactory;
    protected $guarded = [];


    // protected $dates = ['expires_at'];

   public static function getOtpByEmail($email)
    {
        return self::where('email', $email)->first();
    }
}
