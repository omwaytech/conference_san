<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ScientificSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('scientific_session_categories')->insert([
            ['category_name' => 'General', 'slug' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Airway', 'slug' => 'airway', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'NEURO-ANESTHESIA 1', 'slug' => 'neuro-anesthesia-1', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'GENERAL PEDIATRIC (ASPA SESSIONS)', 'slug' => 'general-pediatric', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'PEDIATRIC NEURO ANESTHESIA (ASPA SESSIONS)', 'slug' => 'pediatric-neuro-anesthesia', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'RESIDENTS’ POSTER SESSION', 'slug' => 'residents-poster-session', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
