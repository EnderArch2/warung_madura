<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_date',
        'user_id',
        'status',
        'payment_method',
        'total_price',
        'status information',
    ];

    public function orderDetails(): HasMany {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
