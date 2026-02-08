<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            'A G M',
            'A G M Production',
            'A. P. M',
            'A.G.M (Planning & Production)',
            'A/C Operator',
            'A/c Technician',
            'Admin Assistant',
            'Admin Coordinator',
            'AGM (Head of Production, Finishing & Shipment)',
            'AGM (Head Of Quality)',
            'AGM- Head of ( IT/MIS)',
            'Assist. Technician (Mechanical)',
            'Assistant',
            'Assistant Manager',
            'Assistant ( Fire & Safety)',
            'Assistant (Sticker)',
            'Assistant Cook',
            'Assistant E. T. P',
            'Assistant Manager ( E T P)',
            'Assistant manager (Quality)',
            'Assistant Manager (Shipment)',
            'Assistant Manager (Technical)',
            'Assistant Manager, HR',
            'Assistant Merchandiser',
            'Assistant Polyman',
            'Assistant W.T.P',
            'Assort Man',
            'Asst Engineer',
            // ... [TRUNCATED FOR BREVITY]
            'Welfare Executive',
            'Welfare Officer',
        ];

        foreach ($designations as $name) {
            Designation::create(['name' => $name]);
        }
    }
}
