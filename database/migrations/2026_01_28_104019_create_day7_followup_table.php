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
        Schema::create('public.day7_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day7_meds')->nullable();
            $table->text('day7_meds_reason')->nullable();
            $table->string('day7_doctor')->nullable();
            $table->text('day7_doctor_reason')->nullable();
            $table->string('day7_bp')->nullable();
            $table->string('day7_bp_value')->nullable();
            $table->text('day7_bp_remarks')->nullable();
            $table->string('day7_weight')->nullable();
            $table->string('day7_breathless')->nullable();
            $table->string('day7_yoga_schedule')->nullable();
            $table->text('day7_yoga_schedule_reason')->nullable();
            $table->string('day7_yoga_tried')->nullable();
            $table->string('day7_yoga_difficult')->nullable();
            $table->text('day7_yoga_difficult_reason')->nullable();
            $table->string('day7_yoga_required')->nullable();
            $table->date('day7_yoga_planned_date')->nullable();
            $table->text('day7_yoga_required_reason')->nullable();
            $table->text('callremark_7')->nullable();
            $table->text('callconnect_subremark_7')->nullable();
            $table->text('noresponse_subremark_7')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('day7_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day7_followup');
    }
};
