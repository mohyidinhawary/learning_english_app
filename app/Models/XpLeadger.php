<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpLeadger extends Model
{
    /** @use HasFactory<\Database\Factories\XpLeadgerFactory> */
    use HasFactory;

     protected $table = 'xp_ledger';
    protected $fillable = ['user_id','amount','source','related_type','related_id'];

    public function user() { return $this->belongsTo(User::class); }
}
