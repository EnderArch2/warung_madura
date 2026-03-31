<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Owner
        User::create([
            'name'                 => 'Pak Haji Owner',
            'email'                => 'owner@warungemadura.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'owner',
            'phone_number'         => '081234567890',
            'address'              => 'Jl. Raya Madura No. 1, Sampang',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        // Admins
        User::create([
            'name'                 => 'Ibu Siti Admin',
            'email'                => 'admin1@warungemadura.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'admin',
            'phone_number'         => '082134567890',
            'address'              => 'Jl. Pangkalan Bun, Sampang',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        User::create([
            'name'                 => 'Pak Darmawan Admin',
            'email'                => 'admin2@warungemadura.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'admin',
            'phone_number'         => '083134567890',
            'address'              => 'Jl. Garuda No. 5, Sampang',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        // Couriers
        User::create([
            'name'                 => 'Budi Kurir',
            'email'                => 'budi@warungemadura.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'courier',
            'phone_number'         => '081512345678',
            'address'              => 'Jl. Pesisir, Sampang',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        User::create([
            'name'                 => 'Ahmad Kurir',
            'email'                => 'ahmad@warungemadura.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'courier',
            'phone_number'         => '081612345678',
            'address'              => 'Jl. Industri, Sampang',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        // Customers
        User::create([
            'name'                 => 'Eka Pelanggan',
            'email'                => 'eka@gmail.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'customer',
            'phone_number'         => '081712345678',
            'address'              => 'Jl. Merdeka No. 10, Surabaya',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        User::create([
            'name'                 => 'Rini Pelanggan',
            'email'                => 'rini@gmail.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'customer',
            'phone_number'         => '081812345678',
            'address'              => 'Jl. Ahmad Yani No. 25, Surabaya',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);

        User::create([
            'name'                 => 'Hendra Pelanggan',
            'email'                => 'hendra@gmail.com',
            'password'             => Hash::make('password123'),
            'role'                 => 'customer',
            'phone_number'         => '081912345678',
            'address'              => 'Jl. Sungai Lamong No. 15, Surabaya',
            'is_active'            => true,
            'email_verified_at'    => now(),
        ]);
    }
}
