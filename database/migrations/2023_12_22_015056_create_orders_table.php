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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('invoice_id');
            $table->integer('custom_amount')->default(0);
            $table->enum('payment_type', ['half', 'full', 'custom'])->default('custom');
            $table->double('discount',2)->nullable();
            $table->string('discount_code')->nullable();
            $table->double('fees',2)->nullable();
            $table->double('total',2);
            $table->double('paid',2)->nullable();
            $table->string('notes')->nullable();
            $table->string('admin_notes')->nullable();
            $table->enum('status',['pending','pending_payment','approved', 'flight', 'in_country', 'delivering', 'delivered', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
