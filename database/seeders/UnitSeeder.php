<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'name' => 'Head Office',
                'address' => 'House# 8/B, Road# 1, Gulshan-1, Dhaka-1212, Bangladesh.',
                'email' => 'info@norbangroup.com',
                'phone' => '9666707635',
            ],
            [
                'name' => 'Hornbill Apparel Ltd.',
                'address' => 'এস. এ. প্লট নং- ৩১০, বাইমাইল, কাশেম কটন মিলস, কোনাবাড়ী, গাজীপুর',
                'email' => 'info@norbangroup.com',
                'phone' => '9666910012',
            ],
            [
                'name' => 'NCL Contractual Worker',
                'address' => 'হোল্ডিং নং: ১৮১, ব্লক-এ,তেতুইবাড়ি, কাশিমপুর, গাজীপুর-১৭০০, বাংলাদেশ',
                'email' => 'info@norbancgroup.com',
                'phone' => '9666701701',
            ],
            [
                'name' => 'Norban Comtex Ltd.',
                'address' => 'হোল্ডিং নং: ১৮১, ব্লক-এ,তেতুইবাড়ি, কাশিমপুর, গাজীপুর-১৭০০, বাংলাদেশ',
                'email' => 'info@norbancgroup.com',
                'phone' => '9666701701',
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
