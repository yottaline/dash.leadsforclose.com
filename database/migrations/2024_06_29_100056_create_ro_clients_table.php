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
        Schema::create('ro_clients', function (Blueprint $table) {
            $table->integer('ro_id', true, true);
            $table->string('ro_code', 8);
            $table->string('ro_fullName', 120);
            $table->string('ro_email', 120);
            $table->string('ro_phone', 15);
            $table->boolean('ro_active')->default('1');
            $table->dateTime('ro_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ro_clients');
    }
};