<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'Accessories Store',
            'Accounts & Audit',
            'Accounts & Finance',
            'Admin',
            'Admin & HR',
            'Admin, HR & Compliance',
            'APW',
            'Audit',
            'Batch',
            'Boiler',
            'Brushing & Sueding',
            'CAD',
            'Chemical Store',
            'Circular Knitting',
            'Civil',
            'Commercial',
            'Compliance & HR',
            'Compliance, Fire & Safety',
            'Cutting',
            'Development',
            'Drawstring',
            'Dyeing',
            'Dyeing Finishing',
            'Electrical',
            'Embroidery',
            'Environment',
            'ETP',
            'Finish Fabric',
            'Finishing',
            'Finishing-Textile',
            'Fire & Safety',
            'Flat Knitting',
            'G M T Finishing',
            'G M T Planning',
            'G. Maintenance',
            'General',
            'General Store',
            'Grey Store',
            'HAC',
            'Heat Seal',
            'I E',
            'I T',
            'IE & PPC',
            'IE & Work-study',
            'Industrial Engineer',
            'Input',
            'Input Matching',
            'Knitting',
            'Lab',
            'Lab & R&D',
            'R&D',
            'Maintenance',
            'Medical',
            'Merchandising',
            'M I S',
            'Operation',
            'Physical Lab',
            'Planning',
            'Planning & IE Department',
            'Printing',
            'Printing & Embroidery',
            'Procurement',
            'Production',
            'Purchase',
            'Quality',
            'Quality-Textile',
            'Sample',
            'Section',
            'Security',
            'Sewing',
            'Sourcing',
            'Store',
            'Sub Store',
            'Textile Batch',
            'Textile Brushing & Seeding',
            'Textile Dyeing',
            'Textile Finishing',
            'Textile Quality',
            'Textile Yarn Dyeing',
            'Trainee Officer',
            'Work Study',
            'Yarn & Fabric Store',
            'Yarn Dyeing',
            'Yarn Store',
        ];

        foreach ($sections as $name) {
            Section::create(['name' => $name]);
        }
    }
}
