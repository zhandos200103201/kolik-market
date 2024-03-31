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
        Schema::create('model_generations', function (Blueprint $table) {
            $table->id('generation_id');
            $table->unsignedBigInteger('model_id');
            $table->string('start_year')->nullable();
            $table->string('end_year')->nullable();
            $table->timestamps();

            $table->foreign('model_id')->references('model_id')->on('car_models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_generations');
    }
};
