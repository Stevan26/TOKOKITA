<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data user lama agar tidak duplikat saat diseed ulang
        User::truncate();

        // 1. Akun Admin
        User::create([
            'name'     => 'Admin Tokokita',
            'email'    => 'admin@tokokita.com',
            'role'     => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // 2. Akun Customer
        User::create([
            'name'     => 'Budi Customer',
            'email'    => 'budi@gmail.com',
            'role'     => 'customer',
            'password' => Hash::make('password123'),
        ]);
    }
}
