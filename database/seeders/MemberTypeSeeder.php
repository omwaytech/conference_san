<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MemberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('member_types')->insert([
            ['delegate' => 'National', 'type' => 'Life Member', 'created_at' => now(), 'updated_at' => now()],
            ['delegate' => 'National', 'type' => 'Associate Member', 'created_at' => now(), 'updated_at' => now()],
            ['delegate' => 'National', 'type' => 'Non Life Member', 'created_at' => now(), 'updated_at' => now()],
            ['delegate' => 'National', 'type' => 'Nepali Resident', 'created_at' => now(), 'updated_at' => now()],
            ['delegate' => 'International', 'type' => 'SAARC Delegates', 'created_at' => now(), 'updated_at' => now()],
            ['delegate' => 'International', 'type' => 'Non SAARC Delegates', 'created_at' => now(), 'updated_at' => now()],
            ['delegate' => 'International', 'type' => 'Resident SAARC', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
