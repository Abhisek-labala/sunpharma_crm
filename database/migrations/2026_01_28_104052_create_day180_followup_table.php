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
        Schema::create('public.day180_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->text('feeling_now')->nullable();
            $table->string('yoga_helpful')->nullable();
            $table->text('yoga_feedback')->nullable();
            $table->string('instructor_support')->nullable();
            $table->text('instructor_feedback')->nullable();
            $table->string('diet_impact')->nullable();
            $table->text('diet_feedback')->nullable();
            $table->string('dietician_access')->nullable();
            $table->text('dietician_feedback')->nullable();
            $table->integer('overall_experience')->nullable();
            $table->text('experience_remarks')->nullable();
            $table->text('final_feedback')->nullable();
            $table->text('callremark_180')->nullable();
            $table->text('callconnect_subremark_180')->nullable();
            $table->text('noresponse_subremark_180')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('day180_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day180_followup');
    }
};
