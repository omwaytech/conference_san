<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
    */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DesignationSeeder::class,
            MemberTypeSeeder::class,
            CountrySeeder::class,
            NamePrefixSeeder::class,
            HallSeeder::class,
            CommitteeSeeder::class,
            ScientificSessionSeeder::class,
        ]);

    }
}
