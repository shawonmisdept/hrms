<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
            Schema::table('sections', function (Blueprint $table) {
                $table->string('manager_email')->nullable()->after('manager_id');
                $table->string('manager_phone')->nullable()->after('manager_email');
            });
        }

        public function down(): void
        {
            Schema::table('sections', function (Blueprint $table) {
                $table->dropColumn(['manager_email', 'manager_phone']);
            });
        }
};
