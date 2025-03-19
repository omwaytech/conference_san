<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'f_name' => 'Admin',
                'email' => 'admin@admin.com',
                'role' => 1,
                'password' => Hash::make('password')
            ],
            [
                'f_name' => 'Omway Tech',
                'email' => 'info@omwaytech.com',
                'role' => 1,
                'password' => Hash::make('password'),
            ]
        ]);
    }
}
