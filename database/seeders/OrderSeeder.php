<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $customers = User::where('role', 'customer')->get();

        $orders = [
            [
                'user_id' => $customers->first()->id,
                'order_date' => Carbon::now()->subDays(30),
                'total_price' => 250000,
                'status' => 'finished',
                'payment_method' => 'transfer',
            ],
            [
                'user_id' => $customers->get(1)->id,
                'order_date' => Carbon::now()->subDays(20),
                'total_price' => 180000,
                'status' => 'shipped',
                'payment_method' => 'transfer',
            ],
            [
                'user_id' => $customers->get(2)->id,
                'order_date' => Carbon::now()->subDays(10),
                'total_price' => 320000,
                'status' => 'processed',
                'payment_method' => 'cash on delivery',
            ],
            [
                'user_id' => $customers->first()->id,
                'order_date' => Carbon::now()->subDays(5),
                'total_price' => 150000,
                'status' => 'pending',
                'payment_method' => 'transfer',
            ],
            [
                'user_id' => $customers->get(1)->id,
                'order_date' => Carbon::now()->subDays(2),
                'total_price' => 420000,
                'status' => 'ordered',
                'payment_method' => 'cash on delivery',
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
