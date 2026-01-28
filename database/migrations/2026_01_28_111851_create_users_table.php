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
        Schema::create('common.users', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('user_name')->unique();
            $table->string('password');
            $table->string('raw_password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_pic')->nullable();
            $table->unsignedBigInteger('rm_pm_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->string('role')->nullable(); // counsellor, digitalcounsellor, nc, admin
            $table->unsignedBigInteger('digital_educator_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common.users');
    }
};
