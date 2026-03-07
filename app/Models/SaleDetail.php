<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    /**
     * NOTE: 'serial_number_product' is a STRING foreign key that references
     * the 'serial_number' column in the products table (NOT the standard 'id').
     * This is an unconventional FK — defined in the migration explicitly.
     */
    protected $fillable = [
        'sale_id',
        'serial_number_product',
        'selling_price',
        'sales_quantity',
        'subtotal',
    ];

    protected $casts = [
        'selling_price'  => 'integer',
        'sales_quantity' => 'integer',
        'subtotal'       => 'integer',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    /**
     * A SaleDetail BELONGS TO a Sale (many line items → one sale header).
     * This is the inverse of Sale::hasMany(SaleDetail::class).
     *
     * Usage:  $detail->sale  → the parent Sale instance
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    /**
     * A SaleDetail references a Product via its serial_number.
     * WHY 'serial_number' instead of 'id'?
     * The migration uses serial_number as the FK — it's not the Eloquent default.
     * We must explicitly tell Eloquent which column to join on:
     *   foreignKey: 'serial_number_product' (in sale_details table)
     *   ownerKey:   'serial_number'         (in products table)
     *
     * Usage:  $detail->product  → the Product instance
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'serial_number_product', 'serial_number');
    }
}
