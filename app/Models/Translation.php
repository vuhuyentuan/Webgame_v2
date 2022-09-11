<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $table = 'translations';

    protected $fillable = [
        'locale',
        'string',
        'parent_id'
    ];

    public static function count($locale)
    {
        return Translation::where('locale', $locale)->count();
    }

}
