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
        Schema::create('common.cities', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->string('city_code')->nullable();
            $table->unsignedBigInteger('state_code')->nullable(); // Changed to integer for state ID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common.cities');
    }
};
