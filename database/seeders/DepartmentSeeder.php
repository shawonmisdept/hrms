<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Accounts & Finance',
            'Admin',
            'Admin HR& Compliance',
            'Admin & HR',
            'Audit',
            'Batch',
            'Brushing & Sueding',
            'Civil',
            'Commercial',
            'Compliance, Fire & Safety',
            'Cutting',
            'Development',
            'Dyeing',
            'Dyeing & Finishing',
            'Dyeing Finishing',
            'Embroidary',
            'Environment Management & Sustainability',
            'Finishing',
            'Fire & Safety',
            'G M T Ca D',
            'G M T Cutting',
            'G M T Finishing',
            'G M T Planning',
            'G M T Production',
            'G M T Quality',
            'G M T Sample',
            'G M T Sewing',
            'Head Office',
            'Hornbill',
            'HR & Compliance',
            'HRD',
            'I E',
            'I T',
            'IE & PPC',
            'Knitting',
            'Knitting, Dyeing & Finishing',
            'Lab',
            'Lab & R & D',
            'M I S',
            'Maintenance',
            'Medical',
            'Merchandising',
            'Operation',
            'Planning',
            'Planning & IE Department',
            'Printing',
            'Printing & Embroidary',
            'Procurement',
            'Production',
            'Purchase',
            'Quality',
            'R&D',
            'Sample',
            'Security',
            'Sewing',
            'Sourcing',
            'Store',
            'TEXTILE',
            'Textile Batch',
            'Textile Brushing & Sueding',
            'Textile Dyeing',
            'Textile Finishing',
            'Textile Planning',
            'Textile Quality',
            'Textile Yarn Dyeing',
            'Work Study',
            'Yarn Dyeing',
        ];

        foreach ($departments as $name) {
            Department::create(['name' => $name]);
        }
    }
}
