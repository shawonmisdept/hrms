<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateCreatedByColumn extends Command
{
    protected $signature = 'update:created_by';
    protected $description = 'Update the created_by column for all salary grades';

    public function handle()
    {
        $users = User::all(); // Assuming users table has data

        foreach ($users as $user) {
            DB::table('salary_grades')->whereNull('created_by')->update([
                'created_by' => $user->id,
            ]);
        }

        $this->info('Created_by column updated successfully!');
    }
}
