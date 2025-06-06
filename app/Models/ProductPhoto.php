<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'product_id'
    ];
}
