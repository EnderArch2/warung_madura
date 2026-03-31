<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expedition;

class ExpeditionSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Expedition::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $expeditions = [
            [
                'name' => 'JNE',
                'address' => 'Jl. Jend. Ahmad Yani No. 123, Jakarta Timur',
                'phone_number' => '1500-888',
            ],
            [
                'name' => 'Tiki',
                'address' => 'Jl. Benda No. 1, Jakarta Pusat',
                'phone_number' => '1500-100',
            ],
            [
                'name' => 'Pos Indonesia',
                'address' => 'Jl. Pos Barat No. 1, Jakarta Pusat',
                'phone_number' => '1500-555',
            ],
            [
                'name' => 'Grab Express',
                'address' => 'Menara Hijau, Jl. Mega Kuningan, Jakarta',
                'phone_number' => '1500-008',
            ],
            [
                'name' => 'GoSend',
                'address' => 'Graha Bumiputera, Jl. Gatot Subroto Kav. 42, Jakarta',
                'phone_number' => '1500-555',
            ],
        ];

        foreach ($expeditions as $expedition) {
            Expedition::create($expedition);
        }
    }
}
