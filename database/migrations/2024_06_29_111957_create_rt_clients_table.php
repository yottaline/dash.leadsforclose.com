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
        Schema::create('rt_clients', function (Blueprint $table) {
            $table->integer('rt_id', true, true);
            $table->string('rt_code', 8);
            $table->string('rt_firstName', 100);
            $table->string('rt_lastName', 100);
            $table->string('rt_email', 120);
            $table->string('rt_phone', 25);
            $table->integer('rt_umberSeats')->unsigned();
            $table->string('rt_state', 255);
            $table->boolean('rt_status')->default('1');
            $table->dateTime('rt_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt_clients');
    }
};