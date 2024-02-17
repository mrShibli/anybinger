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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('category_id')->index();
            $table->foreignId('subcategory_id')->nullable()->index();
            $table->foreignId('brand_id')->nullable()->index();
            $table->double('price', 10,2);
            $table->double('compare_price', 10,2)->nullable();
            $table->string('short_description');
            $table->longText('description');
            $table->string('tags');
            $table->string('meta_keyword');
            $table->string('meta_description');
            $table->enum('track_quantity', ['Yes', 'No'])->default('No');
            $table->integer('quantity')->nullable();
            $table->enum('status', ['pending', 'published'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
