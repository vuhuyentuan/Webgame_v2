<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeHistory extends Model
{
    use HasFactory;

    protected $table = "recharge_histories";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
