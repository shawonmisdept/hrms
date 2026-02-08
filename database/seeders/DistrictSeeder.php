<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Country;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        // Find the country. Adjust this if needed.
        $bangladesh = Country::where('name', 'Bangladesh')->first();

        if (!$bangladesh) {
            $this->command->error('Bangladesh not found in countries table.');
            return;
        }

        $districts = [
            'Dhaka', 'Gazipur', 'Kishoreganj', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Tangail',
            'Faridpur', 'Gopalganj', 'Madaripur', 'Shariatpur', 'Chattogram (Chittagong)', 'Cox\'s Bazar', 'Bandarban',
            'Khagrachhari', 'Rangamati', 'Brahmanbaria', 'Chandpur', 'Cumilla (Comilla)', 'Feni', 'Lakshmipur', 'Noakhali',
            'Rajshahi', 'Naogaon', 'Natore', 'Chapainawabganj', 'Pabna', 'Sirajganj', 'Bogura (Bogra)', 'Joypurhat',
            'Khulna', 'Jashore (Jessore)', 'Narail', 'Jhenaidah', 'Magura', 'Kushtia', 'Chuadanga', 'Meherpur', 'Bagerhat',
            'Satkhira', 'Barishal (Barisal)', 'Jhalokathi', 'Pirojpur', 'Patuakhali', 'Bhola', 'Barguna', 'Sylhet',
            'Moulvibazar', 'Habiganj', 'Sunamganj', 'Rangpur', 'Dinajpur', 'Thakurgaon', 'Panchagarh', 'Kurigram',
            'Lalmonirhat', 'Gaibandha', 'Nilphamari', 'Mymensingh', 'Netrokona', 'Jamalpur', 'Sherpur'
        ];

        foreach ($districts as $district) {
            District::updateOrCreate(
                ['name' => $district, 'country_id' => $bangladesh->id],
                ['status' => 'active']
            );
        }

        $this->command->info('Districts seeded successfully.');
    }
}
