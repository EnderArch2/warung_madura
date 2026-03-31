<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Distributor;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Purchase::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $distributors = Distributor::all();

        $purchases = [
            [
                'note_number' => 'PUR-001',
                'purchase_date' => Carbon::now()->subMonths(3),
                'distributor_id' => $distributors->first()->id,
                'total_price' => 500000,
            ],
            [
                'note_number' => 'PUR-002',
                'purchase_date' => Carbon::now()->subMonths(2),
                'distributor_id' => $distributors->get(1)->id,
                'total_price' => 750000,
            ],
            [
                'note_number' => 'PUR-003',
                'purchase_date' => Carbon::now()->subMonth(),
                'distributor_id' => $distributors->get(2)->id,
                'total_price' => 600000,
            ],
            [
                'note_number' => 'PUR-004',
                'purchase_date' => Carbon::now()->subWeeks(1),
                'distributor_id' => $distributors->get(3)->id,
                'total_price' => 450000,
            ],
            [
                'note_number' => 'PUR-005',
                'purchase_date' => Carbon::now()->subDays(2),
                'distributor_id' => $distributors->get(4)->id,
                'total_price' => 800000,
            ],
        ];

        foreach ($purchases as $purchase) {
            Purchase::create($purchase);
        }
    }
}
