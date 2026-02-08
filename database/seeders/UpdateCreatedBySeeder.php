<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateCreatedBySeeder extends Seeder
{
    public function run()
    {
        $users = User::all(); // Assuming users table has data

        foreach ($users as $user) {
            DB::table('salary_grades')->whereNull('created_by')->update([
                'created_by' => $user->id,
            ]);
        }
    }
}
