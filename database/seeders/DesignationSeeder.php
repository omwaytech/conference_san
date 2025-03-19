<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designations')->insert([
            ['designation' => 'Organizing Chairperson', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Organizing Secretory', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'ASPA President', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Scientific Chairperson', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Joint Secretary', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Treasurer', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Joint Treasurer', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Vice President', 'created_at' => now(), 'updated_at' => now()],
            ['designation' => 'Member', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
