<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    /**
     * NOTE: 'note_number_purchase' is a STRING foreign key that references
     * the 'note_number' column in the purchases table (NOT the standard 'id').
     * 'serial_number_product' is also a STRING FK to products.serial_number.
     */
    protected $fillable = [
        'note_number_purchase',
        'serial_number_product',
        'purchase_price',
        'selling_margin',
        'purchase_amount',
        'subtotal',
    ];

    protected $casts = [
        'purchase_price'  => 'integer',
        'selling_margin'  => 'integer',
        'purchase_amount' => 'integer',
        'subtotal'        => 'integer',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    /**
     * A PurchaseDetail BELONGS TO a Purchase (many line items → one purchase header).
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'note_number_purchase', 'note_number');
    }

    /**
     * A PurchaseDetail references a Product via its serial_number.
     * We must explicitly tell Eloquent which column to join on.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'serial_number_product', 'serial_number');
    }
}
