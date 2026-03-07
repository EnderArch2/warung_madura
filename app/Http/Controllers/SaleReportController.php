<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    /**
     * Display the tabular Sale Reports view.
     * Includes simple date-range filtering.
     */
    public function index(Request $request)
    {
        $query = Sale::with('saleDetails.product')->latest('sale_date');

        // Apply filters if dates are provided via the GET request
        if ($request->filled('start_date')) {
            $query->whereDate('sale_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('sale_date', '<=', $request->end_date);
        }

        $sales = $query->paginate(15)->withQueryString(); // withQueryString preserves pagination links when filtered

        // Calculate aggregate totals for the REPORT SUMMARY cards on this specific filtered result
        // We duplicate the query conditions but use aggregate functions
        $summaryQuery = Sale::query();
        if ($request->filled('start_date')) {
            $summaryQuery->whereDate('sale_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $summaryQuery->whereDate('sale_date', '<=', $request->end_date);
        }

        $totalRevenue = $summaryQuery->sum('total_price');
        $totalTransactions = $summaryQuery->count();

        return view('sale_reports.index', [
            'title'             => 'Sale Reports',
            'sales'             => $sales,
            'totalRevenue'      => $totalRevenue,
            'totalTransactions' => $totalTransactions,
        ]);
    }
}
