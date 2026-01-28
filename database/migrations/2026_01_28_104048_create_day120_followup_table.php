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
        Schema::create('public.day120_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day120_meds')->nullable();
            $table->text('day120_meds_reason')->nullable();
            $table->string('day120_bp')->nullable();
            $table->string('day120_bp_value')->nullable();
            $table->string('day120_rbs')->nullable();
            $table->string('day120_rbs_value')->nullable();
            $table->string('day120_weight')->nullable();
            $table->string('day120_hba1c')->nullable();
            $table->string('day120_hba1c_value')->nullable();
            $table->string('day120_hba1c_last')->nullable();
            $table->string('day120_challenges')->nullable();
            $table->text('day120_challenges_reason')->nullable();
            $table->string('day120_monitor')->nullable();
            $table->text('day120_monitor_reason')->nullable();
            $table->string('day120_water')->nullable();
            $table->string('day120_urine')->nullable();
            $table->text('day120_questions')->nullable();
            $table->text('day120_help')->nullable();
            $table->string('day120_doctor')->nullable();
            $table->text('day120_doctor_reason')->nullable();
            $table->text('day120_yoga_remark')->nullable();
            $table->text('callremark_120')->nullable();
            $table->text('callconnect_subremark_120')->nullable();
            $table->text('noresponse_subremark_120')->nullable();
            $table->text('day120_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day120_followup');
    }
};
