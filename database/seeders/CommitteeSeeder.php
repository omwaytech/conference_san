<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('committees')->insert([
            ['committee_name' => 'Organizing Committee', 'slug' => 'organizing-committe', 'created_at' => now(), 'updated_at' => now()],
            ['committee_name' => 'Scientific Committee', 'slug' => 'scientific-committe', 'created_at' => now(), 'updated_at' => now()],
            ['committee_name' => 'Finance Committee', 'slug' => 'finance-committe', 'created_at' => now(), 'updated_at' => now()],
            ['committee_name' => 'Registration Committee', 'slug' => 'registration-committe', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
