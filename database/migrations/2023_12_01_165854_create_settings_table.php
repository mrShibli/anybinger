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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('logo')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('delivery_dhaka')->nullable()->default(0);
            $table->integer('delivery_outside')->nullable()->default(0);
            $table->string('banner_title')->nullable();
            $table->string('banner_paragraph')->nullable();
            $table->string('banner_link')->nullable();
            $table->string('banner_btn')->nullable();
            $table->string('banner_image')->nullable();
            $table->text('footer_desc')->nullable();
            $table->string('service_phone')->nullable();
            $table->string('service_email')->nullable();
            $table->string('office_time')->nullable();
            $table->string('office_location')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('more_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
