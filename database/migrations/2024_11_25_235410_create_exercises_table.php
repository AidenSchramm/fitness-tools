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
        Schema::create('exercises', function (Blueprint $table) {
                $table->uuid('exercise_id')->primary();
                $table->uuid('workout_id');
                $table->string('name');
                $table->text('desc')->nullable();
                $table->integer('sets');
                $table->integer('reps');
                $table->time('duration')->nullable();
                $table->timestamps();

                $table->foreign('workout_id')->references('workout_id')->on('workouts')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
