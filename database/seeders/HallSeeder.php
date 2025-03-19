<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('halls')->insert([
            ['hall_name' => 'Hall A','created_at' => now(), 'updated_at' => now()],
            ['hall_name' => 'Hall B','created_at' => now(), 'updated_at' => now()],
            ['hall_name' => 'Hall C','created_at' => now(), 'updated_at' => now()],
            ['hall_name' => 'Hall D','created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
