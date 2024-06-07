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
        Schema::create('wish_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id')->index();
            $table->string('name')->index();
            $table->longText('description')->nullable();
            $table->string('share')->unique()->nullable();
            $table->string('image')->nullable();
            $table->enum('visibility',['public','protected','private'])->default('public')->index();
            $table->enum('status',['pending', 'completed'])->default('pending')->index();
            $table->unique(['name', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wish_lists');
    }
};
