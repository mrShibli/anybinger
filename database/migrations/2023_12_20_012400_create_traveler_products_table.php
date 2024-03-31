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
        Schema::create('traveler_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('traveler_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_request_id')->constrained()->cascadeOnDelete();
            $table->enum('status',['confirmed','pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveler_products');
    }
};
