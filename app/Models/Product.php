<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand_id',
        'unit_id',
        'name',
        'code',
        'model',
        'stock_amount',
        'regular_amount',
        'selling_amount',
        'short_description',
        'long_description',
        'featured_image',
        'hit_count',
        'sales_count',
        'featured_status',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'stock_amount' => 'integer',
            'regular_amount' => 'decimal:2',
            'selling_amount' => 'decimal:2',
            'hit_count' => 'integer',
            'sales_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}
