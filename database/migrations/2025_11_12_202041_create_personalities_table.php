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
        Schema::create('personalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('gender', ['male', 'female']);
            $table->integer('age');
            $table->float('weight');
            $table->float('height');
            $table->enum('activity_level', [
            'sedentary',
            'light',
            'moderate',
            'active',
            'very_active'
            ])->default('sedentary');
            $table->float('bmr')->nullable();
            $table->float('tdee')->nullable();
            $table->enum('goal', [
            'maintain',
            'lose_weight',
            'gain_weight'
            ])->default('maintain');
            $table->string('diet_type')->nullable();
            $table->json('allergies')->nullable();
            $table->json('health_goals')->nullable();
            $table->string('religion')->nullable();
            $table->json('custom_preferences')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalities');
    }
};
