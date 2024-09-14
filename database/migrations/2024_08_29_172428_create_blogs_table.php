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
        Schema::create('blogs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name_en')->unique();
            $table->string('name_fa')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->longText('content')->nullable();
            $table->json('keywords')->nullable();
            $table->json('images')->nullable();
            $table->json('tags')->nullable();
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('category_id')->constrained();
            $table->foreignUuid('sub_category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
