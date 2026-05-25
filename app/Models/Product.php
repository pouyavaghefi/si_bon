<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'type',
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'discount_price',
        'sale_unit',
        'stock',
        'delivery_time',
        'min_order',
        'status',
        'is_featured',
        'show_price',
        'allow_order',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    protected $casts = [
        'allowed_extensions' => 'array',
        'require_upload' => 'boolean',
        'is_featured' => 'boolean',
        'show_price' => 'boolean',
        'allow_order' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }
}
