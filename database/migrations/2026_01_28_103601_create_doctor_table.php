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
        Schema::create('public.doctor', function (Blueprint $table) {
            $table->id();
            $table->string('msl_code')->nullable();
            $table->string('name');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('status')->nullable();
            $table->string('zone')->nullable();
            $table->string('speciality')->nullable();
            $table->date('first_visit')->nullable();
            $table->unsignedBigInteger('educator_id')->nullable();
            $table->string('consent_form_file')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.doctor');
    }
};
