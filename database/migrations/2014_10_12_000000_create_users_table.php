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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('user_code', 8);
            $table->string('user_name', 120);
            $table->string('user_email', 120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_password', 255);
            $table->boolean('user_active')->default('1');
            $table->dateTime('user_modified')->nullable();
            $table->integer('user_modified_by')->nullable();
            $table->rememberToken();
            $table->dateTime('user_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};