<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            'Bangladesh',
            'India',
            'Pakistan',
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['name' => $country],
                ['status' => 1] // use 1 instead of 'active'
            );
        }

        $this->command->info('Countries seeded successfully.');
    }
}
