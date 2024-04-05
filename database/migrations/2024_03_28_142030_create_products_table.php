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
            $table->id('product_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->string('name');
            $table->string('description');
            $table->text('photo')->nullable();
            $table->integer('price');
            $table->integer('count')->nullable();
            $table->boolean('is_used');
            $table->integer('views')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->foreign('manufacturer_id')->references('manufacturer_id')->on('manufacturers');
            $table->foreign('model_id')->references('model_id')->on('car_models');
            $table->foreign('generation_id')->references('generation_id')->on('model_generations');
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
