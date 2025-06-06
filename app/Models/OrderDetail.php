<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_id',
        'price',
        'subtotal',
    ];

    public function order():BelongsTo 
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product():BelongsTo 
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit():BelongsTo 
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
