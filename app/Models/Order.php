<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'order_total',
        'tax_total',
        'shipping_total',
        'order_status',
        'delivery_address',
        'delivery_status',
        'payment_type',
        'payment_status',
        'currency',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'order_total' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'shipping_total' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
