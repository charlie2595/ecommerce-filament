<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'document',
        'date',
        'status',
        'notes',
        'total',
        'grand_total',
        'payment_method',
        'payment_status',
        'shipping_amount',
        'shipping_method',
    ];

    public static function generateUniqueTrxId() {
        $prefix = 'C';
        do {
            $randomString = $prefix . mt_rand(1000, 9999); //C189
        } while (self::where('document', $randomString)->exists());

        return $randomString; //C189
    }

    public function customer(): BelongsTo 
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function details(): HasMany 
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Addresses::class);
    }
}
