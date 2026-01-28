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
        Schema::create('public.day15_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day15_meds')->nullable();
            $table->text('day15_meds_reason')->nullable();
            $table->string('day15_stock')->nullable();
            $table->text('day15_changes')->nullable();
            $table->string('day15_bp')->nullable();
            $table->string('day15_bp_value')->nullable();
            $table->string('day15_weight')->nullable();
            $table->string('day15_rbs')->nullable();
            $table->string('day15_rbs_value')->nullable();
            $table->text('day15_rbs_reason')->nullable();
            $table->string('day15_fluid')->nullable();
            $table->string('day15_urine')->nullable();
            $table->string('day15_breathless')->nullable();
            $table->string('day15_yoga')->nullable();
            $table->text('day15_yoga_reason')->nullable();
            $table->text('callremark_15')->nullable();
            $table->text('callconnect_subremark_15')->nullable();
            $table->text('noresponse_subremark_15')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('day15_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day15_followup');
    }
};
