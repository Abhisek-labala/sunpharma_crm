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
        Schema::table('public.patient_details', function (Blueprint $table) {
            $table->string('patient_city')->nullable();
        });

        Schema::table('public.patient_medication_details', function (Blueprint $table) {
            $table->string('metabolic_age')->nullable();
            $table->text('co_morbidities')->nullable();
            $table->string('waist_circumference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public.patient_details', function (Blueprint $table) {
            $table->dropColumn('patient_city');
        });

        Schema::table('public.patient_medication_details', function (Blueprint $table) {
            $table->dropColumn(['metabolic_age', 'co_morbidities', 'waist_circumference']);
        });
    }
};
