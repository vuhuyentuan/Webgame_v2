<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public function bill()
    {
        return $this->belongsTo(Bill::class,'product_id', 'id');
    }

    public function package()
    {
        return $this->hasMany(Package::class,'product_id', 'id');
    }

}
