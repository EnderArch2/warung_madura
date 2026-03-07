<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a paginated list of all sales.
     */
    public function index()
    {
        // Eager load saleDetails to easily count items per transaction
        $sales = Sale::with('saleDetails')->latest('sale_date')->paginate(10);
        
        return view('sales.index', [
            'title' => 'Sales History',
            'sales' => $sales,
        ]);
    }

    /**
     * Show the form for recording a new sale (POS style).
     */
    public function create()
    {
        // We need all products to populate the dropdowns in the dynamic form
        $products = Product::orderBy('name')->get();
        
        $productsList = $products->map(function($p) {
            return [
                'serial' => $p->serial_number,
                'name'   => $p->name,
                'price'  => $p->price,
                'stock'  => $p->stock
            ];
        })->toArray();
        
        return view('sales.create', [
            'title'        => 'Record New Sale',
            'productsList' => $productsList,
        ]);
    }

    /**
     * Store a newly created sale in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming array of products
        // We expect: product_serial[] and quantity[] arrays from the form
        $request->validate([
            'sale_date'          => 'required|date',
            'product_serial'     => 'required|array|min:1',
            'product_serial.*'   => 'required|string|exists:products,serial_number',
            'quantity'           => 'required|array|min:1',
            'quantity.*'         => 'required|integer|min:1',
        ], [
            'product_serial.required' => 'You must add at least one product to the sale.',
            'product_serial.*.exists' => 'Selected product is invalid.',
        ]);

        // 2. Use a Database Transaction
        // If anything fails (e.g., product not found, DB error), the whole transaction rolls back
        DB::beginTransaction();
        
        try {
            // First, create the Sale Header with a temporary 0 total
            $sale = Sale::create([
                'sale_date'   => $request->sale_date,
                'total_price' => 0,
            ]);

            $grandTotal = 0;

            // Loop through each submitted product row
            foreach ($request->product_serial as $index => $serial) {
                $quantity = $request->quantity[$index];
                
                // Fetch the product to get its current price & stock
                // (We do this securely on the backend so users can't manipulate prices)
                $product = Product::where('serial_number', $serial)->firstOrFail();
                
                $subtotal = $product->price * $quantity;
                $grandTotal += $subtotal;

                // Create the Sale Detail line item
                SaleDetail::create([
                    'sale_id'               => $sale->id,
                    'serial_number_product' => $product->serial_number,
                    'selling_price'         => $product->price,
                    'sales_quantity'        => $quantity,
                    'subtotal'              => $subtotal,
                ]);

                // Reduce the product's stock!
                $product->decrement('stock', $quantity);
            }

            // Update the Sale Header with the final calculated total
            $sale->update(['total_price' => $grandTotal]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sale transaction recorded successfully!');

        } catch (\Exception $e) {
            // Rollback everything if an error occurs
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to record sale: ' . $e->getMessage());
        }
    }

    /**
     * Display a specific sale's line items (receipt view).
     */
    public function show(Sale $sale)
    {
        // Eager load details and their associated products to prevent N+1
        $sale->load('saleDetails.product');
        
        return view('sales.show', [
            'title' => 'Sale Details #' . $sale->id,
            'sale'  => $sale,
        ]);
    }

    /**
     * Remove the specified sale from database.
     */
    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        
        try {
            // We should ideally restore stock when deleting a sale
            foreach ($sale->saleDetails as $detail) {
                if ($detail->product) {
                    // Restore the stock that was originally sold
                    $detail->product->increment('stock', $detail->sales_quantity);
                }
            }
            
            // Because our migrations probably don't have CASCADE DELETE on sale_details,
            // we manually delete the details first, then the sale header.
            $sale->saleDetails()->delete();
            $sale->delete();
            
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale deleted and stock restored successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete sale: ' . $e->getMessage());
        }
    }
}
