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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->integer('balance')->default(0);
            $table->enum('user_access', ['user', 'dealer', 'traveler'])->default('user');
            $table->string('password');
            $table->string('google_id')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->string('token')->nullable();
            $table->string('reset_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['normal', 'suspended'])->default('normal');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zone')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
