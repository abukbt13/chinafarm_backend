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
        Schema::table('planting_suggestions', function (Blueprint $table) {

            // Rename column
            $table->renameColumn('factor', 'reason');
            $table->renameColumn('period', 'planting_month');

            // Add new columns
            $table->string('harvesting_month')->after('planting_month');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planting_suggestions', function (Blueprint $table) {
            //Revert rename
        $table->renameColumn('reason', 'factor');
        $table->renameColumn('planting_month', 'period');
             // Drop added columns
        $table->dropColumn('harvesting_month');
        });
    }
};
