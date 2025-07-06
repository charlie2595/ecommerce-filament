<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'display_name',
        'value'
    ];
    public $timestamps = false;

    static public function getValue($name)
    {
        return Configuration::where('name', $name)->first()->value;
    }
}
