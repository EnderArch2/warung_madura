<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * $this->call() runs other Seeders in the order listed.
     * This is the "master" seeder — think of it as an orchestrator.
     * Order matters if seeders have foreign key dependencies
     * (e.g., ProductSeeder must run before SaleDetailSeeder).
     */
    public function run(): void
    {
        // Order matters! Foreign keys must be satisfied
        $this->call([
            UserSeeder::class,              // 1. Users (owner, admin, courier, customer)
            DistributorSeeder::class,       // 2. Distributors
            ExpeditionSeeder::class,        // 3. Expeditions
            ProductSeeder::class,           // 4. Products
            PurchaseSeeder::class,          // 5. Purchases (depends on Distributor)
            PurchaseDetailSeeder::class,    // 6. Purchase details (depends on Purchase, Product)
            OrderSeeder::class,             // 7. Orders (depends on User/Customer)
            OrderDetailSeeder::class,       // 8. Order details (depends on Order, Product)
            DeliverySeeder::class,          // 9. Deliveries (depends on Order, Expedition, User/Courier)
            SaleSeeder::class,              // 10. Sales (depends on Product)
            SaleDetailSeeder::class,        // 11. Sale details (depends on Sale, Product)
        ]);
    }
}

