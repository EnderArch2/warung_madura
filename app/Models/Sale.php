<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * $fillable — mass-assignment allowlist.
     * 'sale_date' is a date column; 'total_price' stores the sum of all SaleDetails.
     */
    protected $fillable = [
        'sale_date',
        'total_price',
    ];

    /**
     * $casts — auto-converts 'sale_date' string to Carbon for date arithmetic.
     * WHY: allows $sale->sale_date->format('d M Y'), ->month, ->year, etc.
     * Without this, you'd need Carbon::parse($sale->sale_date) every time.
     */
    protected $casts = [
        'sale_date'   => 'date',
        'total_price' => 'integer',
    ];

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    /**
     * A Sale HAS MANY SaleDetails (one sale = multiple line items / product rows).
     *
     * Example: Sale #1 (date: 2025-11-01)
     *   → SaleDetail: 3x Indomie Goreng  = Rp 10,500
     *   → SaleDetail: 2x Aqua 600ml      = Rp  6,000
     *   → total_price = Rp 16,500
     *
     * Usage:  $sale->saleDetails         → CollectionOf SaleDetail
     *         $sale->saleDetails->count() → number of line items
     */
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }

    // =========================================================
    // LOCAL QUERY SCOPES
    // =========================================================

    /**
     * Scope: filter sales by a given year.
     *
     * Usage:  Sale::forYear(2025)->get()
     * SQL:    WHERE YEAR(sale_date) = 2025
     */
    public function scopeForYear($query, int $year)
    {
        return $query->whereYear('sale_date', $year);
    }

    /**
     * Scope: filter sales by a given month in a given year.
     *
     * Usage:  Sale::forMonth(2025, 11)->get()
     * SQL:    WHERE YEAR(sale_date)=2025 AND MONTH(sale_date)=11
     */
    public function scopeForMonth($query, int $year, int $month)
    {
        return $query->whereYear('sale_date', $year)
                     ->whereMonth('sale_date', $month);
    }
}
