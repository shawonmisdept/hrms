<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $educations = [
            ['Alim', 'আলিম'],
            ['B B S', 'বি. বি. এস'],
            ['B. A', 'বি. এ'],
            ['B. Com', 'বি.কম'],
            ['B. Com (Hons.)', 'বি.কম (সম্মান)'],
            ['B. Sc', 'বি্. এস.সি'],
            ['B. Sc Engineer', 'বি.এস.সি ইঞ্জিনিয়ার'],
            ['B. Sc in Apparel Manufacture & Technology (AMT)', 'বি.এস.সি ইন এ্যাপারেল ম্যানুফ্যাকচার এন্ড টেকনোলজি(এ.টি.এম)'],
            ['B. Sc In Computer Science & En', 'কম্পিউটার সায়েন্সে বি.এস.সি এন্ড ইঞ্জিনিয়ার'],
            ['B.S.S', 'বি.এস.এস'],
            ['B.Sc in Apparel Merchandising', 'বি.এস.সি ইন এ্যাপারেল মার্চেন্ডাইজিং'],
            ['Bachelor of Science in Nursing', 'ব্যাচেলর অফ সায়েন্স ইন নার্সিং'],
            ['BBA', 'বি.বি.এ'],
            ['BSc in Civil', 'বি.এস.সি ইন সিভিল'],
            ['BSc in Computer', 'কম্পিউটারে বি.এস.সি'],
            ['BSc in Electrical & Electronics Engineering', 'ইলেকট্রিক্যাল অ্যান্ড ইলেকট্রনিক্স ইঞ্জিনিয়ারিংয়ে বি.এস.সি'],
            ['BSc in industrial & Production Eng.', 'বি.এস.সি ইন ইন্ডাস্ট্রিয়াল অ্যান্ড প্রোডাকশন ইঞ্জিনিয়ার'],
            ['BSc In Textile Engineering', 'টেক্সটাইল ইঞ্জিনিয়ারিংয়ে বি.এস.সি'],
            ['Bsc in Textile Technology', 'বি.এস.সি টেক্সটাইল টেকনোলজি'],
            ['C A', 'সি.এ'],
            ['Dhakhil', 'দাখিল'],
            ['Diploma Engineer', 'ডিপ্লোমা ইঞ্জিনিয়ার'],
            ['Diploma Engineer (Electrical)', 'ডিপ্লোমা ইঞ্জিনিয়ার (ইলেকট্রিক্যাল)'],
            ['Diploma In Agriculture', 'কৃষিতে ডিপ্লোমা'],
            ['Diploma In Computer Engineering', 'ডিপ্লোমা ইন কম্পিউটার ইঞ্জিনিয়ারিং'],
            ['Diploma In Industrial Engineer', 'ডিপ্লোমা ইন ইন্ডাস্ট্রিয়াল ইঞ্জিনিয়ার'],
            ['Diploma In Nursing Science and Midwifery', 'ডিপ্লোমা ইন নার্সিং সায়েন্স অ্যান্ড মিডওয়াইফারি'],
            ['Diploma In Textile', 'ডিপ্লোমা ইন টেক্সটাইল'],
            ['EIGHT', 'অষ্টম শ্রেণী'],
            ['Fazil', 'ফাজিল'],
            ['FIVE', 'পঞ্চম শ্রেণী'],
            ['FOUR', 'চতুর্থ শ্রেণী'],
            ['GRADUATE', 'স্নাতক'],
            ['H.S.C', 'এইচ.এস.সি'],
            ['J.S.C', 'জে.এস.সি.'],
            ['M. A', 'এম.এ'],
            ['M. B. S', 'এম.বি. এস'],
            ['M. Com', 'এম.কম'],
            ['M. S. S', 'এম.এস.এস'],
            ['M. Sc', 'এম.এস.সি'],
            ['M.A', 'এম. এ'],
            ['M.S.S', 'এম.এস.এস'],
            ['MASTERS', 'স্নাতকোত্তর'],
            ['MBA', 'এম.বি.এ'],
            ['MBBS', 'এম.বি.বি.এস'],
            ['NINE', 'নবম শ্রেণী'],
            ['One', 'প্রথম শ্রেণী'],
            ['P.S.C', 'পি.এস.সি.'],
            ['PRIMARY', 'প্রাথমিক'],
            ['S.S.C', 'এস.এস.সি'],
            ['SEVEN', 'সপ্তম শ্রেণী'],
            ['SIX', 'ষষ্ট শ্রেণী'],
            ['TEN', 'দশম শ্রেণী'],
            ['THREE', 'তৃতীয় শ্রেণী'],
            ['Two', 'দ্বিতীয় শ্রেণী'],
        ];

        foreach ($educations as [$name, $native_name]) {
            Education::create([
                'name' => $name,
                'native_name' => $native_name,
                'status' => true,
                'unit_id' => 11 // আপনি চাইলে এখানে ডাইনামিকভাবে ইউনিট আইডি বসাতে পারেন
            ]);
        }
    }
}
