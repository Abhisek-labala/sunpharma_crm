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
        Schema::create('common.rm_users', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->nullable();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('raw_password')->nullable();
            $table->string('role')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common.rm_users');
    }
};
