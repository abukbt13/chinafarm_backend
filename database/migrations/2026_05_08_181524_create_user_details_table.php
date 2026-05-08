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
        Schema::create('user_details', function (Blueprint $table) {

            $table->id();

            // relationship to users table
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // phone number
            $table->string('phone')->nullable();

            // profile image
            $table->string('image')->nullable();

            // user location
            $table->string('location')->nullable();

            // privacy status
            // 1 = private
            // 0 = public
            $table->boolean('privacy')
                ->nullable()
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
