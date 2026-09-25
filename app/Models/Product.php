<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->orderByDesc('hit_count')->orderByDesc('sales_count')->latest();
    }

    public function scopeBestSellers(Builder $query): Builder
    {
        return $query->orderByDesc('sales_count')->orderByDesc('hit_count');
    }

    public function scopeNewArrivals(Builder $query): Builder
    {
        return $query->latest();
    }

    public function scopeTopDiscounted(Builder $query): Builder
    {
        return $query->where('regular_amount', '>', 0)
            ->whereColumn('selling_amount', '<', 'regular_amount')
            ->orderByRaw('(regular_amount - selling_amount) / regular_amount DESC');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured_status', 'featured');
    }

    public function scopeByTag(Builder $query, string $slug): Builder
    {
        return $query->whereHas('tags', fn (Builder $tag) => $tag->where('slug', $slug));
    }
}
