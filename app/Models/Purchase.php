<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * $fillable — mass-assignment allowlist.
     * 'purchase_date' is a date column; 'total_price' stores the sum of all PurchaseDetails.
     * 'note_number' is the unique identifier for the purchase.
     */
    protected $fillable = [
        'note_number',
        'purchase_date',
        'distributor_id',
        'total_price',
    ];

    /**
     * $casts — auto-converts 'purchase_date' string to Carbon for date arithmetic.
     */
    protected $casts = [
        'purchase_date' => 'date',
        'total_price'   => 'integer',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    /**
     * A Purchase BELONGS TO a Distributor (many purchases → one supplier).
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * A Purchase HAS MANY PurchaseDetails (one purchase = multiple line items / product rows).
     * Uses custom foreign key 'note_number_purchase' instead of 'id'.
     */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'note_number_purchase', 'note_number');
    }

    // =========================================================
    // LOCAL QUERY SCOPES
    // =========================================================

    /**
     * Filter purchases by month and year.
     * Usage: Purchase::forMonth(2026, 3)->get()  → all March 2026 purchases
     */
    public function scopeForMonth($query, int $year, int $month)
    {
        return $query->whereYear('purchase_date', $year)
                     ->whereMonth('purchase_date', $month);
    }
}
