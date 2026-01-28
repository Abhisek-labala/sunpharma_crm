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
        Schema::create('patient_medication_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('waist_circumference', 8, 2)->nullable();
            $table->decimal('bmi', 8, 2)->nullable();
            $table->decimal('waist_to_height_ratio', 8, 2)->nullable();
            $table->integer('metabolic_age')->nullable();
            $table->text('co_morbidities')->nullable();
            $table->text('remark')->nullable();
            $table->date('date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medication_details');
    }
};
