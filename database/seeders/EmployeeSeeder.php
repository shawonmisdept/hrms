<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            [
                'employee_code' => 'EMP001',
                'name' => 'Shawonoor Rahman',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP002',
                'name' => 'Afrin Rahman',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP003',
                'name' => 'Farzana Kazi',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP004',
                'name' => 'Hasan',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP005',
                'name' => 'Ela',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP006',
                'name' => 'Biplob',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP007',
                'name' => 'Alif',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP008',
                'name' => 'Mone',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP009',
                'name' => 'Sohor Banu',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP010',
                'name' => 'Rabeya',
                'status' => 1,
            ],
            [
                'employee_code' => 'EMP011',
                'name' => 'Sadiya',
                'status' => 1,
            ],

            // Add more employee records as needed
        ];

        foreach ($employees as $employee) {
            Employee::firstOrCreate(
                ['employee_code' => $employee['employee_code']], // Check for duplicate employee_code
                $employee // Create new employee record if no duplicate
            );
        }
    }
}
