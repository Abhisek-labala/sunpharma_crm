<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rm_attendances');
        Schema::dropIfExists('educator_attendances');

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Polymorphic columns: authenticatable_type and authenticatable_id
            $table->unsignedBigInteger('authenticatable_id');
            $table->string('authenticatable_type');
            
            $table->string('role')->nullable()->index(); // Store role for easy filtering
            
            $table->date('date');
            $table->time('in_time');
            $table->time('out_time')->nullable();
            
            $table->string('ip_address')->nullable();
            
            // Location
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            
            $table->timestamps();

            $table->index(['authenticatable_id', 'authenticatable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
