<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            'Accounts & Finance',
            'Admin & HR',
            'Admin, HR & Compliance',
            'Civil',
            'Division',
            'Environment Management & Sutainability',
            'G M T Planning',
            'GARMENTS',
            'H/O',
            'Head Office',
            'HOFD',
            'IE',
            'IE & Planning, Workstudy',
            'Maintenance',
            'Merchandising',
            'Missing',
            'Norban Fishion',
            'Operation',
            'Planning',
            'Planning & IE Department',
            'PRINTING & EMBROIDERY',
            'Procurement',
            'Store',
            'TEXTILE',
            'TEXTILE Planning',
        ];

        foreach ($divisions as $name) {
            Division::create(['name' => $name]);
        }
    }
}
