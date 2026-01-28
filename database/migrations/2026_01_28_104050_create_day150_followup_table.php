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
        Schema::create('public.day150_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day150_meds')->nullable();
            $table->text('day150_meds_reason')->nullable();
            $table->string('day150_stock')->nullable();
            $table->text('day150_changes')->nullable();
            $table->string('day150_bp')->nullable();
            $table->string('day150_bp_value')->nullable();
            $table->string('day150_weight')->nullable();
            $table->string('day150_rbs')->nullable();
            $table->string('day150_rbs_value')->nullable();
            $table->text('day150_rbs_reason')->nullable();
            $table->string('day150_fluid')->nullable();
            $table->string('day150_urine')->nullable();
            $table->string('day150_breathless')->nullable();
            $table->string('day150_yoga')->nullable();
            $table->text('day150_yoga_reason')->nullable();
            $table->text('callremark_150')->nullable();
            $table->text('callconnect_subremark_150')->nullable();
            $table->text('noresponse_subremark_150')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('day150_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day150_followup');
    }
};
