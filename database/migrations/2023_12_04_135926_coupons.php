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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('type', ['fixed', 'percentage']);
            $table->integer('min_amount')->nullable();
            $table->decimal('discount_amount', 10,2);
            $table->integer('max_usage')->nullable();
            $table->date('expire_date')->nullable();
            $table->enum('status', ['pending', 'published'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
