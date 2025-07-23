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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('date');
            $table->integer('amount');

            $table->foreignId('farming_progress_id')
                ->constrained('farming_progress')
                ->onDelete('cascade'); // Optional: auto-delete expenses if the progress is deleted

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade'); // Optional: cascade on user delete

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
