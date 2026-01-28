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
        Schema::create('public.day30_followup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('day30_meds')->nullable();
            $table->text('day30_meds_reason')->nullable();
            $table->string('day30_stock')->nullable();
            $table->text('day30_changes')->nullable();
            $table->string('day30_bp')->nullable();
            $table->string('day30_bp_value')->nullable();
            $table->string('day30_weight')->nullable();
            $table->string('day30_rbs')->nullable();
            $table->string('day30_rbs_value')->nullable();
            $table->text('day30_rbs_reason')->nullable();
            $table->string('day30_fluid')->nullable();
            $table->string('day30_urine')->nullable();
            $table->string('day30_breathless')->nullable();
            $table->string('day30_yoga')->nullable();
            $table->text('day30_yoga_reason')->nullable();
            $table->text('callremark_30')->nullable();
            $table->text('callconnect_subremark_30')->nullable();
            $table->text('noresponse_subremark_30')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('day30_ae_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.day30_followup');
    }
};
