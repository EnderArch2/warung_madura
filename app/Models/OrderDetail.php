<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'order_id',
        'serial_number_product',
        'selling_price',
        'sales_quantity',
        'subtotal',
        'note'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
