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
        Schema::create('travelers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('out_cunt_num');
            $table->string('bd_number');
            $table->string('barth');
            $table->string('out_address');
            $table->string('bd_address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('passport');
            $table->enum('status',['pending','cancelled','approve'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travelers');
    }
};
