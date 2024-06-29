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
        Schema::create('r_attachments', function (Blueprint $table) {
            $table->integer('attach_id', true, true);
            $table->string('attach_file', 70);
            $table->integer('attach_reClient')->unsigned();
            $table->dateTime('attach_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_attachments');
    }
};