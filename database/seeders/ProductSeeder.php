<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

/**
 * ProductSeeder — populates the products table with realistic sample data.
 *
 * WHY use a Seeder instead of inserting SQL manually?
 * - Seeders are version-controlled (committed to Git)
 * - Anyone who clones the project can run: php artisan db:seed
 *   to instantly get a working database with sample data
 * - You can re-seed at any time without losing the seed logic
 *
 * Run with:  php artisan db:seed --class=ProductSeeder
 * Or reset everything:  php artisan migrate:fresh --seed
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks so truncate works even if other tables reference products.
        // Re-enabled immediately after so database integrity is restored.
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = [
            [
                'serial_number'   => 'PRD-001',
                'name'            => 'Indomie Goreng',
                'type'            => 'Instant Noodles',
                'expiration_date' => '2026-12-31',
                'price'           => 3500,
                'stock'           => 200,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-002',
                'name'            => 'Aqua 600ml',
                'type'            => 'Bottled Water',
                'expiration_date' => '2026-06-30',
                'price'           => 3000,
                'stock'           => 150,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-003',
                'name'            => 'Teh Botol Sosro 450ml',
                'type'            => 'Bottled Drink',
                'expiration_date' => '2026-08-15',
                'price'           => 5000,
                'stock'           => 80,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-004',
                'name'            => 'Chitato Sapi Panggang',
                'type'            => 'Snacks',
                'expiration_date' => '2026-04-20',
                'price'           => 8500,
                'stock'           => 60,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-005',
                'name'            => 'Mie Sedaap Soto',
                'type'            => 'Instant Noodles',
                'expiration_date' => '2026-11-10',
                'price'           => 3200,
                'stock'           => 120,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-006',
                'name'            => 'Kopi Kapal Api',
                'type'            => 'Coffee',
                'expiration_date' => '2027-01-01',
                'price'           => 2500,
                'stock'           => 3,  // Low stock — will show red badge
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-007',
                'name'            => 'Biscuit Oreo',
                'type'            => 'Biscuits',
                'expiration_date' => '2026-09-30',
                'price'           => 6000,
                'stock'           => 5,  // Low stock — will show red badge
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-008',
                'name'            => 'ABC Sardine Saus Tomat',
                'type'            => 'Canned Food',
                'expiration_date' => '2028-03-01',
                'price'           => 12000,
                'stock'           => 40,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-009',
                'name'            => 'Susu Ultra Milk Full Cream',
                'type'            => 'Dairy',
                'expiration_date' => '2026-05-10',
                'price'           => 5500,
                'stock'           => 75,
                'picture'         => null,
            ],
            [
                'serial_number'   => 'PRD-010',
                'name'            => 'Gula Pasir 1kg',
                'type'            => 'Staples',
                'expiration_date' => null,   // No expiry — allowed because nullable in migration
                'price'           => 14000,
                'stock'           => 30,
                'picture'         => null,
            ],
        ];

        // insert() is faster than creating 10 individual Eloquent instances
        // because it generates a single INSERT INTO products (...) VALUES (...),(...),...
        // NOTE: insert() bypasses Eloquent events and does NOT auto-set created_at / updated_at
        // For that reason we use Product::create() in a loop here to stay Eloquent-friendly:
        foreach ($products as $data) {
            Product::create($data);
        }

        $this->command->info('✅ ProductSeeder: 10 products seeded successfully.');
    }
}
