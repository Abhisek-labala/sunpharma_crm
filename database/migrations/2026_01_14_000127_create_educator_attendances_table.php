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
        Schema::create('educator_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('educator_id');
            $table->date('date');
            $table->time('in_time');
            $table->time('out_time')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();
            $table->foreign('educator_id')->references('id')->on('common.users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educator_attendances');
    }
};
