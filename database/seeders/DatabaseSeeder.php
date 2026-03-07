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
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            ProductSeeder::class,
            SaleSeeder::class,  // Must run AFTER ProductSeeder — sale_details references products.serial_number
        ]);
    }
}

