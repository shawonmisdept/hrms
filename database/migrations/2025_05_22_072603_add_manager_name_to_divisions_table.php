<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->string('manager_name')->nullable()->after('manager_id');
        });
    }

    public function down()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('manager_name');
        });
    }
};
