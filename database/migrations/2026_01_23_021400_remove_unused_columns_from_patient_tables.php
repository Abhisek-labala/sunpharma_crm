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
        // Remove columns from patient_details table
        Schema::table('patient_details', function (Blueprint $table) {
            $table->dropColumn([
                'patient_enrolled',
                'patient_kit_enrolled',
                'cipla_brand_prescribed_no_option',
                'prescription_available',
                'purchase_bill'
            ]);
        });

        // Remove columns from patient_medication_details table
        Schema::table('patient_medication_details', function (Blueprint $table) {
            $table->dropColumn([
                'arni',
                'b_blockers',
                'mra',
                'arni_remark',
                'b_blockers_remark',
                'mra_remark',
                'waist_circumference_remark',
                'vaccination',
                'influenza',
                'pneumococcal',
                'cardiac_rehab',
                'nsaids_use',
                'patient_kit_given',
                'exercise_30mins',
                'breakfast_days',
                'food_habits',
                'sedentary_hours',
                'type_2_dm',
                'hypertension',
                'dyslipidemia',
                'pco',
                'knee_pain',
                'asthma',
                'adl_bathing',
                'adl_dressing',
                'adl_walking',
                'adl_toileting'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add columns to patient_details table
        Schema::table('patient_details', function (Blueprint $table) {
            $table->string('patient_enrolled')->nullable();
            $table->string('patient_kit_enrolled')->nullable();
            $table->string('cipla_brand_prescribed_no_option')->nullable();
            $table->string('prescription_available')->nullable();
            $table->string('purchase_bill')->nullable();
        });

        // Re-add columns to patient_medication_details table
        Schema::table('patient_medication_details', function (Blueprint $table) {
            $table->string('arni')->nullable();
            $table->string('b_blockers')->nullable();
            $table->string('mra')->nullable();
            $table->text('arni_remark')->nullable();
            $table->text('b_blockers_remark')->nullable();
            $table->text('mra_remark')->nullable();
            $table->text('waist_circumference_remark')->nullable();
            $table->string('vaccination')->nullable();
            $table->string('influenza')->nullable();
            $table->string('pneumococcal')->nullable();
            $table->string('cardiac_rehab')->nullable();
            $table->string('nsaids_use')->nullable();
            $table->string('patient_kit_given')->nullable();
            $table->string('exercise_30mins')->nullable();
            $table->string('breakfast_days')->nullable();
            $table->string('food_habits')->nullable();
            $table->string('sedentary_hours')->nullable();
            $table->string('type_2_dm')->nullable();
            $table->string('hypertension')->nullable();
            $table->string('dyslipidemia')->nullable();
            $table->string('pco')->nullable();
            $table->string('knee_pain')->nullable();
            $table->string('asthma')->nullable();
            $table->string('adl_bathing')->nullable();
            $table->string('adl_dressing')->nullable();
            $table->string('adl_walking')->nullable();
            $table->string('adl_toileting')->nullable();
        });
    }
};
