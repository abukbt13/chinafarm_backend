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
        Schema::create('crop_returns', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to farming progress or season
            $table->foreignId('farming_progress_id')->constrained('farming_progress')->onDelete('cascade');

            // Core return details
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2); // Earnings amount
            $table->date('date'); // Date of the return

            // Optional: track who added it
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_returns');
    }
};
