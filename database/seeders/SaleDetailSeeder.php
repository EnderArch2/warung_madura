<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Database\Seeder;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Sale::all();
        $products = Product::all();

        foreach ($sales as $sale) {
            $numProducts = min(rand(1, 3), $products->count());
            $selectedProducts = $products->random($numProducts);

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 10);
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'serial_number_product' => $product->serial_number,
                    'selling_price' => $product->price,
                    'sales_quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ]);
            }
        }
    }
}
