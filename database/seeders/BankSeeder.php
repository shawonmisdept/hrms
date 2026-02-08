<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BankSeeder extends Seeder
{
    public function run()
    {
        $banks = [
            ['name' => 'Brac Bank Limited', 'short_name' => 'Brac'],
            ['name' => 'Janata Bank Limited', 'short_name' => 'Janata'],
            ['name' => 'Sonali Bank Limited', 'short_name' => 'Sonali'],
            ['name' => 'Agrani Bank Limited', 'short_name' => 'Agrani'],
            ['name' => 'Rupali Bank Limited', 'short_name' => 'Rupali'],
            ['name' => 'Bangladesh Krishi Bank', 'short_name' => 'Krishi'],
            ['name' => 'Rajshahi Krishi Unnayan Bank', 'short_name' => 'RKUB'],
            ['name' => 'AB Bank Limited', 'short_name' => 'AB Bank'],
            ['name' => 'Dutch-Bangla Bank Limited', 'short_name' => 'DBBL'],
            ['name' => 'Eastern Bank Limited', 'short_name' => 'EBL'],
            ['name' => 'Prime Bank Limited', 'short_name' => 'Prime Bank'],
            ['name' => 'Southeast Bank Limited', 'short_name' => 'Southeast'],
            ['name' => 'Trust Bank Limited', 'short_name' => 'Trust Bank'],
            ['name' => 'NRB Bank Limited', 'short_name' => 'NRB'],
            ['name' => 'Bank Asia Limited', 'short_name' => 'Bank Asia'],
            ['name' => 'The City Bank Limited', 'short_name' => 'City Bank'],
            ['name' => 'Mutual Trust Bank Limited', 'short_name' => 'MTB'],
            ['name' => 'EXIM Bank Limited', 'short_name' => 'EXIM'],
            ['name' => 'Standard Bank Limited', 'short_name' => 'Standard Bank'],
            ['name' => 'Uttara Bank Limited', 'short_name' => 'Uttara Bank'],
            ['name' => 'NCC Bank Limited', 'short_name' => 'NCC Bank'],
            ['name' => 'First Security Islami Bank Limited', 'short_name' => 'FSIBL'],
            ['name' => 'Social Islami Bank Limited', 'short_name' => 'SIBL'],
            ['name' => 'Midland Bank Limited', 'short_name' => 'Midland'],
            ['name' => 'Modhumoti Bank Limited', 'short_name' => 'Modhumoti'],
            ['name' => 'NRB Global Bank Limited', 'short_name' => 'NRB Global'],
            ['name' => 'Islami Bank Bangladesh Limited', 'short_name' => 'IBBL'],
            ['name' => 'Al-Arafah Islami Bank Limited', 'short_name' => 'Al-Arafah'],
            ['name' => 'Shahjalal Islami Bank Limited', 'short_name' => 'SJIBL'],
            ['name' => 'Union Bank Limited', 'short_name' => 'Union Bank'],
            ['name' => 'Standard Chartered Bank', 'short_name' => 'SCB'],
            ['name' => 'Citibank N.A', 'short_name' => 'Citi'],
            ['name' => 'Habib Bank Limited', 'short_name' => 'Habib'],
            ['name' => 'National Bank of Pakistan', 'short_name' => 'NBP'],
            ['name' => 'Woori Bank', 'short_name' => 'Woori'],
            ['name' => 'HSBC', 'short_name' => 'HSBC'],
            
        ];

        foreach ($banks as $bank) {
            DB::table('banks')->insert([
                'name' => $bank['name'],
                'short_name' => $bank['short_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
