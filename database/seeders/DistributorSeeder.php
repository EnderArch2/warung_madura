<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distributor;

class DistributorSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Distributor::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $distributors = [
            [
                'name' => 'PT. Indofood Sukses Makmur',
                'address' => 'Jl. Benda Raya No. 1, Jakarta',
                'phone_number' => '021-123-4567',
            ],
            [
                'name' => 'PT. Danone Indonesia',
                'address' => 'Jl. Arena Raya No. 3, Jakarta',
                'phone_number' => '021-234-5678',
            ],
            [
                'name' => 'PT. Unilever Indonesia',
                'address' => 'Jl. Jend. Sudirman Kav. 52-53, Jakarta',
                'phone_number' => '021-345-6789',
            ],
            [
                'name' => 'PT. Nestlé Indonesia',
                'address' => 'Jl. Raya Bogor Km 26, Ciracas, Jakarta',
                'phone_number' => '021-456-7890',
            ],
            [
                'name' => 'PT. Twin Dragon Indonesia',
                'address' => 'Jl. Matraman Raya No. 17, Jakarta',
                'phone_number' => '021-567-8901',
            ],
        ];

        foreach ($distributors as $distributor) {
            Distributor::create($distributor);
        }
    }
}
