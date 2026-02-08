<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call all required seeders
        $this->call([
            AdminUserSeeder::class,
            PermissionSeeder::class,
            SectionSeeder::class,
            DesignationSeeder::class,
            DepartmentSeeder::class,
            CountrySeeder::class,
            DistrictSeeder::class,
            BankSeeder::class,
            UnitSeeder::class,
            DivisionSeeder::class,
            EducationSeeder::class,
            InsuranceSeeder::class,

        ]);
    }
    
}
