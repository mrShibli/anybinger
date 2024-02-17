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
        Schema::create('youtube_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('feedback1')->nullable();
            $table->string('shopper1')->nullable();
            $table->string('feedback2')->nullable();
            $table->string('shopper2')->nullable();
            $table->string('feedback3')->nullable();
            $table->string('shopper3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_feedbacks');
    }
};
