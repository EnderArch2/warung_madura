<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseDetail;
use App\Models\Purchase;
use App\Models\Product;

class PurchaseDetailSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PurchaseDetail::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $purchases = Purchase::all();
        $products = Product::all();

        foreach ($purchases as $purchase) {
            $numProducts = min(rand(2, 4), $products->count());
            $selectedProducts = $products->random($numProducts);

            foreach ($selectedProducts as $product) {
                PurchaseDetail::create([
                    'note_number_purchase' => $purchase->note_number,
                    'serial_number_product' => $product->serial_number,
                    'purchase_price' => $product->price * 0.7,
                    'selling_margin' => 30,
                    'purchase_amount' => rand(10, 50),
                    'subtotal' => ($product->price * 0.7) * rand(10, 50),
                ]);
            }
        }
    }
}
