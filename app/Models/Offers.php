<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Offers extends Model
{
    protected $fillable = [
        'title',
        'description',
        'valid_date',
        'max_users',
        'shop_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shops::class, 'shop_id');
    }
     
}
