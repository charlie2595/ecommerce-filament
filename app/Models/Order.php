<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static function generateUniqueTrxId() {
        $prefix = 'C';
        do {
            $randomString = $prefix . mt_rand(1000, 9999); //C189
        } while (self::where('document', $randomString)->exists());

        return $randomString; //C189
    }
}
