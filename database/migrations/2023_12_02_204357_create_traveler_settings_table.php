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
        Schema::create('traveler_settings', function (Blueprint $table) {
            $table->id();
            $table->string('traveler_heading')->nullable();
            $table->string('traveler_desc')->nullable();
            $table->string('traveling_terms')->nullable();
            $table->string('traveler_banner')->nullable();
            $table->string('traveler_earn')->nullable();
            $table->string('traveler_max_earn')->nullable();
            $table->string('youtube_title')->nullable();
            $table->string('youtube_video')->nullable();
            $table->string('title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveler_settings');
    }
};
