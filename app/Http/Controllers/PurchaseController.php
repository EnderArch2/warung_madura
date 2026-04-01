<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    /**
     * Display a paginated list of all purchases.
     */
    public function index()
    {
        // Eager load purchaseDetails and distributor to prevent N+1 queries
        $purchases = Purchase::with(['purchaseDetails', 'distributor'])
                             ->latest('purchase_date')
                             ->paginate(10);

        return view('purchases.index', [
            'title'     => 'Purchases',
            'purchases' => $purchases,
        ]);
    }

    /**
     * Show the form for creating a new purchase order.
     */
    public function create()
    {
        // Get all distributors and products for dropdowns
        $distributors = Distributor::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $productsList = $products->map(function($p) {
            return [
                'serial' => $p->serial_number,
                'name'   => $p->name,
                'price'  => $p->price,
                'stock'  => $p->stock
            ];
        })->toArray();

        return view('purchases.create', [
            'title'        => 'Purchases',
            'distributors' => $distributors,
            'productsList' => $productsList,
        ]);
    }

    /**
     * Store a newly created purchase in the database.
     * Handles multi-item purchase with stock increment.
     */
    public function store(Request $request)
    {
        // Validate the incoming array of products
        $request->validate([
            'purchase_date'       => 'required|date',
            'distributor_id'      => 'required|integer|exists:distributors,id',
            'product_serial'      => 'required|array|min:1',
            'product_serial.*'    => 'required|string|exists:products,serial_number',
            'purchase_price'      => 'required|array|min:1',
            'purchase_price.*'    => 'required|integer|min:1',
            'selling_margin'      => 'required|array|min:1',
            'selling_margin.*'    => 'required|integer|min:0',
            'purchase_amount'     => 'required|array|min:1',
            'purchase_amount.*'   => 'required|integer|min:1',
        ], [
            'product_serial.required' => 'You must add at least one product to the purchase.',
            'product_serial.*.exists' => 'Selected product is invalid.',
        ]);

        DB::beginTransaction();

        try {
            // Generate unique note_number for this purchase
            $noteNumber = $this->generateNoteNumber();

            // Create the Purchase Header with temporary total
            $purchase = Purchase::create([
                'note_number'   => $noteNumber,
                'purchase_date' => $request->purchase_date,
                'distributor_id' => $request->distributor_id,
                'total_price'   => 0,
            ]);

            $grandTotal = 0;

            // Loop through each submitted product row
            foreach ($request->product_serial as $index => $serial) {
                $purchasePrice = $request->purchase_price[$index];
                $sellingMargin = $request->selling_margin[$index];
                $quantity = $request->purchase_amount[$index];

                // Fetch the product for validation and stock update
                $product = Product::where('serial_number', $serial)->firstOrFail();

                // Calculate selling price from purchase price + margin
                $sellingPrice = $purchasePrice + $sellingMargin;
                $subtotal = $purchasePrice * $quantity;
                $grandTotal += $subtotal;

                // Create the Purchase Detail line item
                PurchaseDetail::create([
                    'note_number_purchase'   => $noteNumber,
                    'serial_number_product'  => $product->serial_number,
                    'purchase_price'         => $purchasePrice,
                    'selling_margin'         => $sellingMargin,
                    'purchase_amount'        => $quantity,
                    'subtotal'               => $subtotal,
                ]);

                // Increment the product's stock (receiving goods)
                $product->increment('stock', $quantity);

                // Update product price with selling price
                $product->update(['price' => $sellingPrice]);
            }

            // Update the Purchase Header with the final calculated total
            $purchase->update(['total_price' => $grandTotal]);

            DB::commit();

            return redirect()->route('purchases.show', ['purchase' => $purchase->note_number])
                           ->with('success', 'Purchase order #' . $noteNumber . ' recorded successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to record purchase: ' . $e->getMessage());
        }
    }

    /**
     * Display a specific purchase's line items (detailed receipt view).
     */
    public function show(string $id)
    {
        // Find by note_number instead of id
        $purchase = Purchase::where('note_number', $id)
                           ->with(['purchaseDetails.product', 'distributor'])
                           ->firstOrFail();

        return view('purchases.show', [
            'title'    => 'Purchases',
            'purchase' => $purchase,
        ]);
    }

    /**
     * Remove a purchase order and restore stock to products.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::where('note_number', $id)->firstOrFail();

        DB::beginTransaction();

        try {
            // Restore stock for all purchased items
            foreach ($purchase->purchaseDetails as $detail) {
                if ($detail->product) {
                    $detail->product->decrement('stock', $detail->purchase_amount);
                }
            }

            // Delete details first (in case there's no CASCADE DELETE)
            $purchase->purchaseDetails()->delete();
            $purchase->delete();

            DB::commit();
            return redirect()->route('purchases.index')
                           ->with('success', 'Purchase deleted and stock restored successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete purchase: ' . $e->getMessage());
        }
    }

    /**
     * Generate a unique note_number for purchases.
     * Format: PUR-YYYYMMDD-XXXX (e.g., PUR-20260401-0001)
     */
    private function generateNoteNumber()
    {
        $date = date('Ymd');
        $prefix = 'PUR-' . $date . '-';

        // Count existing purchase notes for today
        $count = Purchase::where('note_number', 'like', $prefix . '%')
                        ->count();

        return $prefix . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
