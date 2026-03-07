<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;

/**
 * SaleSeeder — creates realistic 9-month sales data for the dashboard charts.
 *
 * Strategy:
 * - Generate sales for Mar–Nov 2025 (9 months) so the charts show a trend
 * - Each month has multiple sale transactions with varying quantities
 * - Products use serial_number_product matching seeds from ProductSeeder
 *
 * Run with:  php artisan db:seed --class=SaleSeeder
 */
class SaleSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SaleDetail::truncate();
        Sale::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /**
         * Monthly sales data — each entry defines:
         *   'date'    → the sale_date for this transaction
         *   'items'   → array of [serial_number, selling_price, quantity]
         *
         * We deliberately make later months have higher totals to create
         * an upward trend line on the "Sales Overview" chart.
         */
        $monthlySales = [
            // March 2025 — low sales (store just starting)
            ['date' => '2025-03-05', 'items' => [['PRD-001', 3500, 10], ['PRD-002', 3000, 8]]],
            ['date' => '2025-03-15', 'items' => [['PRD-003', 5000, 5], ['PRD-005', 3200, 12]]],

            // April 2025
            ['date' => '2025-04-03', 'items' => [['PRD-001', 3500, 15], ['PRD-004', 8500, 6]]],
            ['date' => '2025-04-18', 'items' => [['PRD-006', 2500, 20], ['PRD-007', 6000, 8]]],
            ['date' => '2025-04-25', 'items' => [['PRD-002', 3000, 10], ['PRD-008', 12000, 4]]],

            // May 2025
            ['date' => '2025-05-02', 'items' => [['PRD-001', 3500, 20], ['PRD-009', 5500, 10]]],
            ['date' => '2025-05-12', 'items' => [['PRD-003', 5000, 8], ['PRD-010', 14000, 5]]],
            ['date' => '2025-05-28', 'items' => [['PRD-005', 3200, 18], ['PRD-004', 8500, 7]]],

            // June 2025 — slight dip
            ['date' => '2025-06-06', 'items' => [['PRD-001', 3500, 12], ['PRD-002', 3000, 14]]],
            ['date' => '2025-06-20', 'items' => [['PRD-006', 2500, 15], ['PRD-007', 6000, 9]]],

            // July 2025 — recovery
            ['date' => '2025-07-04', 'items' => [['PRD-001', 3500, 25], ['PRD-003', 5000, 12]]],
            ['date' => '2025-07-17', 'items' => [['PRD-004', 8500, 10], ['PRD-008', 12000, 6]]],
            ['date' => '2025-07-30', 'items' => [['PRD-009', 5500, 15], ['PRD-010', 14000, 8]]],

            // August 2025 — peak
            ['date' => '2025-08-08', 'items' => [['PRD-001', 3500, 35], ['PRD-002', 3000, 25]]],
            ['date' => '2025-08-18', 'items' => [['PRD-005', 3200, 30], ['PRD-006', 2500, 20]]],
            ['date' => '2025-08-29', 'items' => [['PRD-003', 5000, 18], ['PRD-004', 8500, 12]]],

            // September 2025
            ['date' => '2025-09-10', 'items' => [['PRD-007', 6000, 15], ['PRD-008', 12000, 8]]],
            ['date' => '2025-09-22', 'items' => [['PRD-001', 3500, 30], ['PRD-009', 5500, 20]]],

            // October 2025
            ['date' => '2025-10-05', 'items' => [['PRD-001', 3500, 40], ['PRD-002', 3000, 30]]],
            ['date' => '2025-10-14', 'items' => [['PRD-004', 8500, 14], ['PRD-005', 3200, 25]]],
            ['date' => '2025-10-25', 'items' => [['PRD-010', 14000, 10], ['PRD-003', 5000, 20]]],

            // November 2025 — highest month
            ['date' => '2025-11-03', 'items' => [['PRD-001', 3500, 50], ['PRD-002', 3000, 40]]],
            ['date' => '2025-11-12', 'items' => [['PRD-006', 2500, 30], ['PRD-007', 6000, 20]]],
            ['date' => '2025-11-20', 'items' => [['PRD-008', 12000, 10], ['PRD-009', 5500, 25]]],
            ['date' => '2025-11-28', 'items' => [['PRD-003', 5000, 25], ['PRD-004', 8500, 15]]],
        ];

        foreach ($monthlySales as $saleData) {
            // Calculate total price for this sale from line items
            $totalPrice = 0;
            foreach ($saleData['items'] as [$serial, $price, $qty]) {
                $totalPrice += $price * $qty;
            }

            // Create the Sale header record
            $sale = Sale::create([
                'sale_date'   => $saleData['date'],
                'total_price' => $totalPrice,
            ]);

            // Create SaleDetail rows for each product in this transaction
            foreach ($saleData['items'] as [$serial, $price, $qty]) {
                SaleDetail::create([
                    'sale_id'               => $sale->id,
                    'serial_number_product' => $serial,
                    'selling_price'         => $price,
                    'sales_quantity'        => $qty,
                    'subtotal'              => $price * $qty,
                ]);
            }
        }

        $this->command->info('✅ SaleSeeder: ' . count($monthlySales) . ' sales transactions seeded across 9 months.');
    }
}
