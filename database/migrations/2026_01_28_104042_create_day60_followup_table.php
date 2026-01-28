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
        Schema::create('public.day60_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day60_meds')->nullable();
            $table->text('day60_meds_reason')->nullable();
            $table->string('day60_bp')->nullable();
            $table->string('day60_bp_value')->nullable();
            $table->string('day60_rbs')->nullable();
            $table->string('day60_rbs_value')->nullable();
            $table->string('day60_weight')->nullable();
            $table->string('day60_hba1c')->nullable();
            $table->string('day60_hba1c_value')->nullable();
            $table->string('day60_hba1c_last')->nullable();
            $table->string('day60_challenges')->nullable();
            $table->text('day60_challenges_reason')->nullable();
            $table->string('day60_monitor')->nullable();
            $table->text('day60_monitor_reason')->nullable();
            $table->string('day60_water')->nullable();
            $table->string('day60_urine')->nullable();
            $table->text('day60_questions')->nullable();
            $table->text('day60_help')->nullable();
            $table->string('day60_doctor')->nullable();
            $table->text('day60_doctor_reason')->nullable();
            $table->text('day60_yoga_remark')->nullable();
            $table->text('callremark_60')->nullable();
            $table->text('callconnect_subremark_60')->nullable();
            $table->text('noresponse_subremark_60')->nullable();
            $table->text('day60_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day60_followup');
    }
};
