<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insurance;

class InsuranceSeeder extends Seeder
{
    public function run()
{
    \App\Models\Insurance::create([
        'name' => 'General Health Insurance',
        'description' => 'Covers basic health expenses.',
        'coverage_amount' => 200000,
        'premium' => 5000,
        'provider_name' => 'Green Delta',
        'start_date' => now(),
        'end_date' => now()->addYear(),
        'status' => true,
        'created_by' => 1,
    ]);

    }
}
