<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public const LOCATIONS = [
        'hero_sidebar_top',
        'hero_sidebar_bottom',
        'mid_left',
        'mid_right',
        'special_banner',
    ];

    protected $fillable = [
        'location',
        'title',
        'description',
        'button_text',
        'button_url',
        'image',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->latest();
    }

    public function scopeForLocation(Builder $query, string ...$locations): Builder
    {
        return $query->whereIn('location', $locations);
    }
}
