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
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_id')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('provider_token')->nullable();
            $table->string('provider_refresh_token')->nullable();
            $table->string('lang')->default('en');
            $table->boolean('has_self')->default(false);
            $table->boolean('use_self')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'provider_id',
                'provider_name',
                'provider_token',
                'provider_refresh_token',
                'has_self',
                'use_self',
            ]);
        });
    }
};
