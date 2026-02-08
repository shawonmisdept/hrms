<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankBranch;
use App\Models\Bank;

class BracBranchesSeeder extends Seeder
{
    public function run(): void
    {
        // Step 1: BRAC ব্যাংক এর ID খুঁজে বের করা
        $bracBank = Bank::where('name', 'Brac Bank Limited')->first();

        // যদি না থাকে তাহলে আগে ইনসার্ট করে নেই
        if (!$bracBank) {
            $bracBank = Bank::create([
                'name' => 'Brac Bank Limited',
                'status' => 1,
            ]);
        }

        // Step 2: ব্রাঞ্চগুলোর নাম
        $branches = [
            'BARISAL BRANCH',
            'BHOLA BRANCH',
            'JHALKATHI SME/KRISHI BRANCH',
            'PATUAKHALI BRANCH',
            'PIROJPUR SME/KRISHI BRANCH',
            'BRAHMANBARIA SME/KRISHI BRANCH',
            'CHANDPUR SME/KRISHI BRANCH',
            'AGRABAD BRANCH',
            'BAHADDERHAT SMESC',
            'HATHAZARI SME/KRISHI BRANCH',
            'KHATUNGANJ SMESC',
            'LOHAGARA SME/KRISHI BRANCH',
            'COMILLA SME/KRISHI BRANCH',
            'GOURIPUR SME/KRISHI BRANCH',
            'COX\'S BAZAR BRANCH',
            'FENI SME/KRISHI BRANCH',
            'LAXMIPUR SME/KRISHI BRANCH',
            'MAIJDI SME/KRISHI BRANCH',
            'CHOKORIA SME/KRISHI BRANCH',
            'ASAD GATE BRANCH',
            'BANANI BRANCH',
            'BIJOYNAGAR SMESC',
            'GANAKBARI BRANCH',
            'GRAPHICS BUILDING BRANCH',
            'GULSHAN BRANCH',
            'KERANIGANJ BRANCH',
            'MIRPUR BRANCH',
            'MOTIJHEEL BRANCH',
            'RAMPURA BRANCH',
            'SATMASJID ROAD BRANCH',
            'UTTARA JASHIM UDDIN AVENUE BRANCH',
            'BADDA SMESC',
            'BASHUNDHARA BRANCH',
            'JATRABARI SMESC',
            'KARWANBAZAR BRANCH',
            'ISLAMPUR BRANCH',
            'DHANMONDI BRANCH',
            'SAVAR BRANCH',
            'UTTARA BRANCH',
            'FARIDPUR SME/KRISHI BRANCH',
            'BOARD BAZAR BRANCH',
            'KONABARI SME/KRISHI BRANCH',
            'TONGI BRANCH',
            'GOPALGANJ SME/KRISHI BRANCH',
            'KISHOREGONJ SME/KRISHI BRANCH',
            'MADARIPUR SME/KRISHI BRANCH',
            'SHIBCHAR BRANCH',
            'MANIKGONJ BRANCH',
            'MUNSHIGONJ BRANCH',
            'NARAYANGANJ BRANCH',
            'NARSHINGDI BRANCH',
            'RAJBARI SME/KRISHI BRANCH',
            'BHADERGANJ BRANCH',
            'TANGAIL BRANCH',
            'BAGERHAT SME/KRISHI BRANCH',
            'CHUADANGA SME/KRISHI BRANCH',
            'JESSORE BRANCH',
            'JHENAIDAH SME/KRISHI BRANCH',
            'KHULNA BRANCH',
            'KUSHTIA SME/KRISHI BRANCH',
            'MAGURA SME/KRISHI BRANCH',
            'SATKHIRA BRANCH',
            'JAMALPUR BRANCH',
            'MYMENSINGH BRANCH',
            'NETROKONA SME/KRISHI BRANCH',
            'SHERPUR SME/KRISHI BRANCH',
            'BOGRA BRANCH',
            'CHAPAINAWABGONJ SME/KRISHI BRANCH',
            'JOYPURHAT SME/KRISHI BRANCH',
            'NAOGAON SME/KRISHI BRANCH',
            'NATORE BRANCH',
            'PABNA SME/KRISHI BRANCH',
            'RAJSHAHI BRANCH',
            'SIRAJGONJ SME/KRISHI BRANCH',
            'DINAJPUR SME/KRISHI BRANCH',
            'GOBINDAGONJ SME/KRISHI BRANCH',
            'SYEDPUR BRANCH',
            'PANCHAGAR SME/KRISHI BRANCH',
            'RANGPUR BRANCH',
            'THAKURGAON SME/KRISHI BRANCH',
            'HOBIGONJ BRANCH',
            'MOULVIBAZAR BRANCH',
            'SUNAMGONJ BRANCH',
            'BONDOR SMESC',
            'SYLHET BRANCH',
            'ELEPHANT ROAD BRANCH',
            'BENAPOLE BRANCH',
            'BARO BAZAR BRANCH',
            'KHULNA BRANCH',
            'ELEPHANT ROAD BRANCH',
            'IMAMGONJ BRANCH',
            'UTTARA BRANCH',
            'MIRPUR SECTION -1 BRANCH',
            'MAWNA BRANCH',
            'JOYDEBPUR BRANCH',
            'ASHULIA BRANCH',
            'BANDARTILA SMESC',
            'MOMIN ROAD BRANCH',
            'MADHABDI BRANCH',
            'Sadarghat SMESC',
            'SHAJADPUR SME/KRISHI BRANCH',
        ];

        // Step 3: প্রতিটি ব্রাঞ্চ ইনসার্ট করা
        foreach ($branches as $branch) {
            BankBranch::create([
                'name' => $branch,
                'bank_id' => $bracBank->id,
                'status' => 1,
            ]);
        }
    }
}
