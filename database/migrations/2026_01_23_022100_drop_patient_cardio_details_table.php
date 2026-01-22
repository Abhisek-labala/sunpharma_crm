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
        Schema::dropIfExists('patient_cardio_details');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate table structure if needed to rollback
        Schema::create('patient_cardio_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('date_of_discharge')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('urea')->nullable();
            $table->string('lv_ef')->nullable();
            $table->string('heart_rate')->nullable();
            $table->string('nt_pro_bnp')->nullable();
            $table->string('egfr')->nullable();
            $table->string('potassium')->nullable();
            $table->string('sodium')->nullable();
            $table->string('uric_acid')->nullable();
            $table->string('creatinine')->nullable();
            $table->string('crp')->nullable();
            $table->string('uacr')->nullable();
            $table->string('iron')->nullable();
            $table->string('hb')->nullable();
            $table->string('ldl')->nullable();
            $table->string('hdl')->nullable();
            $table->string('triglycerid')->nullable();
            $table->string('total_cholesterol')->nullable();
            $table->string('hba1c')->nullable();
            $table->string('sgot')->nullable();
            $table->string('sgpt')->nullable();
            $table->string('vit_d')->nullable();
            $table->string('sglt2_inhibitors')->nullable();
            $table->string('hypertension_angina_ckd')->nullable();
            $table->string('anti_diabetic_therapy')->nullable();
            $table->string('t3')->nullable();
            $table->string('t4')->nullable();
            $table->date('date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
};
