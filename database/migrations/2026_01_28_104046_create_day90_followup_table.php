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
        Schema::create('public.day90_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day90_meds')->nullable();
            $table->text('day90_meds_reason')->nullable();
            $table->string('day90_doctor')->nullable();
            $table->text('day90_doctor_reason')->nullable();
            $table->string('day90_bp')->nullable();
            $table->string('day90_bp_value')->nullable();
            $table->text('day90_bp_remarks')->nullable();
            $table->string('day90_weight')->nullable();
            $table->string('day90_breathless')->nullable();
            $table->string('day90_yoga_schedule')->nullable();
            $table->text('day90_yoga_schedule_reason')->nullable();
            $table->string('day90_yoga_tried')->nullable();
            $table->string('day90_yoga_difficult')->nullable();
            $table->text('day90_yoga_difficult_reason')->nullable();
            $table->string('day90_yoga_required')->nullable();
            $table->date('day90_yoga_planned_date')->nullable();
            $table->text('day90_yoga_required_reason')->nullable();
            $table->text('callremark_90')->nullable();
            $table->text('callconnect_subremark_90')->nullable();
            $table->text('noresponse_subremark_90')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('day90_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day90_followup');
    }
};
