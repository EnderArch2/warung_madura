<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderDetail::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            $numProducts = min(rand(1, 3), $products->count());
            $selectedProducts = $products->random($numProducts);

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 10);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'serial_number_product' => $product->serial_number,
                    'selling_price' => $product->price,
                    'sales_quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                    'note' => 'Order detail for ' . $product->name,
                ]);
            }
        }
    }
}
