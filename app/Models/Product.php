<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * $fillable tells Laravel which columns are safe to mass-assign.
     * Without this, Distributor::create($request->all()) would throw
     * a MassAssignmentException — a security feature against
     * "mass assignment" attacks.
     *
     * Rule: Only list columns users are ALLOWED to set through forms.
     * Never put sensitive fields like 'role' or 'is_admin' here.
     */
    protected $fillable = [
        'serial_number',
        'name',
        'type',
        'expiration_date',
        'price',
        'stock',
        'picture',
    ];

    /**
     * $casts automatically converts database column types to PHP types.
     * For example: the 'expiration_date' string from MySQL becomes a
     * Carbon (date) object, so you can do $product->expiration_date->format('d M Y').
     *
     * Without this, dates are plain strings — harder to compare or format.
     */
    protected $casts = [
        'expiration_date' => 'date',
        'price'           => 'integer',
        'stock'           => 'integer',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    /**
     * A Product HAS MANY SaleDetails (it can appear in many sale line items).
     * This is a one-to-many relationship.
     *
     * Usage: $product->saleDetails  → collection of SaleDetail records
     *
     * Laravel convention: the foreign key in sale_details table is 'product_id'.
     * Eloquent infers this automatically from the method name + '_id'.
     */
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * A Product HAS MANY PurchaseDetails (appears in many purchase orders).
     */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    /**
     * A Product HAS MANY OrderDetails (appears in many customer orders).
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // =========================================================
    // LOCAL QUERY SCOPES
    // =========================================================

    /**
     * Reusable query scope to filter products with LOW STOCK.
     * "Scopes" let you chain readable conditions onto Eloquent queries.
     *
     * Instead of:  Product::where('stock', '<=', 5)->get()
     * You can do:  Product::lowStock()->get()
     *
     * Usage: Product::lowStock(10)->get()  → products with stock ≤ 10
     */
    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where('stock', '<=', $threshold);
    }
}
