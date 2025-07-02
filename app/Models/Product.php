<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku',
        'name',
        'price',
        'description',
        'thumbnail',
        'is_ppn',
        'unit_id',
        'category_id',
        'brand_id',
        'quantity',
    ];
    
    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function types(): HasMany
    {
        return $this->hasMany(ProductType::class);
    }
}
