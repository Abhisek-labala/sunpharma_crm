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
        Schema::create('public.patient_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->unsignedBigInteger('educator_id')->nullable();
            $table->unsignedBigInteger('digital_educator_id')->nullable();
            $table->unsignedBigInteger('camp_id')->nullable();
            $table->unsignedBigInteger('hcp_id')->nullable();
            $table->string('patient_name')->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('medicine')->nullable();
            $table->string('medicine_header')->nullable();
            $table->string('compititor')->nullable();
            $table->string('consent_form_file')->nullable();
            $table->string('prescription_file')->nullable();
            $table->string('cipla_brand_prescribed')->nullable();
            $table->date('date')->nullable();
            $table->string('approved_status')->nullable();
            $table->string('patient_city')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.patient_details');
    }
};
