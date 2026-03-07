<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * DashboardController — aggregates real data from sales, sale_details,
 * and products tables to power the dashboard's charts and stat cards.
 *
 * REQUEST LIFECYCLE for /dashboard:
 * 1. Browser: GET /dashboard
 * 2. routes/web.php: Route::resource('/dashboard', DashboardController::class)
 *    → maps GET /dashboard to DashboardController@index
 * 3. Middleware: no auth middleware yet (add later)
 * 4. Controller: runs Eloquent queries, passes data to view
 * 5. Blade: renders dashboard/index.blade.php with injected variables
 * 6. Response: HTML back to browser → Chart.js reads the PHP data via @json()
 */
class DashboardController extends Controller
{
    /**
     * INDEX — The main dashboard view.
     *
     * We collect all stats here and pass them to the view.
     * This is called "eager loading the dashboard" — NOT lazy loading.
     * Lazy loading would mean loading data only when needed, but for dashboards
     * we want ALL data in one place to pass to JS charts cleanly.
     */
    public function index()
    {
        $now       = Carbon::now();
        $thisMonth = $now->month;
        $thisYear  = $now->year;
        $lastMonth = $now->copy()->subMonth();

        // =====================================================
        // STAT CARD 1: Today's Money (today's total sales revenue)
        // =====================================================

        $todayRevenue = Sale::whereDate('sale_date', $now->toDateString())
                            ->sum('total_price');

        // Compare with yesterday to compute % change
        $yesterdayRevenue = Sale::whereDate('sale_date', $now->copy()->subDay()->toDateString())
                                ->sum('total_price');

        $revenueChange = $yesterdayRevenue > 0
            ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100)
            : 0;

        // =====================================================
        // STAT CARD 2: Total Products (total distinct products in catalog)
        // =====================================================
        $totalProducts   = Product::count();
        $lowStockCount   = Product::lowStock()->count(); // reuse our scope from Feature 1!

        // =====================================================
        // STAT CARD 3: This Month's Sales Count (number of transactions)
        // =====================================================
        $thisMonthSalesCount = Sale::forMonth($thisYear, $thisMonth)->count();
        $lastMonthSalesCount = Sale::forMonth($lastMonth->year, $lastMonth->month)->count();

        $salesCountChange = $lastMonthSalesCount > 0
            ? round((($thisMonthSalesCount - $lastMonthSalesCount) / $lastMonthSalesCount) * 100)
            : 0;

        // =====================================================
        // STAT CARD 4: This Month's Revenue (total revenue this month)
        // =====================================================
        $thisMonthRevenue = Sale::forMonth($thisYear, $thisMonth)->sum('total_price');
        $lastMonthRevenue = Sale::forMonth($lastMonth->year, $lastMonth->month)->sum('total_price');

        $revenueMonthChange = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : 0;

        // =====================================================
        // BAR CHART: Monthly sales counts for the last 9 months
        // =====================================================
        // We use DB::table() with groupBy() + selectRaw() for an aggregate query.
        // This runs a single SQL query instead of 9 separate queries — much more efficient!
        //
        // SQL:  SELECT MONTH(sale_date) as month, COUNT(*) as count
        //       FROM sales
        //       WHERE sale_date >= '2025-03-01'
        //       GROUP BY MONTH(sale_date)
        //       ORDER BY month ASC

        $nineMonthsAgo = $now->copy()->subMonths(8)->startOfMonth();

        $monthlyCounts = Sale::where('sale_date', '>=', $nineMonthsAgo)
            ->selectRaw('MONTH(sale_date) as month, YEAR(sale_date) as year, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT));

        // Build ordered labels and data arrays for the last 9 months
        $barLabels = [];
        $barData   = [];
        for ($i = 8; $i >= 0; $i--) {
            $dt    = $now->copy()->subMonths($i);
            $key   = $dt->year . '-' . str_pad($dt->month, 2, '0', STR_PAD_LEFT);
            $barLabels[] = $dt->format('M');   // "Mar", "Apr", etc.
            $barData[]   = $monthlyCounts->has($key) ? $monthlyCounts[$key]->count : 0;
        }

        // =====================================================
        // LINE CHART: Monthly revenue vs. monthly items sold (9 months)
        //
        // WHY two datasets?
        // The original design shows two lines: "Mobile apps" vs "Websites"
        // We repurpose these as "Revenue (Rp/1000)" vs "Items Sold (qty)"
        // Using JSON encoding to pass PHP arrays directly to Chart.js
        // =====================================================

        $monthlyRevenue = Sale::where('sale_date', '>=', $nineMonthsAgo)
            ->selectRaw('MONTH(sale_date) as month, YEAR(sale_date) as year, SUM(total_price) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT));

        $monthlyItems = SaleDetail::whereHas('sale', fn($q) => $q->where('sale_date', '>=', $nineMonthsAgo))
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->selectRaw('MONTH(sales.sale_date) as month, YEAR(sales.sale_date) as year, SUM(sale_details.sales_quantity) as qty')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT));

        $lineLabels   = [];
        $lineRevenue  = [];
        $lineItemsQty = [];
        for ($i = 8; $i >= 0; $i--) {
            $dt    = $now->copy()->subMonths($i);
            $key   = $dt->year . '-' . str_pad($dt->month, 2, '0', STR_PAD_LEFT);
            $lineLabels[]   = $dt->format('M');
            // Divide revenue by 1000 so the chart Y-axis is in "thousands Rp"
            $lineRevenue[]  = $monthlyRevenue->has($key) ? (int)round($monthlyRevenue[$key]->total / 1000) : 0;
            $lineItemsQty[] = $monthlyItems->has($key)   ? (int)$monthlyItems[$key]->qty : 0;
        }

        // =====================================================
        // RECENT SALES TIMELINE (last 6 sales transactions)
        //
        // WHY with('saleDetails.product')?
        // This is EAGER LOADING — it prevents N+1 query problem.
        // Without with(): Laravel runs 1 query to get 6 sales, then
        //   6 queries to get each sale's details, then 6*N queries for products.
        // With with(): only 3 total queries (sales, sale_details, products).
        // =====================================================
        $recentSales = Sale::with(['saleDetails.product'])
            ->latest('sale_date')
            ->take(6)
            ->get();

        // =====================================================
        // TOP SELLING PRODUCTS (by total quantity sold)
        // =====================================================
        $topProducts = SaleDetail::selectRaw('serial_number_product, SUM(sales_quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('serial_number_product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with(['product' => fn($q) => $q->select('serial_number', 'name', 'type')])
            ->get();

        return view('dashboard.index', [
            'title'              => 'Dashboard',

            // Stat cards
            'todayRevenue'       => $todayRevenue,
            'revenueChange'      => $revenueChange,
            'totalProducts'      => $totalProducts,
            'lowStockCount'      => $lowStockCount,
            'thisMonthSalesCount'=> $thisMonthSalesCount,
            'salesCountChange'   => $salesCountChange,
            'thisMonthRevenue'   => $thisMonthRevenue,
            'revenueMonthChange' => $revenueMonthChange,

            // Chart data (will be JSON-encoded in Blade with @json())
            'barLabels'          => $barLabels,
            'barData'            => $barData,
            'lineLabels'         => $lineLabels,
            'lineRevenue'        => $lineRevenue,
            'lineItemsQty'       => $lineItemsQty,

            // Timeline & tables
            'recentSales'        => $recentSales,
            'topProducts'        => $topProducts,
        ]);
    }

    // All other resource methods removed — Dashboard doesn't need create/edit/delete.
    // We keep the file as a ResourceController only for the index route.
}
