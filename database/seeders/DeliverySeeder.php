<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Expedition;
use Carbon\Carbon;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Delivery::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $orders = Order::where('status', '!=', 'pending')->get();
        $expeditions = Expedition::all();

        foreach ($orders as $order) {
            $orderDate = Carbon::parse($order->order_date);
            Delivery::create([
                'order_id' => $order->id,
                'expedition_id' => $expeditions->random()->id,
                'delivery_date' => $orderDate->addDay(),
                'picture_proof' => 'proof_' . $order->id . '.jpg',
                'invoice' => rand(100000, 999999),
            ]);
        }
    }
}
